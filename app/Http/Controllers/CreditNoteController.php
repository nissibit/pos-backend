<?php

namespace App\Http\Controllers;

use App\Models\CreditNote;
use Illuminate\Http\Request;
use App\Http\Requests\Payment\StoreCreditNote;
use App\Http\Requests\Payment\UpdateCreditNote;
use App\Models\Store;
use App\Models\Product;
use App\Models\Stock;
use Carbon\Carbon;
use DB;
use App\Models\Payment;
use App\Models\Cashier;

class CreditNoteController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $creditnote;
    private $limit = 10;

    function __construct(CreditNote $creditnote) {
        $this->creditnote = $creditnote;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
//        $creditnotes = CreditNote::latest()->whereDate('created_at', '>=', Carbon::today()->subDays(7))->paginate($this->limit);
        $creditnotes = CreditNote::latest()->paginate($this->limit);
        return view('creditnote.index', compact('creditnotes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectCustomer() {
        $payments = CreditNote::latest()->take($this->limit)->get();
        return view('creditnote.select_customer', compact('payments'));
    }

    public function create(Request $request) {
        $payment = Payment::find($request->id ?? 0);
        //CopyItems
        $user = auth()->user();
        $items = $payment->payment->items;
        foreach ($items as $item) {
            $data = [
                'product_id' => $item->product_id,
                'name' => $item->name,
                'quantity' => $item->quantity,
                'unitprice' => $item->unitprice,
                'rate' => $item->rate,
                'subtotal' => $item->subtotal,
            ];
            if ($user->temp_items()->where('product_id', $item->product_id)->first() == null) {
                auth()->user()->temp_items()->create($data);
            }
        }
        return view('creditnote.create', compact('payment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkStock($items, $store_id) {
        $store = Store::find($store_id);
        foreach ($items as $item) {
            if ($item->quantity > 0) {
                $product = Product::find($item->product_id);
                if (strtoupper($product->category->name) != 'RETALHO') {
                    $stock = Stock::where('product_id', $item->product_id)->where('store_id', $store->id)->first();
                    $resto = $stock != null ? $stock->quantity : 0;
                    if ($stock == null || $item->quantity > $stock->quantity) {
                        return redirect()->back()->withInput()->with(['falha' => "Nao e possivel vender a quantidade {$item->quantity} do produto {$product->name}. Stock e: [$resto] na(o) {$store->name}."]);
                    }
                }
            }
        }
    }

    public function store(StoreCreditNote $request) {
//        dd($request->all());
//        Check if quantities are less or equal ths invoice
        $user = auth()->user();
        $payment = Payment::find($request->payment_id ?? 0);
        $items = $user->temp_items;

        //CopyItems
        $paymentItems = $payment->payment->items;
        foreach ($paymentItems as $item) {
            $current = $items->where('product_id', $item->product_id)->first();
            if ($current != null) {
                $total = $current->quantity;
                $credit_notes_items = $payment->credit_note_items;
                $allreadCreated = $credit_notes_items->where('product_id', $item->product_id)->first();
                if ($allreadCreated != null) {
                    $total += $allreadCreated->quantity;
                }
                if ($total > $item->quantity) {
                    return redirect()->back()->with(['falha' => "O produto {$item->product->name} não pode ultrapassar {$item->quantity}"]);
                }
            }
        }
//       Get Opned cashier
        $cashier = Cashier::where('endtime', null)->latest()->first();
        if ($request->return_money == "SIM" && $cashier != null) {
            return redirect()->back()->with(['falha' => "O caixa deve estar berto para o reembolso."]);
        }
        $store = Store::first();
        DB::beginTransaction();
        try {
            $creditnote = $this->creditnote->create($request->all());
            foreach ($items as $item) {
                if ($item->quantity > 0) {
                    //Return Stock
                    if ($request->return_stock == 'SIM') {
                        $stock = Stock::where('product_id', $item->product_id)->where('store_id', $store->id)->first();
                        $resto = $stock != null ? $stock->quantity : 0;
                        if ($stock == null) {
                            return redirect()->back()->withInput()->with(['falha' => "Nao e possivel vender a quantidade {$item->quantity} do produto porque não tem stock inicial.."]);
                        } else {
                            $stock->quantity += $item->quantity;
                            $stock->update();
                        }
                    }
                }
                $dataItem = [
                    'product_id' => $item->product_id,
                    'name' => $item->name,
                    'quantity' => $item->quantity,
                    'unitprice' => $item->unitprice,
                    'rate' => $item->rate,
                    'subtotal' => $item->subtotal,
                ];
                $creditnote->items()->create($dataItem);
            }
            if ($request->return_money == 'SIM') {
                $data = [
                    'amount' => $request->total,
                    'type' => 'Saida',
                    'reason' => "NOTA DE CREDITO {$creditnote->id}",
                ];
                $cashier->cashflows()->create($data);
                $cashier->present -= $request->total;
                $cashier->update();
            }
            DB::commit();
            return redirect()->route('creditnote.show', $creditnote->id)->with(['sucesso' => 'Nota de Crédito Criada com Sucesso.']);
        } catch (\Exceprion $e) {
            DB::rollback();
            return redirect()->back()->with(['falha' => 'Falha na criacao da creditnote.: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CreditNote  $creditnote
     * @return \Illuminate\Http\Response
     */
    public function show(CreditNote $creditnote) {
        return view('creditnote.show', compact('creditnote'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CreditNote  $creditnote
     * @return \Illuminate\Http\Response
     */
    public function edit(CreditNote $creditnote) {
        $payments = CreditNote::latest()->get();
        return view('creditnote.edit', compact('creditnote', 'payments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\CreditNote\UpdateCreditNote  $request
     * @param  \App\Models\CreditNote  $creditnote
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCreditNote $request, CreditNote $creditnote) {
        $creditnote->day = $request->day;
        $creditnote->payment_id = $request->payment_id;
        $creditnote->creditnote = $request->creditnote;
        $creditnote->debit = $request->debit;
        $creditnote->balance = $request->balance;
        $creditnote->discount = $request->discount;
        $update = $creditnote->update();
        if ($update) {
            return redirect()->route('creditnote.show', $creditnote->id)->with(['sucesso' => 'CreditNote actualizada com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da creditnoteo.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CreditNote  $creditnote
     * @return \Illuminate\Http\Response
     */
    public function destroy(CreditNote $creditnote) {
        $store = Store::first();
        $delete = null;
        $items = $creditnote->items;
        if ($store == null) {
            return redirect()->back()->withInput()->with(['info' => 'Seleccione o armazem.']);
        }
        \DB::transaction(function () use($creditnote, &$store, &$items, &$delete) {
            foreach ($items as $item) {
                $stock = Stock::where('product_id', $item->product_id)->where('store_id', $store->id)->first();
                $stock->quantity += $item->quantity;
                $creditnote->items()->save($item);
                $stock->update();
            }
            /* If its payed it must return the money to the cashier */
            if ($creditnote->payed) {
                $payment = $creditnote->payments()->first();
                if ($payment != null) {
                    $cashier = $payment->cashier;
                    $cashier->present -= $creditnote->total;
                    $cashier->update();
                    $payment->delete();
                }
            }
            $delete = $creditnote->delete();
        });
        if ($delete) {
            return redirect()->route('creditnote.index')->with(['info' => 'CreditNote suprimida com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da creditnoteo.']);
        }
    }

    public function search(Request $request) {
        $dados = $request->all();
        $string = $request->criterio;
        $creditnotes = $this->creditnote->where('id', 'LIKE', '%' . $string . '%')
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
        return view('creditnote.search', compact('dados', 'creditnotes'));
    }

    public function cancel(Request $request) {
        $items = auth()->user()->temp_items;
        dd($items);
        foreach ($items as $item) {
            $item->delete();
        }
        return redirect()->route('creditnote.create')->with('info', 'Criacao da CreditNote cancelada!');
    }

    public function copy(Request $request, $id) {
        $items = $this->creditnote->find($id)->items;
        foreach ($items as $item) {
            $data = [
                'product_id' => $item->product_id,
                'name' => $item->name,
                'quantity' => $item->quantity,
                'unitprice' => $item->unitprice,
                'rate' => $item->rate,
                'subtotal' => $item->subtotal,
            ];
            if (auth()->user()->temp_items()->where('product_id', $item->product_id)->first() == null) {
                auth()->user()->temp_items()->create($data);
            }
        }
        return redirect()->back()->with(['sucesso' => 'Dados copiados com sucesso.']);
    }

}
