<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;
use App\Http\Requests\Account\StoreFactura;
use App\Http\Requests\Account\UpdateFactura;
use App\Models\Store;
use App\Models\Product;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\ProductChild;
use App\Models\Currency;
use App\Models\TempPaymentItem;
use App\Models\RunOutSell;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class FacturaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private Factura $factura;
    private $limit = 10;
    private User $user;

    function __construct(Factura $factura)
    {
        $this->factura = $factura;
        // Injeção de dependência do usuário autenticado no construtor
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
        $this->middleware(['auth']);
    }



    public function index(Request $request)
    {
        return view('factura.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectCustomer()
    {
        $accounts = Factura::latest()->take($this->limit)->get();
        return view('factura.select_customer', compact('accounts'));
    }

    public function create()
    {
        Gate::allows('show', Factura::class);
        return view('factura.create', ['today' => today()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Account\StoreFactura  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFactura $request)
    {
        DB::beginTransaction();
        try {
            // Usando $this->user injetado no construtor
            $items = $this->user->temp_items;

            $subtotal = $items->sum('subtotal');
            $discount = $request->discount;

            // Tratamento de divisão por zero
            $discountp = $subtotal > 0 ? ($discount / $subtotal * 100) : 0;

            $request->merge([
                "subtotal" => $subtotal,
                "discountp" => $discountp,
                "total" => round($subtotal - $discount)
            ]);

            $runOutItems = [];
            $store = Store::find($request->store_id);

            // --- FASE 1: VERIFICAÇÃO DE ESTOQUE COM BLOQUEIO PESSIMISTA ---

            if ($store == null) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('falha', __('messages.sale.request_store'));
            }

            foreach ($items as $item) {
                if ($item->quantity > 0) {
                    $product = Product::find($item->product_id);

                    if (!$product || !$product->category->checkStock) {
                        continue; // Não checar ou produto não encontrado
                    }

                    $productParent = ProductChild::where('child', $item->product_id)->first();
                    $stockProductId = $productParent != null ? $productParent->parent : $item->product_id;
                    $quantityNeeded = $productParent != null ? ($item->quantity * $productParent->quantity) : $item->quantity;

                    // BLOQUEIO PESSIMISTA: lockForUpdate() garante que a linha Stock não será alterada 
                    // por outro processo enquanto a transação estiver ativa.
                    $stock = Stock::where('product_id', $stockProductId)
                        ->where('store_id', $store->id)
                        ->lockForUpdate() // BLOQUEIO AQUI
                        ->first();

                    $resto = $stock != null ? $stock->quantity : 0;

                    if ($stock == null) {
                        DB::rollBack();
                        return redirect()->back()->withInput()->with(['falha' => __('messages.sale.request_stock') . " {$product->name} - [$resto] {$store->name}."]);
                    }

                    if ($quantityNeeded > $stock->quantity) {
                        $runOutItems[] = [
                            'quantity_available' => $stock->quantity,
                            'barcode' => $item->barcode,
                            'product_id' => $item->product_id,
                            'name' => $item->name,
                            'quantity' => $item->quantity,
                            'unitprice' => $item->unitprice,
                            'rate' => $item->rate,
                            'subtotal' => $item->subtotal,
                        ];
                    }
                }
            }

            // ... (Validações de cliente e total)
            if ($request->customer_name == null) {
                DB::rollBack();
                return redirect()->back()->withInput()->with(['falha' => __('messages.sale.request_name')]);
            }
            if ($request->total <= 0) {
                DB::rollBack();
                return redirect()->back()->withInput()->with(['falha' => __('messages.sale.request_items')]);
            }

            // --- FASE 2: CRIAÇÃO DA FATURA E ATUALIZAÇÃO ATÔMICA DO ESTOQUE ---

            $factura = $this->factura->create($request->all());

            foreach ($items as $item) {
                if ($item->quantity > 0) {
                    $data = [
                        'barcode' => $item->barcode,
                        'product_id' => $item->product_id,
                        'name' => $item->name,
                        'quantity' => $item->quantity,
                        'unitprice' => $item->unitprice,
                        'rate' => $item->rate,
                        'subtotal' => $item->subtotal,
                    ];

                    $productParent = ProductChild::where('child', $item->product_id)->first();
                    $stockProductId = $productParent != null ? $productParent->parent : $item->product_id;
                    $quantityToDecrement = $productParent != null ? ($item->quantity * $productParent->quantity) : $item->quantity;

                    // Re-obter o Stock (já bloqueado na fase 1)
                    $stockQuery = Stock::where('product_id', $stockProductId)->where('store_id', $store->id);

                    // ATUALIZAÇÃO ATÔMICA: Usar decrement() para evitar race conditions
                    // A operação de decremento e a escrita da operação são feitas em uma única query
                    $stockQuery->decrement('quantity', $quantityToDecrement, [
                        'operation' => "Venda: {$factura->id}"
                    ]);

                    $factura->items()->create($data);
                    $item->delete(); // Remove o item temporário

                    //Add Quantity of saled product
                    if ($productParent != null) {
                        // Não há necessidade de bloqueio aqui, mas pode usar incremento atômico se houver concorrência
                        $productParent->sales += $item->quantity;
                        $productParent->update();
                    }
                }
            }

            //saving Runout
            foreach ($runOutItems as $item) {
                $item["factura_id"] = $factura->id;
                RunOutSell::create($item);
            }

            DB::commit(); // COMMIT libera o bloqueio pessimista
            $request->session()->forget('items');
            $request->session()->forget('item');
            return redirect()->route('factura.show', $factura->id)->with(['sucesso' => __('messages.prompt.request_done')]);
        } catch (\Exception $e) {
            DB::rollback(); // ROLLBACK libera o bloqueio pessimista
            // Em ambiente de produção, não retorne $e->getMessage() diretamente.
            return redirect()->back()->with(['falha' => __('messages.prompt.request_failure') . ' : ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function show(Factura $factura)
    {
        return view('factura.show', compact('factura'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function edit(Factura $factura)
    {
        return view('factura.edit', compact('factura'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Factura\UpdateFactura  $request
     * @param  \App\Models\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFactura $request, Factura $factura)
    {
        $factura->day = $request->day;
        $factura->account_id = $request->account_id;
        $factura->factura = $request->factura;
        $factura->debit = $request->debit;
        $factura->balance = $request->balance;
        $factura->discount = $request->discount;
        $update = $factura->update();
        if ($update) {
            return redirect()->route('factura.show', $factura->id)->with(['sucesso' => __('messages.prompt.request_done')]);
        } else {
            return redirect()->back()->with(['falha' => __('messages.prompt.request_failure')]);
        }
    }

    public function askDestroy(Request $request, $id)
    {
        $factura = $this->factura->findOrfail($id);

        $factura->destroy_date = Carbon::now();
        $factura->destroy_username = $request->destroy_username;
        $factura->destroy_reason = $request->destroy_reason;
        $update = $factura->update();
        if ($update) {
            return redirect()->route('factura.show', $factura->id)->with(['sucesso' => __('messages.prompt.request_done')]);
        } else {
            return redirect()->back()->with(['falha' => __('messages.prompt.request_failure')]);
        }
    }

    public function cancelAskDestroy(Request $request, $id)
    {
        $factura = $this->factura->findOrfail($id);

        $factura->destroy_date = null;
        $factura->destroy_username = null;
        $factura->destroy_reason = null;
        $update = $factura->update();
        if ($update) {
            return redirect()->route('factura.show', $factura->id)->with(['sucesso' => __('messages.prompt.request_done')]);
        } else {
            return redirect()->back()->with(['falha' => __('messages.prompt.request_failure')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function destroy(Factura $factura)
    {
        DB::beginTransaction();
        try {
            $store = Store::first();

            if ($store == null) {
                DB::rollBack();
                return redirect()->back()->withInput()->with(['info' => 'Seleccione o armazem.']);
            }

            $items = $factura->items;

            foreach ($items as $item) {
                $productParent = ProductChild::where('child', $item->product_id)->first();
                $stockProductId = $productParent != null ? $productParent->parent : $item->product_id;
                $quantityToIncrement = $productParent != null ? ($item->quantity * $productParent->quantity) : $item->quantity;

                // Bloqueio Pessimista na remoção para garantir que o estoque não seja afetado
                $stockQuery = Stock::where('product_id', $stockProductId)
                    ->where('store_id', $store->id)
                    ->lockForUpdate();

                $stock = $stockQuery->first();

                if ($stock != null) {
                    // ATUALIZAÇÃO ATÔMICA: Usar increment() para devolver o estoque
                    $stockQuery->increment('quantity', $quantityToIncrement, [
                        'operation' => "Remoção da Factura Nr: {$factura->id}"
                    ]);
                }

                //Remove Quantity of saled product
                if ($productParent != null) {
                    $productParent->sales -= $item->quantity;
                    $productParent->update();
                }
            }

            /* If its payed it must return the money to the cashier */
            if ($factura->payed) {
                $payment = $factura->payments()->first();
                if ($payment != null) {
                    $cashier = $payment->cashier;
                    // Assumindo que 'present' também deve ser decrementado atomicamente
                    $cashier->decrement('present', $factura->total);
                    $payment->delete();
                }
            }

            $factura->delete();
            DB::commit();
            return redirect()->route('factura.index')->with(['info' => __('messages.prompt.request_done')]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['falha' => __('messages.prompt.request_failure') . ' : ' . $e->getMessage()]);
        }
    }

    public function search(Request $request)
    {
        $dados = $request->all();
        $string = $request->criterio;
        $facturas = $this->factura->where('id', 'LIKE', '%' . $string . '%')
            ->OrWhere('customer_id', 'LIKE', '%' . $string . '%')
            ->OrWhere('customer_name', 'LIKE', '%' . $string . '%')
            ->OrWhere('customer_phone', 'LIKE', '%' . $string . '%')
            ->OrWhere('subtotal', 'LIKE', '%' . $string . '%')
            ->OrWhere('totalrate', 'LIKE', '%' . $string . '%')
            ->OrWhere('discount', 'LIKE', '%' . $string . '%')
            ->OrWhere('total', 'LIKE', '%' . $string . '%')
            ->OrWhere('day', 'LIKE', '%' . $string . '%')
            ->OrWhere('payed', 'LIKE', '%' . $string . '%')
            ->latest()->paginate($this->limit);
        return view('factura.search', compact('dados', 'facturas'));
    }

    public function cancel(Request $request)
    {
        $items = $this->user->temp_items;
        foreach ($items as $item) {
            $item->delete();
        }
        return redirect()->route('factura.create')->with('info', __('messages.item.deleted'));
    }

    public function copy(Request $request, $id)
    {
        $items = $this->factura->find($id)->items;
        foreach ($items as $item) {
            $product = Product::find($item->product_id);
            if ($product != null) {
                $data = [
                    'product_id' => $product->id,
                    'barcode' => $product->barcode,
                    'name' => $product->name,
                    'quantity' => $item->quantity,
                    'unitprice' => $product->price,
                    'rate' => $product->rate,
                    'subtotal' => $product->price * $item->quantity,
                ];
                if ($this->user->temp_items()->where('product_id', $item->product_id)->first() == null) {
                    $this->user->temp_items()->create($data);
                }
            }
        }
        return redirect()->back()->with(['sucesso' => __('messages.item.copied')]);
    }

    public function getDirect()
    {
        $store = Store::first();
        if ($store == null) {
            return redirect()->back()->withInput()->with('info', __('messages.sale.request_store'));
        }
        return view('factura.direct', compact('store'));
    }

    public function postDirect(StoreFactura $request)
    {
        // Embora você tenha código similar, é melhor fatorar a lógica de estoque em um único lugar, 
        // mas aqui mantemos a estrutura original e aplicamos as correções de concorrência.
        DB::beginTransaction();
        try {
            $items = $this->user->temp_items;
            $store = Store::find($request->store_id);

            if ($store == null) {
                DB::rollBack();
                return redirect()->back()->withInput()->with(['info' => __('messages.sale.request_store')]);
            }

            // --- FASE 1: VERIFICAÇÃO DE ESTOQUE COM BLOQUEIO PESSIMISTA ---
            foreach ($items as $item) {
                if ($item->quantity > 0) {
                    $product = Product::find($item->product_id);
                    if (!$product || !$product->category->checkStock) {
                        continue;
                    }

                    $productParent = ProductChild::where('child', $item->product_id)->first();
                    $stockProductId = $productParent != null ? $productParent->parent : $item->product_id;
                    $quantityNeeded = $productParent != null ? ($item->quantity * $productParent->quantity) : $item->quantity;

                    // BLOQUEIO PESSIMISTA: lockForUpdate()
                    $stock = Stock::where('product_id', $stockProductId)
                        ->where('store_id', $store->id)
                        ->lockForUpdate()
                        ->first();

                    $resto = $stock != null ? $stock->quantity : 0;

                    if ($stock == null || $quantityNeeded > $stock->quantity) {
                        DB::rollBack();
                        return redirect()->back()->withInput()->with(['falha' => __('messages.sale.request_stock') . " [$resto] na(o) {$store->name}."]);
                    }
                }
            }

            // ... (Validações de cliente e total)
            if ($request->customer_name == null) {
                DB::rollBack();
                return redirect()->back()->withInput()->with(['falha' => __('messages.sale.request_name')]);
            }
            if ($request->total <= 0) {
                DB::rollBack();
                return redirect()->back()->withInput()->with(['falha' => __('messages.sale.request_items')]);
            }

            // --- FASE 2: CRIAÇÃO DA FATURA, PAGAMENTO E ATUALIZAÇÃO ATÔMICA DO ESTOQUE ---

            $factura = $this->factura->create($request->all());

            if ($factura->payed) {
                // Se a fatura já está marcada como paga (o que não deveria ser o caso se estamos a criar)
                // Usar rollBack
                DB::rollBack();
                return redirect()->back()->withInput()->with(['info' => __('messages.payment.alread_payed')]);
            }

            foreach ($items as $item) {
                $data = [
                    'product_id' => $item->product_id,
                    'name' => $item->name,
                    'quantity' => $item->quantity,
                    'unitprice' => $item->unitprice,
                    'rate' => $item->rate,
                    'subtotal' => $item->subtotal,
                ];

                $productParent = ProductChild::where('child', $item->product_id)->first();
                $stockProductId = $productParent != null ? $productParent->parent : $item->product_id;
                $quantityToDecrement = $productParent != null ? ($item->quantity * $productParent->quantity) : $item->quantity;

                // ATUALIZAÇÃO ATÔMICA
                $stockQuery = Stock::where('product_id', $stockProductId)->where('store_id', $store->id);
                $stockQuery->decrement('quantity', $quantityToDecrement);

                $factura->items()->create($data);
                $item->delete();

                //Add Quantity of saled product
                if ($productParent != null) {
                    $productParent->sales += $item->quantity;
                    $productParent->update();
                }
            }

            // Execute the payment
            if ($request->total > $request->amount) {
                DB::rollBack();
                return redirect()->back()->withInput()->with(['falha' => __('messages.sale.direct.amount')]);
            }

            // Usando $this->user
            $cashier = $this->user->cashier->where('startime', '>=', \Carbon\Carbon::today()->subDays(0))->where('endtime', null)->first();
            $open = ($cashier != null) ? 1 : 0; // Contagem deve ser booleana ou 1

            if ($open == 0) {
                DB::rollBack();
                return redirect()->back()->withInput()->with(['falha' => "O Caixa não foi aberto! "]);
            }

            // Creating a payment items
            $paymentitem = new TempPaymentItem();
            $paymentitem->way = $request->way;
            $paymentitem->reference = $request->reference;
            $paymentitem->amount = $request->amount;
            $paymentitem->exchanged = ($request->amount - $request->total);
            $paymentitem->currency_id = $request->currency_id;
            $paymentitem->currency = $request->currency_id == 0 ? 'MT' : Currency::find($request->currency_id ?? 0)->name;
            $this->user->temp_payment_items()->save($paymentitem);

            // Resolvendo items
            $data = [
                'topay' => $request->total,
                'payed' => $request->amount,
                'change' => ($request->amount - $request->total),
                'day' => date('Y-m-d'),
                'cashier_id' => $cashier->id
            ];
            $factura->payed = true;
            $factura->save();

            $paymentitems = $this->user->temp_payment_items;
            $payment = $factura->payments()->create($data);

            foreach ($paymentitems as $paymentitem) {
                $data2 = [
                    'way' => $request->way,
                    'reference' => $request->reference,
                    'amount' => $request->amount,
                    'exchanged' => $data["change"],
                    'currency_id' => $request->currency_id,
                ];
                $payment->items()->create($data2);
                $paymentitem->delete();
            }

            // ATUALIZAÇÃO ATÔMICA do caixa
            $cashier->increment('present', $request->total);

            DB::commit();
            $request->session()->forget('items');
            $request->session()->forget('item');
            return view('factura.show_after_payment', compact('payment'))->with(['sucesso' => __('messages.msg.store'), 'open' => $open]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['falha' => __('messages.prompt.request_failure') . ' : ' . $e->getMessage()]);
        }
    }

    public function viewAskedDestroy()
    {
        $facturas = $this->factura->where("destroy_username", "!=", null)->paginate($this->limit);
        $trashes = $this->factura->onlyTrashed()->where("destroy_username", "!=", null)->latest()->paginate($this->limit);
        return view('factura.asked_destroy', compact('facturas', 'trashes'));
    }

    public function historyAskedDestroy(Request $request)
    {
        $date = $request->date;
        $trashes = $this->factura->onlyTrashed()->where("destroy_username", "!=", null)->whereDate("deleted_at", $date)->latest()->paginate($this->limit);
        return view('home.historico_apagado_home', compact('trashes', 'date'));
    }

    /**
     * Returns Invoices for payments
     * Filter by date:
     */
    public function invoicesForPayment($payed = false)
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        $facturas = Factura::select('id', 'customer_name', 'total', 'created_at')
            ->where(function ($query) use ($today, $tomorrow, $payed) {
                $query->whereBetween('created_at', [$today, $tomorrow])
                    ->when($payed == 'false', function ($innerQuery) {
                        $innerQuery->where('payed', false);
                    })
                    ->when($payed == 'true', function ($innerQuery) {
                        $innerQuery->where('payed', true);
                    });
            })
            ->orderBy('created_at', 'desc')
            // ->take(100)
            ->get();
        $flag = $payed == 'true' ? '' : 'NÃO';
        $facturasHeader = "Pesquisar facturas {$flag} pagas";
        return view('factura.factura-for-payment', compact('facturas', 'facturasHeader', 'payed'));
    }

    /**
     * Brings the list 
     */
    public function list(Request $request)
    {
        $payed =  $request->payed ?? false;
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        $facturas = Factura::query()
            ->select(['id', 'customer_name', 'total', 'day', 'created_at', 'payed'])
            ->where(function ($query) use ($today, $tomorrow, $payed) {
                $query->whereBetween('created_at', [$today, $tomorrow])
                    ->when($payed == 'false', function ($innerQuery) {
                        $innerQuery->orWhere('payed', false);
                    })
                    ->when($payed == 'true', function ($innerQuery) {
                        $innerQuery->where('payed', true);
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->limit);
        return view('factura.list', compact('facturas', 'payed'));
    }
}
