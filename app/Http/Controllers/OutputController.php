<?php

namespace App\Http\Controllers;

use App\Models\Output;
use Illuminate\Http\Request;
use App\Http\Requests\Account\StoreOutput;
use App\Http\Requests\Account\UpdateOutput;
use App\Models\Store;
use App\Models\Product;
use App\Models\Stock;
use Carbon\Carbon;
use DB;
use App\Models\ProductChild;

class OutputController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $output;
    private $limit = 10;

    function __construct(Output $output) {
        $this->output = $output;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
        $outputs = Output::whereDate('created_at', '>=', Carbon::today()->subDays(7))->latest()->paginate($this->limit);
        return view('output.index', compact('outputs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectCustomer() {
        $accounts = Output::latest()->take($this->limit)->get();
        return view('output.select_customer', compact('accounts'));
    }

    public function create() {
        $store = Store::first();
        if ($store == null) {
            return redirect()->back()->withInput()->with('info', 'Nao ha loja pra se fazer a venda.');
        }
        return view('output.create', compact('store'));
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

    public function store(StoreOutput $request) {
        DB::beginTransaction();
        try {
            $items = auth()->user()->temp_items;
             $subtotal = $items->sum('subtotal');
            $discount = $request->discount;
            $discountp = $discount/$subtotal*100;
            $request->merge([
                "subtotal" => $subtotal,
                "discountp" => $discountp,
                "total" => ($subtotal - $discount)
            ]);
            $store = Store::first();
//             foreach ($items as $item) {
//                 if ($item->quantity > 0) {
//                     $product = Product::find($item->product_id);
//                     // if ($product->category->checkStock) {
//                     if (true) {
// //                    $stock = Stock::where('product_id', $item->product_id)->where('store_id', $store->id)->first();
//                         $productParent = ProductChild::where('child', $item->product_id)->first();
//                         $stock = Stock::where('product_id', ($productParent != null ? $productParent->parent : $item->product_id))->where('store_id', $store->id)->first();
//                         $resto = $stock != null ? $stock->quantity : 0;
//                         $quantity = $productParent != null ? ($item->quantity * $productParent->quantity) : $item->quantity;
//                         // if ($stock == null || $quantity > $stock->quantity) {
//                         if ($stock == null) {
//                             return redirect()->back()->withInput()->with(['falha' => "Verificação 1. Nao e possivel vender a quantidade {$item->quantity} do produto {$product->name}. Stock e: [$resto] na(o) {$store->name}."]);
//                         }
//                     }
//                 }
//             }
            if ($request->customer_name == null) {
                return redirect()->back()->withInput()->with(['falha' => 'Seleccione ou informe o cliente clientes.']);
            }
            if ($request->total <= 0) {
                return redirect()->back()->withInput()->with(['falha' => 'Seleccione pelo menos um artigo.']);
            }
            $output = $this->output->create($request->all());
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
                    $stock = Stock::where('product_id', ($productParent != null ? $productParent->parent : $item->product_id))->where('store_id', $store->id)->first();
                    $resto = $stock->quantity ?? 0;
                    // if ($stock == null || $item->quantity > $resto) {
                    //     return redirect()->back()->withInput()->with(['falha' => "Verificação 02. Nao e possivel vender a quantidade {$item->quantity} do produto {$item->name}. Stock e: [$resto] na(o) {$store->name}."]);
                    // }
                    $quantity = $productParent != null ? ($item->quantity * $productParent->quantity) : $item->quantity;
                    $stock->quantity -= $quantity;
                    $stock->operation = "Saída Nr. {$output->id}";
                    $output->items()->create($data);
                    $stock->update();
                    //Add Quantity of saled product
                    if ($productParent != null) {
                        $productParent->sales += $item->quantity;
                        $productParent->update();
                    }
                    $item->delete(); //                   
                }
            }
            DB::commit();
            return redirect()->route('output.show', $output->id)->with(['sucesso' => 'Saída criada com sucesso.']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['falha' => 'Falha na criacao da output.' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Output  $output
     * @return \Illuminate\Http\Response
     */
    public function show(Output $output) {
        return view('output.show', compact('output'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Output  $output
     * @return \Illuminate\Http\Response
     */
    public function edit(Output $output) {
        $accounts = Output::latest()->get();
        return view('output.edit', compact('output', 'accounts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Output\UpdateOutput  $request
     * @param  \App\Models\Output  $output
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOutput $request, Output $output) {
        $output->day = $request->day;
        $output->account_id = $request->account_id;
        $output->output = $request->output;
        $output->debit = $request->debit;
        $output->balance = $request->balance;
        $output->discount = $request->discount;
        $update = $output->update();
        if ($update) {
            return redirect()->route('output.show', $output->id)->with(['sucesso' => 'Outputactualizada com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da outputo.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Output  $output
     * @return \Illuminate\Http\Response
     */
    public function destroy(Output $output) {
        try {
            $store = Store::first();
            $items = $output->items;
            if ($store == null) {
                return redirect()->back()->withInput()->with(['info' => 'Seleccione o armazem.']);
            }
            foreach ($items as $item) {
                // $stock = Stock::where('product_id', $item->product_id)->where('store_id', $store->id)->first();
                // $stock->quantity += $item->quantity;
                $productParent = ProductChild::where('child', $item->product_id)->first();
                $stock = Stock::where('product_id', ($productParent != null ? $productParent->parent : $item->product_id))->where('store_id', $store->id)->first();
                $quantity = $productParent != null ? ($item->quantity * $productParent->quantity) : $item->quantity;
                $stock->quantity += $quantity;
                $stock->operation = "Cancelamento da Saída Nr. {$output->id}";
                $stock->update();
                $item->delete();
                //Remove Quantity of saled product
                if ($productParent != null) {
                    $productParent->sales -= $item->quantity;
                    $productParent->update();
                }
            }
            $output->delete();
            DB::commit();
            return redirect()->route('output.index')->with(['info' => 'Output suprimida com sucesso.']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da outputo.']);
        }
    }

    public function search(Request $request) {
        $dados = $request->all();
        $string = $request->criterio;
        $outputs = $this->output->where('id', 'LIKE', '%' . $string . '%')
                        ->OrWhere('customer_id', 'LIKE', '%' . $string . '%')
                        ->OrWhere('customer_name', 'LIKE', '%' . $string . '%')
                        ->OrWhere('customer_phone', 'LIKE', '%' . $string . '%')
                        ->OrWhere('subtotal', 'LIKE', '%' . $string . '%')
                        ->OrWhere('totalrate', 'LIKE', '%' . $string . '%')
                        ->OrWhere('discount', 'LIKE', '%' . $string . '%')
                        ->OrWhere('total', 'LIKE', '%' . $string . '%')
                        ->OrWhere('day', 'LIKE', '%' . $string . '%')
                        ->OrWhere('payed', 'LIKE', '%' . $string . '%')
                        ->OrWhere('nr', 'LIKE', '%' . $string . '%')
                        ->latest()->paginate($this->limit);
        return view('output.search', compact('dados', 'outputs'));
    }

    public function cancel(Request $request) {
        $request->session()->forget('items');
        return redirect()->route('output.create')->with('info', 'Criacao da Saída cancelada!');
    }

     public function copy(Request $request, $id) {
        $items = $this->output->find($id)->items;
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

}
