<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use Illuminate\Http\Request;
use App\Http\Requests\Pagamentos\StoreBanco;

class
BancoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $banco;

    function __construct(Banco $banco) {
        $this->banco = $banco;
        $this->middleware("auth");
    }

    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view("pagamento.banco.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBanco $request) {
        try {
            #$request->session()->put('tab_pagamento', 'tab_banco');
            $insert = $this->banco->create($request->except('_token'));
            if ($insert) {
                #dd($insert);
                return redirect()->route('pagamento.index')->with(['sucesso' => 'Banco registado com sucesso.', 'activo' => 'tab_banco']);
            } else {
                return redirect()->route('pagamento.index')->with(['falha' => 'Falha ao registar banco.', 'activo' => 'tab_banco']);
            }
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with(["falla", 'Erro na visualização da pagamento' . $e->getMessage(), 'activo' => 'tab_banco']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banco  $banco
     * @return \Illuminate\Http\Response
     */
    public function show(Banco $banco) {
        try {
            if ($banco == null) {
                return redirect()->back()->with("info", "Código da banco inválido.");
            }
            return view("pagamento.banco.show", compact("banco"));
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with("falla", 'Erro na visualização da banco' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banco  $banco
     * @return \Illuminate\Http\Response
     */
    public function edit(Banco $banco) {
        try {
            if ($banco == null) {
                return redirect()->back()->with("info", "Código da banco inválido.");
            }
            return view("pagamento.banco.edit", compact("banco"));
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('falha', 'Erro na edição da banco' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banco  $banco
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banco $banco) {
        try {
            $banco->name = $request->name;
            $banco->alias = $request->alias;
            $banco->description = $request->description;

            $update = $banco->save();
            if ($update) {
                return redirect()->back()->with("sucesso", "Banco actualizado com sucesso.");
            } else {
                return redirect()->back()->with("falha", "Falha ao actualizar Banco.");
            }
        } catch (Exception $e) {
            $request->session()->flash('falha', 'Erro na actualização da banco' . $e->getMessage());
            return redirect()->back()->withInput()->with("falla", "Erro: ");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banco  $banco
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banco $banco) {
        try {
            $nome = $banco->name;
            $delete = $this->banco->find($banco->id)->delete();
            if ($delete) {
                return redirect()->route('pagamento.index')->with(["sucesso" => " Banco '{$nome}' suprimida!", 'activo' => 'tab_banco']);
            } else {
                return redirect()->back()->with(["falha" => " não foi possível suprimir a banco.", 'activo' => 'tab_banco']);
            }
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('falha', 'Erro na supressão da banco' . $e->getMessage());
        }
    }

    public function restoreAll() {
        try {
            $restored = $this->banco->withTrashed()->restore();
            return redirect()->route('pagamento.index')->with(["sucesso" => "{$restored} Contas Bancos restaurados com sucesso.", 'activo' => 'tab_banco']);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('falha', 'Erro na restauraçãode todas banco' . $e->getMessage());
        }
    }

    public function restore($id) {
        try {
            $banco = $this->banco->find($id);
            if ($banco == null) {
                return redirect()->route("pagamento.index")->with(["info" => "Banco não encontrada.", 'activo' => 'tab_banco']);
            }
            $restored = $banco->withTrashed()->restore();
            return redirect()->route('pagamento.index')->with(["info" => "Foram restauradas {$restored} Banco(s).", 'activo' => 'tab_banco']);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('falha', 'Erro na restauração da banco' . $e->getMessage());
        }
    }

}
