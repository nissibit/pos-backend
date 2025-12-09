<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use App\Http\Requests\Store\StoreStock;
use App\Http\Requests\Store\UpdateStock;
use App\Models\Store;

class StockController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $stock;
    private $limit = 10;

    function __construct(Stock $stock) {
        $this->stock = $stock;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
        $stocks = $this->stock->latest()->paginate($this->limit);
        return view('stock.index', compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $stores = Store::all();
        $product = Product::find($request->id ?? 0);
        return view('stock.create', compact('stores', 'product'));
    }

    /**
     * Stock a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStock $request) {
        $insert = $this->stock->create($request->all());
        if ($insert) {
            return redirect()->route('product.show', $insert->product_id)->with(['sucesso' => 'Stock criado com sucesso.']);
        } else {
            return redirect()->back()->with(['falha' => 'Falha na criacao da stock.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock) {
        return view('stock.show', compact('stock'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock) {
        $stores = Store::all();
        $product = Product::find($stock->product_id ?? 0);
        // return redirect()->route('product.show', $stock->product_id)->with(['sucesso' => 'Stock actualizado com sucesso.']);
        return view('stock.edit', compact('stock', 'stores', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Product\UpdateStock  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStock $request, Stock $stock) {
        $stock->quantity = $request->quantity;
        $stock->product_id = $request->product_id;
        $stock->store_id = $request->store_id;
        $stock->operation = "Edição Directa";
        $update = $stock->update();
        if ($update) {
            return redirect()->route('stock.show', $stock->id)->with(['sucesso' => 'Stock actualizado com sucesso.']);
        } else {
            return redirect()->back()->with(['info' => 'Falha na supressao da stock.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock) {
        $delete = $stock->delete();
        if ($delete) {
            return redirect()->route('stock.index')->with(['info' => 'Stock suprimida com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da stock.']);
        }
    }

    public function search(Request $request) {
        $dados = $request->all();
        $string = $request->criterio;
        $stocks = Stock::whereHas("product", function($query) use ($string) {
                    $query->where("name", 'like', '%' . $string . '%')
                    ->orWhere("label", 'like', '%' . $string . '%')
                    ->orWhere("description", 'like', '%' . $string . '%')
                    ->orWhere("price", 'like', '%' . $string . '%')
                    ->orWhere("run_out", 'like', '%' . $string . '%')
                    ->orWhere("barcode", 'like', '%' . $string . '%')
                    ->orWhere("othercode", 'like', '%' . $string . '%');
                })
                ->orWhereHas('store', function($store) use($string) {
                    $store->where("name", 'like', '%' . $string . '%')
                    ->orWhere("label", 'like', '%' . $string . '%')
                    ;
                })
                ->orWhereHas("product.category", function($query) use ($string) {
                    $query->where("name", 'like', '%' . $string . '%')
                    ->orWhere("label", 'like', '%' . $string . '%')
                    ->orWhere("description", 'like', '%' . $string . '%');
                })
                ->orWhere("quantity", 'like', '%' . $string . '%')
                ->paginate($this->limit);
        return view('stock.search', compact('dados', 'stocks'));
    }

    public function audit(Request $request) {
        $audits = $this->stock->find($request->id)->audits()->with('user')->get();
        dd($audits);
    }

}
