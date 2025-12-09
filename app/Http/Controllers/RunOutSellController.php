<?php

namespace App\Http\Controllers;

use App\Models\RunOutSell;
use Illuminate\Http\Request;
use App\Http\Requests\Product\StoreRunOutSell;
use App\Http\Requests\Product\UpdateRunOutSell;

class RunOutSellController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $runoutsell;
    private $limit = 10;

    function __construct(RunOutSell $runoutsell) {
        $this->runoutsell = $runoutsell;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
//        $runoutsells = $this->runoutsell->orderBy('name')->latest()->take($this->limit)->get();
        $runoutsells = $this->runoutsell->orderBy('name')->latest()->paginate($this->limit);
        return view('runoutsell.index', compact('runoutsells'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('runoutsell.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRunOutSell $request) {
        $insert = $this->runoutsell->create($request->all());
        if ($insert) {
            return redirect()->route('runoutsell.show', $insert->id)->with(['sucesso' => 'Categoria criada com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na criacao da categoria.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RunOutSell  $runoutsell
     * @return \Illuminate\Http\Response
     */
    public function show(RunOutSell $runoutsell) {
        return view('runoutsell.show', compact('runoutsell'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RunOutSell  $runoutsell
     * @return \Illuminate\Http\Response
     */
    public function edit(RunOutSell $runoutsell) {
        return view('runoutsell.edit', compact('runoutsell'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Product\UpdateRunOutSell  $request
     * @param  \App\Models\RunOutSell  $runoutsell
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRunOutSell $request, RunOutSell $runoutsell) {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RunOutSell  $runoutsell
     * @return \Illuminate\Http\Response
     */
    public function destroy(RunOutSell $runoutsell) {
        
    }

    public function search(Request $request) {
        $dados = $request->all();
        $string = $request->criterio;
        $runoutsells = $this->runoutsell->where('id', 'LIKE', '%' . $request->criterio . '%')
                ->OrWhere('name', 'LIKE', '%' . $request->criterio . '%')
                ->orWhere('barcode', 'LIKE', '%' . $request->criterio . '%')
                ->orWhere('unitprice', 'LIKE', '%' . $request->criterio . '%')
                ->orWhereHas('factura', function ($store) use ($string) {
                    $store->where("customer_name", 'like', '%' . $string . '%')
                            ->orWhere("customer_nuit", 'like', '%' . $string . '%');
                })
                ->latest()
                ->paginate($this->limit);
        return view('runoutsell.search', compact('dados', 'runoutsells'));
    }

}
