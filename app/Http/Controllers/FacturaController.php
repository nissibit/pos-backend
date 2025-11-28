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
use DB;
use App\Models\ProductChild;
use App\Models\Currency;
use App\Models\TempPaymentItem;
use App\Models\RunOutSell;

class FacturaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $factura;
    private $limit = 10;

    function __construct(Factura $factura) {
        $this->factura = $factura;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
        $facturas = Factura::latest()->whereDate('created_at', Carbon::today())->orWhere('payed', false)->paginate($this->limit);
        return view('factura.index', compact('facturas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectCustomer() {
        $accounts = Factura::latest()->take($this->limit)->get();
        return view('factura.select_customer', compact('accounts'));
    }

    public function create() {
        $store = Store::first();
        if ($store == null) {
            return redirect()->back()->withInput()->with('info', __('messages.sale.request_store'));
        }
        return view('factura.create', compact('store'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFactura $request) {
        DB::beginTransaction();
        try {
            $items = auth()->user()->temp_items;
            $subtotal = $items->sum('subtotal');
            $discount = $request->discount;
            $discountp = $discount/$subtotal*100;
            $request->merge([
                "subtotal" => $subtotal,
                "discountp" => $discountp,
                "total" => round($subtotal - $discount)
            ]);
            $runOutItems = array();
            $store = Store::find($request->store_id);
            foreach ($items as $item) {
                if ($item->quantity > 0) {
                    $product = Product::find($item->product_id);
                    
                    if ($product->category->checkStock) {
                        $productParent = ProductChild::where('child', $item->product_id)->first();
                    # dd($productParent);
                        $stock = Stock::where('product_id', ($productParent != null ? $productParent->parent : $item->product_id))->where('store_id', $store->id)->first();
                        // if($stock == null){
                        //     return redirect()->back()->with('falha', 'Não foi possível continuar porque ocorreu um erro ao verificar estoque do produto '.$item->name);
                        // }
                        $quantity = $productParent != null ? ($item->quantity * $productParent->quantity) : $item->quantity;
                        $resto = $stock != null ? $stock->quantity : 0;

                        if ($stock == null ) {
                            return redirect()->back()->withInput()->with(['falha' => __('messages.sale.request_stock') . "{$product->name} - [$resto]  {$store->name}."]);
                        }
                        if($quantity > $stock->quantity){
                            
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
            }

            if ($request->customer_name == null) {
                return redirect()->back()->withInput()->with(['falha' => __('messages.sale.request_name')]);
            }
            if ($request->total <= 0) {
                return redirect()->back()->withInput()->with(['falha' => __('messages.sale.request_items')]);
            }
            $ans = array();
            $factura = $this->factura->create($request->all());
            $ans[] = $factura;
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
# dd($productParent);
                    $stock = Stock::where('product_id', ($productParent != null ? $productParent->parent : $item->product_id))->where('store_id', $store->id)->first();
                    if ($stock == null) {
                        return redirect()->back()->withInput()->with(['falha' => "O produto {$item->name} não tem/existe stock!"]);
                    }
//                    $stock = Stock::where('product_id', $item->product_id)->where('store_id', $request->store_id)->first();
                    $quantity = $productParent != null ? ($item->quantity * $productParent->quantity) : $item->quantity;
                    $stock->quantity -= $quantity;
                    $stock->operation = "Venda: {$factura->id}";
                    $ans[] = $factura->items()->create($data);
                    $ans[] = $stock->update(); // 
                    $item->delete();
                    //Add Quantity of saled product
                    if ($productParent != null) {
                        $productParent->sales += $item->quantity;
                        $productParent->update();
                    }
//                    $totalToCheck += $item->subtotal;
                }
            }
            //saving Runout
            foreach ($runOutItems as $item) {
                $item["factura_id"] = $factura->id;
                RunOutSell::create($item);
            }
            DB::commit();
            $request->session()->forget('items');
            $request->session()->forget('item');
            return redirect()->route('factura.show', $factura->id)->with(['sucesso' => __('messages.prompt.request_done')]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['falha' => __('messages.prompt.request_failure') . ' : ' . $e->getMessage(). $e]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function show(Factura $factura) {
        return view('factura.show', compact('factura'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function edit(Factura $factura) {
        return view('factura.edit', compact('factura'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Factura\UpdateFactura  $request
     * @param  \App\Models\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFactura $request, Factura $factura) {
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

    public function askDestroy(Request $request, $id) {
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

    public function cancelAskDestroy(Request $request, $id) {
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
    public function destroy(Factura $factura) {
        DB::beginTransaction();
        try {
            $store = Store::first();
            $delete = null;
            $items = $factura->items;

            if ($store == null) {
                return redirect()->back()->withInput()->with(['info' => 'Seleccione o armazem.']);
            }

            foreach ($items as $item) {
                $productParent = ProductChild::where('child', $item->product_id)->first();
                $stock = Stock::where('product_id', ($productParent != null ? $productParent->parent : $item->product_id))->where('store_id', $store->id)->first();
                $quantity = $productParent != null ? ($item->quantity * $productParent->quantity) : $item->quantity;
                if($stock != null){
                    $stock->quantity += $quantity;
                    $stock->operation = "Remoção da Factura Nr: {$factura->id}";
                    $stock->update();
                }

#$stock = Stock::where('product_id', $item->product_id)->where('store_id', $store->id)->first();
//$stock->quantity += $item->quantity;
                $factura->items()->save($item);
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
                    $cashier->present -= $factura->total;
                    $cashier->update();
                    $payment->delete();
                }
            }

            $delete = $factura->delete();
            DB::commit();
            return redirect()->route('factura.index')->with(['info' => __('messages.prompt.request_done')]);
        } catch (\Exceprion $e) {
            DB::rollback();
            return redirect()->back()->with(['falha' => __('messages.prompt.request_failure') . ' : ' . $e->getMessage()]);
        }
    }

    public function search(Request $request) {
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

    public function cancel(Request $request) {
        $items = auth()->user()->temp_items;
        foreach ($items as $item) {
            $item->delete();
        }
        return redirect()->route('factura.create')->with('info', __('messages.item.deleted'));
    }

    public function copy(Request $request, $id) {
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
                if (auth()->user()->temp_items()->where('product_id', $item->product_id)->first() == null) {
                    auth()->user()->temp_items()->create($data);
                }
            }
        }
        return redirect()->back()->with(['sucesso' => __('messages.item.copied')]);
    }

    public function getDirect() {
        $store = Store::first();
        if ($store == null) {
            return redirect()->back()->withInput()->with('info', __('messages.sale.request_store'));
        }
        return view('factura.direct', compact('store'));
    }

    public function postDirect(StoreFactura $request) {
        DB::beginTransaction();
        try {
            $items = auth()->user()->temp_items;
            $store = Store::find($request->store_id);
            foreach ($items as $item) {
                if ($item->quantity > 0) {
                    $product = Product::find($item->product_id);
                    if ($product->category->checkStock) {
                        $productParent = ProductChild::where('child', $item->product_id)->first();

                        $stock = Stock::where('product_id', ($productParent != null ? $productParent->parent : $item->product_id))->where('store_id', $store->id)->first();
                        $resto = $stock != null ? $stock->quantity : 0;
                        $quantity = $productParent != null ? ($item->quantity * $productParent->quantity) : $item->quantity;
                        if ($stock == null || $quantity > $stock->quantity) {
                            return redirect()->back()->withInput()->with(['falha' => __('messages.sale.request_stock') . " [$resto] na(o) {$store->name}."]);
                        }
                    }
                }
            }

            if ($request->customer_name == null) {
                return redirect()->back()->withInput()->with(['falha' => __('messages.sale.request_name')]);
            }
            if ($request->total <= 0) {
                return redirect()->back()->withInput()->with(['falha' => __('messages.sale.request_items')]);
            }
            $ans = array();
            $factura = $this->factura->create($request->all());
            $ans[] = $factura;
            if ($factura->payed) {
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
# dd($productParent);
                $stock = Stock::where('product_id', ($productParent != null ? $productParent->parent : $item->product_id))->where('store_id', $store->id)->first();

                if ($stock == null) {
                    return redirect()->back()->withInput()->with(['falha' => "O produto {$product->name} não tem stock. "]);
                }
//                    $stock = Stock::where('product_id', $item->product_id)->where('store_id', $request->store_id)->first();
                $quantity = $productParent != null ? ($item->quantity * $productParent->quantity) : $item->quantity;
                $stock->quantity -= $quantity;
                $ans[] = $factura->items()->create($data);
                $ans[] = $stock->update(); // 
                $item->delete();
                //Add Quantity of saled product
                if ($productParent != null) {
                    $productParent->sales += $item->quantity;
                    $productParent->update();
                }
//                    $totalToCheck += $item->subtotal;
            }
            //Execute the payment
            #Check if amount is equal to total
            if ($request->total > $request->amount) {
                return redirect()->back()->withInput()->with(['falha' => __('messages.sale.direct.amount')]);
            }
//            $currencies = Currency::all();
            $cashier = auth()->user()->cashier->where('startime', '>=', \Carbon\Carbon::today()->subDays(0))->where('endtime', null)->first();
            $open = ($cashier != null) ? $cashier->count() : 0;
            if ($open == 0) {
                return redirect()->back()->withInput()->with(['falha' => "O Caixa não foi aberto! "]);
            }
            //Creating a payment items
            $paymentitem = new TempPaymentItem();
            $paymentitem->way = $request->way;
            $paymentitem->reference = $request->reference;
            $paymentitem->amount = $request->amount;
            $paymentitem->exchanged = ($request->amount - $request->total);
            $paymentitem->currency_id = $request->currency_id;
            $paymentitem->currency = $request->currency_id == 0 ? 'MT' : Currency::find($request->currency_id ?? 0)->name;
            auth()->user()->temp_payment_items()->save($paymentitem);

            //Resolvendo items
            $data = [
                'topay' => $request->total,
                'payed' => $request->amount,
                'change' => ($request->amount - $request->total),
                'day' => date('Y-m-d'),
                'cashier_id' => $cashier->id
            ];
            $factura->payed = true;
            $factura->save();
            $paymentitems = auth()->user()->temp_payment_items;
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
            $cashier->present += $request->total;
            $cashier->update();

            DB::commit();
            $request->session()->forget('items');
            $request->session()->forget('item');
            return view('factura.show_after_payment', compact('payment'))->with(['sucesso' => __('messages.msg.store'), 'open' => $open]);
        } catch (\Exceprion $e) {
            DB::rollback();
            return redirect()->back()->with(['falha' => __('messages.prompt.request_failure') . ' : ' . $e->getMessage()]);
        }
    }

    public function viewAskedDestroy() {
        $facturas = $this->factura->where("destroy_username", "!=", null)->paginate($this->limit);
        $trashes = $this->factura->onlyTrashed()->where("destroy_username", "!=", null)->latest()->paginate($this->limit);
        return view('factura.asked_destroy', compact('facturas', 'trashes'));
    }

    public function historyAskedDestroy(Request $request) {
        $date = $request->date;
        #dd($date);
        $trashes = $this->factura->onlyTrashed()->where("destroy_username", "!=", null)->whereDate("deleted_at", $date)->latest()->paginate($this->limit);
        return view('home.historico_apagado_home', compact('trashes', 'date'));
    }

}
