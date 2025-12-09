<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Product;
use DB;

class PriceController extends Controller {

    private $price;
    private $limit = 10;

    function __construct(Price $price) {
        $this->price = $price;
        $this->middleware(['auth', 'revalidate']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $prices = $this->price->latest()->paginate($this->limit);
        return view("price.index", compact("prices"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $lastPrice = $this->price->latest()->first();
        $last = $lastPrice != null ? $lastPrice->product : null;
        return view("price.create", compact("last"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {

        DB::beginTransaction();
        try {
            $this->price->create($request->all());
            $product = \App\Models\Product::find($request->product_id);
            $product->price = $request->current;
            $product->buying = $request->buying;
            $product->margem = $request->margen;
            $product->update();
            DB::commit();
            return redirect()->back()->with(['sucesso' => 'Preço actualizado com sucesso.']);
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['falha' => __('messages.prompt.request_failure') . ' : ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Price  $price
     * @return Response
     */
    public function show(Price $price) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Price  $price
     * @return Response
     */
    public function edit(Price $price) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Price  $price
     * @return Response
     */
    public function update(Request $request, Price $price) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Price  $price
     * @return Response
     */
    public function destroy(Price $price) {
        $delete = $price->delete();
        if ($delete) {
            return redirect()->route('category.index')->with(['info' => 'Preço suprimido com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na supressao do preço.']);
        }
    }

    
    public function search(Request $request) {
        $dados = $request->all();
        $string = $request->criterio;
        $prices = Price::whereHas("product", function($query) use ($string) {
                    $query->where("name", 'like', '%' . $string . '%')
                    ->orWhere("label", 'like', '%' . $string . '%')
                    ->orWhere("description", 'like', '%' . $string . '%')
                    ->orWhere("price", 'like', '%' . $string . '%')
                    ->orWhere("run_out", 'like', '%' . $string . '%')
                    ->orWhere("barcode", 'like', '%' . $string . '%')
                    ->orWhere("othercode", 'like', '%' . $string . '%');
                })
                ->orWhereHas("product.category", function($query) use ($string) {
                    $query->where("name", 'like', '%' . $string . '%')
                    ->orWhere("label", 'like', '%' . $string . '%')
                    ->orWhere("description", 'like', '%' . $string . '%');
                })
                ->orWhere("buying", 'like', '%' . $string . '%')
                ->orWhere("margen", 'like', '%' . $string . '%')
                ->orWhere("current", 'like', '%' . $string . '%')
                ->paginate($this->limit);
        return view('price.search', compact('dados', 'prices'));
    }

    public function getByProduct(Request $request) {
        $id = $request->id;
        $product = Product::findOrfail($id);
        return view("product.prices_table", compact("product"));
    }

}
