<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTaking;
use Illuminate\Http\Request;
use App\Http\Requests\Store\StoreStockTaking;
use App\Http\Requests\Store\UpdateStockTaking;
use App\Models\Store;
use Carbon\Carbon;

class StockTakingController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $stocktaking;
    private $limit = 10;

    function __construct(StockTaking $stocktaking) {
        $this->stocktaking = $stocktaking;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
        $stocktakings = $this->stocktaking->latest()->take($this->limit)->get();
        return view('stocktaking.index', compact('stocktakings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $stores = Store::all();
        $product = Product::find($request->id ?? 0);
        return view('stocktaking.create', compact('stores', 'product'));
    }

    /**
     * StockTaking a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStockTaking $request) {
        if($this->stocktaking->where('endtime', null)->count() > 0){
            return redirect()->back()->with(['info' => 'Termine o inventário aberto primeiro..'])->withInput();            
        }
        $insert = $this->stocktaking->create($request->all());
        if ($insert) {
            return redirect()->route('stocktaking.show', $insert->id)->with(['sucesso' => 'StockTaking criado com sucesso.']);
        } else {
            return redirect()->back()->with(['falha' => 'Falha na criacao da stocktaking.'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StockTaking  $stocktaking
     * @return \Illuminate\Http\Response
     */
    public function show(StockTaking $stocktaking) {
        return view('stocktaking.show', compact('stocktaking'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StockTaking  $stocktaking
     * @return \Illuminate\Http\Response
     */
    public function edit(StockTaking $stocktaking) {
        // return redirect()->route('product.show', $stocktaking->product_id)->with(['sucesso' => 'StockTaking actualizado com sucesso.']);
        return view('stocktaking.edit', compact('stocktaking'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Product\UpdateStockTaking  $request
     * @param  \App\Models\StockTaking  $stocktaking
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStockTaking $request, StockTaking $stocktaking) {
        $stocktaking->endtime = Carbon::now();
        $stocktaking->description = $request->description;
        $update = $stocktaking->update();
        if ($update) {
            return redirect()->route('stocktaking.show', $stocktaking->id)->with(['sucesso' => 'Inventário fechado com sucesso.']);
        } else {
            return redirect()->back()->with(['info' => 'Falha no fecho do Inventário.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StockTaking  $stocktaking
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockTaking $stocktaking) {
        $delete = $stocktaking->delete();
        if ($delete) {
            return redirect()->route('stocktaking.index')->with(['info' => 'StockTaking suprimida com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da stocktaking.']);
        }
    }

    public function search(Request $request) {
        $dados = $request->all();
        $string = $request->criterio;
        $stocktakings = StockTaking::whereHas("product", function($query) use ($string) {
                    $query->where("name", 'like', '%' . $string . '%')
                    ->orWhere("label", 'like', '%' . $string . '%')
                    ->orWhere("description", 'like', '%' . $string . '%')
                    ->orWhere("price", 'like', '%' . $string . '%')
                    ->orWhere("run_out", 'like', '%' . $string . '%');
                })
                ->orWhereHas('store', function($store) use($string) {
                    $store->where("name", 'like', '%' . $string . '%')
                    ->orWhere("label", 'like', '%' . $string . '%')
                    ;
                })
                ->paginate($this->limit);
        return view('stocktaking.search', compact('dados', 'stocktakings'));
    }
    
    public function products($id) {        
        $stocktaking = $this->stocktaking->find($id);        
        if($stocktaking == null){
            return redirect()->back()->with('info', 'Algo não deu certo.');
        }
        $products = $stocktaking->products()->latest()                
                ->paginate($this->limit);
        return view('stocktaking.products_added', compact('stocktaking', 'products'));
    }


}
