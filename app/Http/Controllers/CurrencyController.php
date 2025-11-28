<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Requests\Product\StoreCurrency;
use App\Http\Requests\Product\UpdateCurrency;

class CurrencyController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $currency;
    private $limit = 10;

    function __construct(Currency $currency) {
        $this->currency = $currency;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
//        $currencies = $this->currency->orderBy('name')->latest()->take($this->limit)->get();
        $currencies = $this->currency->orderBy('name')->latest()->paginate($this->limit);
        return view('admin.currency.index', compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.currency.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCurrency $request) {
        $insert = $this->currency->create($request->all());
        if($insert){
            return redirect()->route('currency.show', $insert->id)->with(['sucesso' => 'Moeda criada com sucesso.']);
        }else{
            return redirect()->back()->with(['sucesso' => 'Falha na criacao da categoria.']);
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency) {
        return view('admin.currency.show', compact('currency'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency) {
         return view('admin.currency.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Product\UpdateCurrency  $request
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCurrency $request, Currency $currency) {
        $currency->name  = $request->name; 
        $currency->label  = $request->label; 
        $currency->sign  = $request->sign; 
        $update = $currency->update();
        if($update){
            return redirect()->route('currency.show', $currency->id)->with(['sucesso' => 'Moeda actualizada com sucesso.']);
        }else{
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da categoria.']);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency) {
        $delete = $currency->delete();
        if($delete){
            return redirect()->route('admin.currency.index')->with(['info' => 'Moeda suprimida com sucesso.']);
        }else{
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da categoria.']);
            
        }
    }
    
    public function search(Request $request) {
        $dados = $request->all();
        $currencies = $this->currency->where('id', 'LIKE', '%'.$request->criterio.'%')
                ->OrWhere('name', 'LIKE', '%'.$request->criterio.'%')
                ->orWhere('label', 'LIKE', '%'.$request->criterio.'%')
                ->orWhere('sign', 'LIKE', '%'.$request->criterio.'%')
                ->latest()
                ->paginate($this->limit);
        return view('admin.currency.search', compact('dados', 'currencies'));
    }

   
}
