<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashFlow\StoreCashFlow;
use App\Http\Requests\CashFlow\UpdateCashFlow;
use App\Models\CashFlow;
use App\Models\Cashier;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function auth;
use function redirect;
use function view;

class CashFlowController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    private $cashflow;
    private $limit = 10;
    private $cashier;

    function __construct(CashFlow $cashflow) {
        $this->cashflow = $cashflow;
        $this->middleware(['auth', 'revalidate']);
//        $this->cashier = auth()->user()->cashier->where('startime', '>=', \Carbon\Carbon::today())->where('endtime', null)->first();
    }

    public function index() {
        $this->cashier = auth()->user()->cashier->where('startime', '>=', \Carbon\Carbon::today())->where('endtime', null)->first();
        if ($this->cashier == null) {
            return redirect()->back()->with(['info' => __('messages.cashflow.open_cashier')]);
        }
        $cashflows = $this->cashier->cashflows()->paginate($this->limit);
        $open = ($this->cashier != null) ? $this->cashier->count() : 0;
        return view('cashflow.index', compact('cashflows', 'open'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function selectCustomer() {
        $accounts = CashFlow::latest()->take($this->limit)->get();

        $open = ($this->cashier != null) ? $this->cashier->count() : 0;
        return view('cashflow.select_customer', compact('accounts', 'open'));
    }

    public function create() {
        $cashier = auth()->user()->cashier->where('startime', '>=', \Carbon\Carbon::today())->where('endtime', null)->first();
        $open = ($this->cashier != null) ? $this->cashier->count() : 0;
        return view('cashflow.create', compact('cashier', 'open'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(StoreCashFlow $request) {
        $cashier = Cashier::find($request->cashier_id);
        $ans = array();

        \DB::transaction(function () use(&$request, $cashier, &$ans) {
            $ans[] = $cashier->cashflows()->create($request->all());
            if ($request->type == "Entrada") {
                $cashier->present += $request->amount;
            } else {
                $cashier->present -= $request->amount;
            }
            $ans[] = $cashier->update();
        });
        $open = ($this->cashier != null) ? $this->cashier->count() : 0;
        if (!in_array(false, $ans)) {
            return redirect()->route('cashflow.show', $ans[0]->id)->with(['sucesso' => __('messages.msg.store'), "open" => $open]);
        } else {
            return redirect()->back()->with(['falha' => __('messages.prompt.request_failure'), 'open' => $open]);
        }
//        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  CashFlow  $cashflow
     * @return Response
     */
    public function show(CashFlow $cashflow) {
//        dd($cashflow);

        $open = ($this->cashier != null) ? $this->cashier->count() : 0;
        return view('cashflow.show', compact('cashflow', 'open'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CashFlow  $cashflow
     * @return Response
     */
    public function edit(CashFlow $cashflow) {
        $accounts = CashFlow::latest()->get();

        $open = ($this->cashier != null) ? $this->cashier->count() : 0;
        return view('cashflow.edit', compact('cashflow', 'accounts', 'open'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCashFlow  $request
     * @param  CashFlow  $cashflow
     * @return Response
     */
    public function update(UpdateCashFlow $request, CashFlow $cashflow) {

        $open = ($this->cashier != null) ? $this->cashier->count() : 0;
        return redirect()->route('cashflow.show', $cashflow->id)->with(['info' => 'Nao permitido.', 'open' => $open]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CashFlow  $cashflow
     * @return Response
     */
    public function destroy(CashFlow $cashflow) {
        $cashier = $cashflow->cashier;
        $ans = array();
        \DB::transaction(function () use($cashier, &$ans, &$cashflow) {
            if ($cashflow->type == "Entrada") {
                $cashier->present -= $cashflow->amount;
            } else {
                $cashier->present += $cashflow->amount;
            }
            $ans[] = $cashier->update();
            $ans[] = $cashflow->delete();
        });

        $open = ($this->cashier != null) ? $this->cashier->count() : 0;
        if (!in_array(false, $ans)) {
            return redirect()->route('cashflow.index')->with(['info' => __('messages.msg.delete'), 'open' => $open]);
        } else {
            return redirect()->back()->with(['falha' => __('messages.prompt.request_failure'), 'open' => $open]);
        }
    }

    public function search(Request $request) {
        $dados = $request->all();
        $string = $request->criterio;
        $cashflows = $this->cashflow->where('id', 'LIKE', '%' . $string . '%')
                        ->OrWhere('amount', 'LIKE', '%' . $string . '%')
                        ->OrWhere('created_at', 'LIKE', '%' . $string . '%')
                        ->OrWhere('reason', 'LIKE', '%' . $string . '%')
                        ->latest()->paginate($this->limit);
        return view('cashflow.search', compact('dados', 'cashflows'));
    }

    public function cancel(Request $request) {
        $request->session()->forget('cashflowitems');
        return redirect()->route('cashflow.index')->with(['info' => __('messages.item.delete')]);
    }

}
