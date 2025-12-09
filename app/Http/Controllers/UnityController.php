<?php

namespace App\Http\Controllers;

use App\Models\Unity;
use Illuminate\Http\Request;
use App\Http\Requests\Product\StoreUnity;
use App\Http\Requests\Product\UpdateUnity;

class UnityController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $unity;
    private $limit = 10;

    function __construct(Unity $unity) {
        $this->unity = $unity;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
        $unities = $this->unity->latest()->take($this->limit)->get();
        return view('unity.index', compact('unities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('unity.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUnity $request) {
        $insert = $this->unity->create($request->all());
        if($insert){
            return redirect()->route('unity.show', $insert->id)->with(['sucesso' => 'Categoria criada com sucesso.']);
        }else{
            return redirect()->back()->with(['sucesso' => 'Falha na criacao da categoria.']);
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unity  $unity
     * @return \Illuminate\Http\Response
     */
    public function show(Unity $unity) {
        return view('unity.show', compact('unity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unity  $unity
     * @return \Illuminate\Http\Response
     */
    public function edit(Unity $unity) {
         return view('unity.edit', compact('unity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Product\UpdateUnity  $request
     * @param  \App\Models\Unity  $unity
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUnity $request, Unity $unity) {
        $unity->name  = $request->name; 
        $unity->label  = $request->label; 
        $unity->description  = $request->description; 
        $update = $unity->update();
        if($update){
            return redirect()->route('unity.show', $unity->id)->with(['sucesso' => 'Categoria actualizada com sucesso.']);
        }else{
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da categoria.']);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unity  $unity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unity $unity) {
        $delete = $unity->delete();
        if($delete){
            return redirect()->route('unity.index')->with(['info' => 'Categoria suprimida com sucesso.']);
        }else{
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da categoria.']);
            
        }
    }
    
    public function search(Request $request) {
        $dados = $request->all();
        $unities = $this->unity->where('id', 'LIKE', '%'.$request->criterio.'%')
                ->OrWhere('name', 'LIKE', '%'.$request->criterio.'%')
                ->orWhere('label', 'LIKE', '%'.$request->criterio.'%')
                ->orWhere('description', 'LIKE', '%'.$request->criterio.'%')
                ->latest()
                ->paginate($this->limit);
        return view('unity.search', compact('dados', 'unities'));
    }

}
