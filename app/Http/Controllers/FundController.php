<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use Illuminate\Http\Request;
use App\Http\Requests\Money\StoreFund;
use App\Http\Requests\Money\UpdateFund;
use Carbon\Carbon;
use DB;

class FundController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $fund;
    private $limit = 10;

    function __construct(Fund $fund) {
        $this->fund = $fund;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
//        $funds = $this->fund->orderBy('name')->latest()->take($this->limit)->get();
        $funds = $this->fund->latest()->paginate($this->limit);
//        $funds = $this->fund->whereDate('startime', Carbon::today())->paginate($this->limit);
        return view('fund.index', compact('funds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('fund.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFund $request) {
//        dd($request->all());
        $data = $request->all();
        $data['present'] = $request->initial;
//        dd($data);
        if (auth()->user()->fund->where('endtime', null)->count() > 0) {
            return redirect()->back()->with(['info' => 'Não pode iniciar um fundo sem terminar o aberto..']);
        }
        $insert = $this->fund->create($data);
        if ($insert) {
            return redirect()->route('fund.index', $insert->id)->with(['sucesso' => 'Fundo aberto com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na criacao da fundo.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fund  $fund
     * @return \Illuminate\Http\Response
     */
    public function show(Fund $fund) {
        $moneyflows = $fund->moneyflows()->paginate($this->limit);
        $reinforcements  = $fund->reinforcements()->latest()->paginate();
        return view('fund.show', compact('fund', 'moneyflows', 'reinforcements'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fund  $fund
     * @return \Illuminate\Http\Response
     */
    public function edit(Fund $fund) {
        return view('fund.edit', compact('fund'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Product\UpdateFund  $request
     * @param  \App\Models\Fund  $fund
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFund $request, Fund $fund) {
//        dd($request->all());
        DB::beginTransaction();
        try {
            if ($fund->endtime != null) {
                return redirect()->back()->withInput()->with(['info' => 'Este fundo ja foi fechado numa operação anterior.']);
            }
            $fund->informed = $request->informed;
            $fund->missing = $request->missing;
            $fund->description = $request->description;
            $fund->endtime = Carbon::now();
            $fund->update();
            DB::commit();
            return redirect()->route('fund.print', ['id' => $fund->id])->with(['sucesso' => 'Fundo actualizada com sucesso.']);
//                return view('fund.print', compact('fund'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with(['falha' => "Ocorreu um erro ao fechar o fundo. {$e->getMessage()} "]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fund  $fund
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fund $fund) {
        $delete = $fund->delete();
        if ($delete) {
            return redirect()->route('fund.index')->with(['info' => 'Fundo suprimida com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da fundo.']);
        }
    }

    public function search(Request $request) {
        $dados = $request->all();
        $string = $request->criterio;
        $funds = $this->fund->where('id', 'LIKE', '%' . $string . '%')
                ->OrWhere('startime', 'LIKE', '%' . $string . '%')
                ->orWhere('endtime', 'LIKE', '%' . $string . '%')
                ->orWhere('initial', 'LIKE', '%' . $string . '%')
                ->orWhere('missing', 'LIKE', '%' . $string . '%')
                ->orWhere('description', 'LIKE', '%' . $string . '%')
                ->orWhereHas('user', function($query) use ($string) {
                    $query->Where('name', 'LIKE', '%' . $string . '%')
                    ->orWhere('username', 'LIKE', '%' . $string . '%')
                    ->orWhere('email', 'LIKE', '%' . $string . '%');
                })
                ->latest()
                ->paginate($this->limit);
        return view('fund.search', compact('dados', 'funds'));
    }

    public function print(Request $request) {
        $fund = $this->fund->find($request->id);
        return view('fund.print', compact('fund'));
    }

    public function searchReport(Request $request) {
        $dados = $request->all();
        if ($request->to < $request->from) {
            return redirect()->back()->withInput()->with(['info' => 'A data de início deve ser uma data anterior ao fim.']);
        }
        $funds = $this->fund->where('endtime', '<>', null)->whereBetween(DB::raw('DATE(startime)'), array($request->from, $request->to))
                ->latest()
                ->paginate($this->limit);
        return view('fund.search_report', compact('dados', 'funds'));
    }

}
