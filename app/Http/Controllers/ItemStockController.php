<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ItemStock;
use Illuminate\Http\Request;
use App\Http\Requests\Store\StoreItemStock;
use App\Http\Requests\Store\UpdateItemStock;
use App\Models\StockTaking;

class ItemStockController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $itemstock;
    private $limit = 10;

    function __construct(ItemStock $itemstock) {
        $this->itemstock = $itemstock;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
        $stocktaking = StockTaking::latest()->first();
        $products = array();
        if ($stocktaking != null) {
            $products = Product::whereNotIn('id', $stocktaking->products()->select('product_id')->get())->orderBy('name', 'ASC')->paginate($this->limit);
//            $products = $stocktaking->products()->latest()->paginate($this->limit);
        }
        return view('itemstock.index', compact('products', 'stocktaking'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $stocktaking = StockTaking::latest()->first();
        $product = Product::find($request->id);
        return view('itemstock.create', compact('stocktaking', 'product'));
    }

    /**
     * ItemStock a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItemStock $request) {
//        dd($request->all());
        $insert = $this->itemstock->create($request->all());
        if ($insert) {
            return redirect()->route('itemstock.index')->with(['sucesso' => 'Produto criado com sucesso.']);
        } else {
            return redirect()->back()->with(['falha' => 'Falha na criacao da produto.'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemStock  $itemstock
     * @return \Illuminate\Http\Response
     */
    public function show(ItemStock $itemstock) {
        return view('itemstock.show', compact('itemstock'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemStock  $itemstock
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemStock $itemstock) {
        $stocktaking = $itemstock->stock_taking;
        return view('itemstock.edit', compact('itemstock', 'stocktaking'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Product\UpdateItemStock  $request
     * @param  \App\Models\ItemStock  $itemstock
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemStock $request, ItemStock $itemstock) {
        $itemstock->quantity = $request->quantity;
        $update = $itemstock->update();
        if ($update) {
            return redirect()->route('itemstock.index')->with(['sucesso' => 'Produto actualizado com sucesso.']);
        } else {
            return redirect()->back()->with(['info' => 'Falha na actualização da produto.'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemStock  $itemstock
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemStock $itemstock) {
        $delete = $itemstock->delete();
        if ($delete) {
            return redirect()->route('itemstock.index')->with(['info' => 'ItemStock suprimida com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da itemstock.']);
        }
    }

    public function search(Request $request) {
        $dados = $request->all();
        $string = $request->criterio;
        $stocktaking = StockTaking::latest()->first();
        $products = ItemStock::whereHas("product", function($query) use ($string) {
                    $query->where("name", 'like', '%' . $string . '%')
                    ->orWhere("label", 'like', '%' . $string . '%')
                    ->orWhere("description", 'like', '%' . $string . '%')
                    ->orWhere("price", 'like', '%' . $string . '%')
                    ->orWhere("run_out", 'like', '%' . $string . '%');
                })
                ->whereNotIn('id', $stocktaking->products()->select('product_id')->get())
                ->paginate($this->limit);
        return view('itemstock.search', compact('dados', 'products', 'stocktaking'));
    }

}
