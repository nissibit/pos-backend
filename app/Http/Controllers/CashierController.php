<?php

namespace App\Http\Controllers;

use App\Models\{Cashier, Credit, Payment, PaymentItem, Item};
use Illuminate\Http\Request;
use App\Http\Requests\Sell\StoreCashier;
use App\Http\Requests\Sell\UpdateCashier;
use Carbon\Carbon;
use DB;

class CashierController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $cashier;
    private $limit = 10;
    private $open = null;

    function __construct(Cashier $cashier) {
        $this->cashier = $cashier;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
//        $cashiers = $this->cashier->orderBy('name')->latest()->take($this->limit)->get();
        $cashiers = $this->cashier->latest()->paginate($this->limit);
//        $cashiers = $this->cashier->whereDate('startime', Carbon::today())->paginate($this->limit);
        $cashier = auth()->user()->cashier->where('startime', '>=', \Carbon\Carbon::today())->where('endtime', null)->first();
        $open = ($cashier != null) ? $cashier->count() : 0;
        return view('payment.cashier.index', compact('cashiers', 'open'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $cashier = auth()->user()->cashier->where('startime', '>=', \Carbon\Carbon::today())->where('endtime', null)->first();
        $open = ($cashier != null) ? $cashier->count() : 0;
        return view('payment.cashier.create', compact('open'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCashier $request) {
        $data = $request->all();
        $data['present'] = $request->initial;
//        dd($data);
        if($cashier = $this->cashier->whereDate('startime',  \Carbon\Carbon::today()->format('Y-m-d'))->count()>0){
            return redirect()->back()->with('info','Já tem um caixa aberto');

        }
        $insert = $this->cashier->create($data);
        $cashier = auth()->user()->cashier->where('startime', '>=', \Carbon\Carbon::today())->where('endtime', null)->first();
        $open = ($cashier != null) ? $cashier->count() : 0;
        if ($insert) {
            return redirect()->route('payment.index', $insert->id)->with(['sucesso' => __('messages.msg.store'), 'open' => $open, 'cashier' => $cashier]);
        } else {
            return redirect()->back()->with(['falha' => __('messages.prompt.request_failure'), 'open' => $open, 'cashier' => $cashier]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cashier  $cashier
     * @return \Illuminate\Http\Response
     */
    public function show(Cashier $cashier) {        
        $open = ($cashier != null) ? $cashier->count() : 0;
        return view('payment.cashier.show', compact('cashier', 'open', 'cashier'));
    }

    public function fetch_payments(Request $request, $id)
    {
        try{
            $payments = Payment::where('cashier_id',$request->id)->get();
            return view('payment.cashier.sales_table', compact('payments'));
        }catch(\Exception $ex){
            return "Occorreu um erro ao carregar os pagamentos do caixa!";
        }       
        
    }


    public function fetch_payment_credits(Request $request, $id)
    {
        try{
            $credits = Payment::where('cashier_id',$request->id)->whereHasMorph('payment', [Credit::class])->get();
            return view('payment.cashier.sales_table_credit', compact('credits'));
        }catch(\Exception $ex){
            return "Occorreu um erro ao carregar os pagamentos do caixa!";
        }       
        
    }


    public function fetch_totals(Request $request, $id)
    {
        try{
             $totals = PaymentItem::select(\DB::raw("payment_items.way, SUM(payments.topay) as present"))
                ->join('payments', function($join){
                    $join->on('payment_items.payment_id', 'payments.id');
                })
                ->join('cashiers', function($join){
                    $join->on('payments.cashier_id', 'cashiers.id');
                })
                ->whereNull('payments.deleted_at')
                ->where('cashiers.id', $request->id)
                ->groupBy('payment_items.way')
                ->get();
            return view('payment.cashier.totals_table', compact('totals'));
        }catch(\Exception $ex){
            return "Occorreu um erro ao carregar os totais do caixa! {$ex->getMessage()}";
        }       
        
    }

    public function fetch_products(Request $request, $id)
    {
        try{
            $cashier = Cashier::findOrfail($id);

             $products = Item::select(\DB::RAW(" 
                                product_id, barcode, name, unitprice as price,
                                SUM(`quantity`) AS `qtd`,
                                SUM(`subtotal`) AS `total`
                                "))
                                ->whereDate('created_at', $cashier->startime->format("Y-m-d"))
                                ->groupBy("product_id","barcode", "name", "price")
                                ->orderBy("name")
                                ->get();
            return view('payment.cashier.products_table', compact('products', 'cashier'));
        }catch(\Exception $ex){
            return "Occorreu um erro ao carregar os produtos vendidos do caixa! {$ex->getMessage()}";
        }       
        
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cashier  $cashier
     * @return \Illuminate\Http\Response
     */
    public function edit(Cashier $cashier) {
        $open = ($cashier != null) ? $cashier->count() : 0;
        return view('payment.cashier.edit', compact('open', 'cashier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Product\UpdateCashier  $request
     * @param  \App\Models\Cashier  $cashier
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCashier $request, Cashier $cashier) {
        $open = ($cashier != null) ? $cashier->count() : 0;
        try {
            if ($cashier->endtime != null) {
                return redirect()->back()->with(['info' => __('messages.cashier.already_open')]);
            }
            $cashier->informed = $request->informed;
            $cashier->missing = $request->missing;
            $cashier->description = $request->description;
            $cashier->endtime = Carbon::now();
            $meios = \App\Base::meioPagamento();
            $update = false;
            $update2 = array();
            $data = $request->all();
            $meios2 = array();
            foreach ($meios as $meio) {
                $meios2[] = preg_replace('/\s+/', '_', $meio);
            }
//            dd($data);
            \DB::transaction(function () use(&$update, &$cashier, $meios2, $data, &$update2) {
                $update = $cashier->update();
                foreach ($data as $key => $value) {
                    if (in_array($key, $meios2)) {
                        $update2[] = $cashier->totals()->create(['way' => $key, 'amount' => $value]);
                    }
                }
            });
            if ($update && (!in_array(false, $update2))) {
                return redirect()->route('cashier.print', ['id' => $cashier->id])->with(['sucesso' => __('messages.msg.update'), 'open' => $open]);
//                return view('payment.cashier.print', compact('cashier'));
            } else {
                return redirect()->back()->with(['falha' => __('messages.prompt.request_failure'), 'open' => $open, 'cashier' => $cashier]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with(['falha' => __('messages.prompt.request_failure') . " : {$e->getMessage()} ", 'open' => $open, 'cashier' => $cashier]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cashier  $cashier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cashier $cashier) {
        DB::beginTransaction();
        try {
            $totals = $cashier->totals();
            foreach ($totals as $total) {
                $total->delete();
            }
            #Nao vamos apagar, mas sim actulizar
            $cashier->informed = 0;
            $cashier->missing = 0;
            $cashier->description = 0;
            $cashier->endtime = null;
            $cashier->update();
            DB::commit();
            return redirect()->route('cashier.index')->with(['info' => __('messages.msg.delete')]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('cashier.index')->with(['falha' => __('messages.prompt.request_failure')."; {$e->getMessage()}",  'cashier' => $cashier]);
        }
    }

    public function search(Request $request) {
        $dados = $request->all();
        $string = $request->criterio;
        $cashiers = $this->cashier->where('id', 'LIKE', '%' . $string . '%')
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
        $cashier = auth()->user()->cashier->where('startime', '>=', \Carbon\Carbon::today()->format('Y-d-m'))->where('endtime', null)->first();
        $open = ($cashier != null) ? $cashier->count() : 0;
        return view('payment.cashier.search', compact('dados', 'cashiers', 'open', 'cashier'));
    }

    public function print(Request $request) {
        $cashier = $this->cashier->find($request->id);
        $open = ($cashier != null) ? $cashier->count() : 0;
        return view('payment.cashier.print', compact('cashier', 'open', 'cashier'));
    }

    public function searchReport(Request $request) {
        $cashier = auth()->user()->cashier->where('startime', '>=', \Carbon\Carbon::today())->where('endtime', null)->first();
        $open = ($cashier != null) ? $cashier->count() : 0;
        $dados = $request->all();
        if ($request->to < $request->from) {
            return redirect()->back()->withInput()->with(['info' => 'A data de início deve ser uma data anterior ao fim.', 'open' => $open, 'cashier' => $cashier]);
        }
        $cashiers = $this->cashier
                ->whereDate('startime', '>=', $request->from)
                ->whereDate('startime', '<=', $request->to)
                // ->whereBetween(DB::raw('DATE(startime)'), array($request->from, $request->to))
                ->latest()
                ->paginate($this->limit);
        return view('payment.cashier.search_report', compact('dados', 'cashiers', 'open', 'cashier'));
    }

}
