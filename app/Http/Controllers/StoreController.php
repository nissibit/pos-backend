<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Requests\Store\StoreStore;
use App\Http\Requests\Store\UpdateStore;

class StoreController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $store;
    private $limit = 10;

    function __construct(Store $store) {
        $this->store = $store;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
        $categories = $this->store->latest()->take($this->limit)->get();
        return view('store.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('store.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStore $request) {
        $insert = $this->store->create($request->all());
        if($insert){
            return redirect()->route('store.show', $insert->id)->with(['sucesso' => 'Armazem criada com sucesso.']);
        }else{
            return redirect()->back()->with(['sucesso' => 'Falha na criacao da armazem.']);
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store) {
        return view('store.show', compact('store'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store) {
         return view('store.edit', compact('store'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Product\UpdateStore  $request
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStore $request, Store $store) {
        $store->name  = $request->name; 
        $store->label  = $request->label; 
        $store->description  = $request->description; 
        $update = $store->update();
        if($update){
            return redirect()->route('store.show', $store->id)->with(['sucesso' => 'Armazem actualizada com sucesso.']);
        }else{
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da armazem.']);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store) {
        $delete = $store->delete();
        if($delete){
            return redirect()->route('store.index')->with(['info' => 'Armazem suprimida com sucesso.']);
        }else{
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da armazem.']);
            
        }
    }
    
    public function search(Request $request) {
        $dados = $request->all();
        $categories = $this->store->where('id', 'LIKE', '%'.$request->criterio.'%')
                ->OrWhere('name', 'LIKE', '%'.$request->criterio.'%')
                ->orWhere('label', 'LIKE', '%'.$request->criterio.'%')
                ->orWhere('description', 'LIKE', '%'.$request->criterio.'%')
                ->latest()
                ->paginate($this->limit);
        return view('store.search', compact('dados', 'categories'));
    }

}
