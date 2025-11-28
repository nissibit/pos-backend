<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Server;
use App\Models\Store;
use App\Models\Stock;
use App\Models\Account;
use DB;
use App\Http\Requests\Server\StoreInvoice;
use App\Http\Requests\Server\UpdateInvoice;
use App\Models\Currency;

class InvoiceController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $invoice;
    private $limit = 10;

    function __construct(Invoice $invoice) {
        $this->invoice = $invoice;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
        $invoices = $this->invoice->latest()->take($this->limit)->get();
        $servers = Server::latest()->paginate($this->limit);
        return view('invoice.index', compact('invoices', 'servers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(\App\Http\Requests\Invoice\SelectStoreServer $request) {
        $currencies = Currency::all();
        $server = Server::findOrfail($request->id ?? $request->server_id ?? 0);
        $store = Store::findOrfail($request->store_id ?? 0);
        return view('invoice.create', compact('server', 'store', 'currencies'));
    }

    public function selectServer() {
        $servers = Server::latest()->paginate($this->limit);
        $stores = Store::all();
        return view('invoice.select_server', compact('servers', 'stores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoice $request) {
//        dd($request->all());
        DB::beginTransaction();
//        try {
        $ans = array();
        $entries = auth()->user()->temp_entries;
        $invoice = $this->invoice->create($request->all());
        $ans[] = $invoice;
        $totalCompra = 0;
//            dd($entries[0]);
        if ($invoice != null) {
            foreach ($entries as $entry) {
                $data = [
                    'quantity' => $entry->quantity,
                    'rate' => $entry->rate,
                    'name' => $entry->name,
                    'old_price' => $entry->old_price,
                    'buying_price' => $entry->buying_price,
                    'current_price' => $entry->current_price,
                    'product_id' => $entry->product_id,
                    'store_id' => $entry->store_id,
                    'invoice_id' => $entry->invoice_id,
                    'description' => $entry->description
                ];
                $ans[] = $invoice->entries()->create($data);
                #update product
                $product = $entry->product;
                $product->price = $entry->current_price;
                $product->name = $entry->name;
                $product->rate = $entry->rate;
                $product->buying = $entry->buying_price;
                $ans[] = $product->update();
                #update stock of product, first search
                $stock = Stock::where('product_id', $product->id)->where('store_id', $entry->store_id)->first();
                if ($stock != null) {
                    #update
                    $stock->quantity += $entry->quantity;
                    $stock->operation = "Entrada de Stock pela Factura Nr. {$invoice->id}";
                    $stock->description = 'Entrada da factura ' . $request->number;
                    $ans[] = $stock->update();
                } else {
                    #insert
                    $data = ['product_id' => $product->id, 'store_id' => $entry->store_id, 'quantity' => $entry->quantity, 'description' => 'Entrada da factura ' . $request->number];
                    $ans[] = Stock::create($data);
                }
                $totalCompra += ($entry->buying_price * $entry->quantity);
                $entry->delete();
            }
            #update account
            $account = Account::find($request->account_id);
            $account->credit += $totalCompra;
            $account->balance = $account->debit - $account->credit;
            $account->update();
            DB::commit();
            return redirect()->route('invoice.show', $invoice->id)->with(['sucesso' => 'Factura do fornecedor criada com sucesso.']);
        } else {
            DB::rollback();
            return redirect()->back()->with(['falha' => 'Falha na criacao da factura.'])->withInput();
        }
//        } catch (\Exception $e) {
//            DB::rollback();
//            return redirect()->back()->with(['falha' => 'Falha na criacao da factura.' . $e->getMessage()])->withInput();
//        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice) {
        return view('invoice.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice) {
        $servers = Server::latest()->get();
        return view('invoice.edit', compact('invoice', 'servers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Invoice\UpdateInvoice  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoice $request, Invoice $invoice) {
        $invoice->day = $request->day;
        $invoice->server_id = $request->server_id;
        $invoice->invoice = $request->invoice;
        $invoice->debit = $request->debit;
        $invoice->balance = $request->balance;
        $invoice->discount = $request->discount;
        $update = $invoice->update();
        if ($update) {
            return redirect()->route('invoice.show', $invoice->id)->with(['sucesso' => 'Factura do fornecedor actualizada com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da factura.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice) {
        DB::beginTransaction();
        try{
            # Delete Entries and also updating the stock;
            $entries = $invoice->entries();
            foreach($entries as $entry){
                $stock = $entry->product()->stocks()->first() ?? new Stock; 
                $stock->quantity += $entry->quantity;
                $stock->operation = "Cancelamento da Entrada de Stock pela Factura Nr. {$invoice->id}";
                $stock->update();
            }
            $delete = $invoice->delete();
            
            return redirect()->route('invoice.index')->with(['info' => 'Factura do fornecedor suprimida com sucesso.']);
            
        }catch(\Exception $ex){
            DB::rollback();
            return redirect()->back()->with(['falha' => "Erro ao remover a factura!"]);
        }
    }

    public function search(Request $request) {
        $dados = $request->all();
        $invoices = $this->invoice->where('id', 'LIKE', '%' . $request->criterio . '%')
                        ->OrWhere('number', 'LIKE', '%' . $request->criterio . '%')
                        ->OrWhere('subtotal', 'LIKE', '%' . $request->criterio . '%')
                        ->OrWhere('totalrate', 'LIKE', '%' . $request->criterio . '%')
                        ->OrWhere('discount', 'LIKE', '%' . $request->criterio . '%')
                        ->OrWhere('total', 'LIKE', '%' . $request->criterio . '%')
                        ->OrWhere('day', 'LIKE', '%' . $request->criterio . '%')
                        ->whereHas('account',  function($query) use ($request) {
                            $query->whereHasMorph('accountable', '*', function($query_2) use($request) {
                                $query_2->where('fullname', 'like', '%' . $request->criterio . '%');
                            });
                        })
                        ->latest()->paginate($this->limit);
        return view('invoice.search', compact('dados', 'invoices'));
    }

}
