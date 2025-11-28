<?php

namespace App\Http\Controllers;

use App\Models\Conversao;
use Illuminate\Http\Request;
use App\Http\Requests\StoreConversao;
use OwenIt\Auditing\Models\Audit;
use App\Models\Stock;
use DB;

class ConversaoController extends Controller {

    private $conversao;
    private $limit = 10;

    function __construct(Conversao $conversao) {
        $this->conversao = $conversao;
        $this->middleware(['auth', 'revalidate']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $conversaos = $this->conversao->latest()->paginate($this->limit);
        return view('conversao.index', compact('conversaos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        #$audits = Audit::all();
        return view('conversao.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConversao $request) {
        $insert = $this->conversao->create($request->all());
        if ($insert) {
            return redirect()->back()->with("sucesso", "Perfil criado/registado com sucesso.");
        } else {
            return redirect()->back()->with("falha", "Falha ao criar/registar perfil.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Conversao  $conversao
     * @return \Illuminate\Http\Response
     */
    public function show(Conversao $conversao) {
        return view('conversao.show', compact('conversao'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Conversao  $conversao
     * @return \Illuminate\Http\Response
     */
    public function edit(Conversao $conversao) {
        return view('conversao.edit', compact('conversao'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Conversao  $conversao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conversao $conversao) {
        $conversao->name = $request->name;
        $conversao->label = $request->label;
        $conversao->description = $request->description;
        $update = $conversao->save();
        if ($update) {
            return redirect()->back()->with("sucesso", "Perfil actualizado com sucesso.");
        } else {
            return redirect()->back()->with("falha", "Falha ao actualizar perfil.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Conversao  $conversao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conversao $conversao) {
        $stock_from = Stock::find($conversao->from);
        $stock_to = Stock::find($conversao->to);
        if ($stock_to == null) {
            return redirect()->back()->withInput()->with(['info' => 'Nao pode transferir para esse produto.']);
        }
        if (strtoupper($stock_to->product->category->name) != 'RETALHO') {
            return redirect()->back()->withInput()->with(['info' => 'O produto destino não está na categoria RETALHO.']);
        }
        DB::beginTransaction();
        try {
            $stock_from->quantity += $conversao->quantity;
            $stock_from->update();
            $stock_to->quantity -= $conversao->total;
            $stock_to->update();
            $conversao->delete();
            DB::commit();
            return redirect()->route('conversao.index')->with(['sucesso' => 'Conversão efectuada com sucesso.']);
        } catch (\Exceprion $e) {
            DB::rollback();
            return redirect()->back()->with(['falha' => 'Falha na operacao..: ' . $e->getMessage()]);
        }
    }

    public function search(Request $request) {
        $criterio = $request->criterio;

        $conversaos = $this->conversao->where('from', 'like', "%{$criterio}%")
                ->orWhere('quantity', 'like', "%{$criterio}%")
                ->orWhere('flap', 'like', "%{$criterio}%")
                ->orWhere('total', 'like', "%{$criterio}%")
                ->orWhere('created_at', 'like', "%{$criterio}%")
                ->orWhereHas('stock_from.product', function($query) use ($criterio) {
                    $query->where('name', 'like', "%{$criterio}%")
                    ->orWhere('label', 'like', "%{$criterio}%");
                })
                ->orWhereHas('stock_to.product', function($query) use ($criterio) {
                    $query->where('name', 'like', "%{$criterio}%")
                    ->orWhere('label', 'like', "%{$criterio}%");
                })
                ->latest()
                ->paginate($this->limit);
        $dados = $request->all();
        return view("conversao.search", compact("conversaos", "dados"));
    }

}
