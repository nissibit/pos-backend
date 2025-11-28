<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use Illuminate\Http\Request;
use App\Http\Requests\Exchange\StoreExchange;
use App\Http\Requests\Exchange\UpdateExchange;
use App\Models\Currency;

class ExchangeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $exchange;
    private $limit = 10;

    function __construct(Exchange $exchange) {
        $this->exchange = $exchange;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
        $exchanges = $this->exchange->latest()->take($this->limit)->get();
        return view('exchange.index', compact('exchanges'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $currencies = Currency::all();
        return view('exchange.create', compact('currencies'));
    }

    /**
     * Exchange a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExchange $request) {
        $insert = $this->exchange->create($request->all());
        if ($insert) {
            return redirect()->route('exchange.show', $insert->id)->with(['sucesso' => 'Armazem criada com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na criacao da armazem.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exchange  $exchange
     * @return \Illuminate\Http\Response
     */
    public function show(Exchange $exchange) {
        return view('exchange.show', compact('exchange'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Exchange  $exchange
     * @return \Illuminate\Http\Response
     */
    public function edit(Exchange $exchange) {
        $currencies = Currency::all();
        return view('exchange.edit', compact('exchange', 'currencies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Product\UpdateExchange  $request
     * @param  \App\Models\Exchange  $exchange
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExchange $request, Exchange $exchange) {
        $exchange->currency_id = $request->currency_id;
        $exchange->amount = $request->amount;
        $exchange->day = $request->day;
        $update = $exchange->update();
        if ($update) {
            return redirect()->route('exchange.show', $exchange->id)->with(['sucesso' => 'Armazem actualizada com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da armazem.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exchange  $exchange
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exchange $exchange) {
        $delete = $exchange->delete();
        if ($delete) {
            return redirect()->route('exchange.index')->with(['info' => 'Armazem suprimida com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da armazem.']);
        }
    }

    public function search(Request $request) {
        $dados = $request->all();
        $string = $request->criterio;
        $exchanges = $this->exchange->where('id', 'LIKE', '%' . $string . '%')
                ->orWhere('day', 'LIKE', '%' . $string . '%')
                ->orWhereHas('currency', function($query) use ($string) {
                    $query->where('name', 'LIKE', '%' . $string . '%')
                    ->orWhere('label', 'LIKE', '%' . $string . '%')
                    ->orWhere('sign', 'LIKE', '%' . $string . '%');
                })
                ->latest()
                ->paginate($this->limit);
        return view('exchange.search', compact('dados', 'exchanges'));
    }

}
