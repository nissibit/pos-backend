<?php

namespace App\Http\Controllers;

use App\Http\Requests\MoneyFlow\StoreMoneyFlow;
use App\Http\Requests\MoneyFlow\UpdateMoneyFlow;
use App\Models\MoneyFlow;
use App\Models\Fund;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function auth;
use function redirect;
use function view;
use DB;

class MoneyFlowController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    private $moneyflow;
    private $limit = 10;
    private $fund;

    function __construct(MoneyFlow $moneyflow) {
        $this->moneyflow = $moneyflow;
        $this->middleware(['auth', 'revalidate']);
//        $this->fund = auth()->user()->fund->where('endtime', null)->first();
    }

    public function index() {
        $this->fund = auth()->user()->fund->where('endtime', null)->first();
        if ($this->fund == null) {
            return redirect()->back()->with(['info' => 'Abra ao caixa primeiro.']);
        }
        $moneyflows = $this->fund->moneyflows()->paginate($this->limit);
        return view('moneyflow.index', compact('moneyflows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $fund = auth()->user()->fund->where('endtime', null)->first();
        return view('moneyflow.create', compact('fund'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(StoreMoneyFlow $request) {
        $fund = Fund::find($request->fund_id);
        DB::beginTransaction();
        try {
            $moneyflow = $fund->moneyflows()->create($request->all());
            if ($request->type == "Entrada") {
                $fund->present += $request->amount;
            } else {
                $fund->present -= $request->amount;
            }
            $fund->update();
            DB::commit();
            return redirect()->route('moneyflow.show', $moneyflow->id)->with(['sucesso' => 'Operação efectuada com sucesso.']);
        } catch (\Exceprion $e) {
            DB::rollback();
            return redirect()->back()->with(['falha' => 'Falha na criacao da factura.: ' . $e->getMessage()]);
        }

//        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  MoneyFlow  $moneyflow
     * @return Response
     */
    public function show(MoneyFlow $moneyflow) {
//        dd($moneyflow);
        return view('moneyflow.show', compact('moneyflow'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  MoneyFlow  $moneyflow
     * @return Response
     */
    public function edit(MoneyFlow $moneyflow) {
        $accounts = MoneyFlow::latest()->get();
        return view('moneyflow.edit', compact('moneyflow', 'accounts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateMoneyFlow  $request
     * @param  MoneyFlow  $moneyflow
     * @return Response
     */
    public function update(UpdateMoneyFlow $request, MoneyFlow $moneyflow) {

        return redirect()->route('moneyflow.show', $moneyflow->id)->with(['info' => 'Nao permitido.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  MoneyFlow  $moneyflow
     * @return Response
     */
    public function destroy(MoneyFlow $moneyflow) {
        $fund = $moneyflow->fund;
        DB::beginTransaction();
        try {
            if ($moneyflow->type == "Entrada") {
                $fund->present -= $moneyflow->amount;
            } else {
                $fund->present += $moneyflow->amount;
            }
            $fund->update();
            $moneyflow->delete();
            DB::commit();
            return redirect()->route('moneyflow.index')->with(['sucesso' => 'Operação efectuada com sucesso.']);
        } catch (\Exceprion $e) {
            DB::rollback();
            return redirect()->back()->with(['falha' => 'Falha na criacao da factura.: ' . $e->getMessage()]);
        }
    }

    public function search(Request $request) {
        $dados = $request->all();
        $string = $request->criterio;
        $moneyflows = $this->moneyflow->where('id', 'LIKE', '%' . $string . '%')
                        ->OrWhere('amount', 'LIKE', '%' . $string . '%')
                        ->OrWhere('created_at', 'LIKE', '%' . $string . '%')
                        ->OrWhere('reason', 'LIKE', '%' . $string . '%')
                        ->latest()->paginate($this->limit);
        return view('moneyflow.search', compact('dados', 'moneyflows'));
    }

    public function cancel(Request $request) {
        $request->session()->forget('moneyflowitems');
        return redirect()->route('moneyflow.index')->with(['info' => 'Pagamento cancelado.']);
    }

}
