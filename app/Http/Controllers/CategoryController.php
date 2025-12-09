<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Product\StoreCategory;
use App\Http\Requests\Product\UpdateCategory;

class CategoryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $category;
    private $limit = 10;

    function __construct(Category $category) {
        $this->category = $category;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
//        $categories = $this->category->orderBy('name')->latest()->take($this->limit)->get();
        $categories = $this->category->orderBy('name')->latest()->paginate($this->limit);
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategory $request) {
        $insert = $this->category->create($request->all());
        if($insert){
            return redirect()->route('category.show', $insert->id)->with(['sucesso' => 'Categoria criada com sucesso.']);
        }else{
            return redirect()->back()->with(['sucesso' => 'Falha na criacao da categoria.']);
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category) {
        return view('category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category) {
         return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Product\UpdateCategory  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategory $request, Category $category) {
        $category->name  = $request->name; 
        $category->label  = $request->label; 
        $category->description  = $request->description; 
        $category->checkStock  = $request->checkStock ?? false; 
        $update = $category->update();
        if($update){
            return redirect()->route('category.show', $category->id)->with(['sucesso' => 'Categoria actualizada com sucesso.']);
        }else{
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da categoria.']);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category) {
        $delete = $category->delete();
        if($delete){
            return redirect()->route('category.index')->with(['info' => 'Categoria suprimida com sucesso.']);
        }else{
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da categoria.']);
            
        }
    }
    
    public function search(Request $request) {
        $dados = $request->all();
        $categories = $this->category->where('id', 'LIKE', '%'.$request->criterio.'%')
                ->OrWhere('name', 'LIKE', '%'.$request->criterio.'%')
                ->orWhere('label', 'LIKE', '%'.$request->criterio.'%')
                ->orWhere('description', 'LIKE', '%'.$request->criterio.'%')
                ->latest()
                ->paginate($this->limit);
        return view('category.search', compact('dados', 'categories'));
    }

}
