<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Requests\Payment\StorePayment;
use App\Http\Requests\Payment\UpdatePayment;
use App\Models\Factura;
use App\Models\Credit;
use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Account;

class PaymentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $payment;
    private $limit = 10;
    private $open = null;

    function __construct(Payment $payment)
    {
        $this->payment = $payment;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index()
    {
        $facturas = Factura::latest()->orWhere('payed', false)->where("destroy_username", null)->paginate($this->limit);
        $payments = $this->payment->latest()->whereDate('created_at', Carbon::today())->paginate($this->limit);
        $cashier = auth()->user()->cashier->where('startime', '>=', \Carbon\Carbon::today())->where('endtime', null)->first();
        $open = ($cashier != null) ? $cashier->count() : 0;
        return view('payment.index', compact('facturas', 'payments', 'open', 'cashier'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectCustomer()
    {
        $accounts = Payment::latest()->take($this->limit)->get();
        $cashier = auth()->user()->cashier->where('startime', '>=', \Carbon\Carbon::today())->where('endtime', null)->first();
        $open = ($cashier != null) ? $cashier->count() : 0;
        return view('payment.select_customer', compact('accounts', 'open', 'cashier'));
    }

    public function create(Request $request)
    {
        $factura = null;
        if ($request->factura != null) {
            $factura = Factura::find($request->factura ?? 0);
        } elseif ($request->credit) {
            $factura = Credit::find($request->credit ?? 0);
        }
        $currencies = Currency::all();
        $cashier = auth()->user()->cashier->where('startime', '>=', \Carbon\Carbon::today())->where('endtime', null)->first();
        $open = ($cashier != null) ? $cashier->count() : 0;
        if ($factura != null) {
            return view('payment.createFactura', compact('factura', 'currencies', 'open', 'cashier'));
        } else {
            return redirect()->back()->withInput()->with(['info' => __('messages.sale.request_store'), 'open' => $open]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePayment $request)
    {
        //        dd($request->all());
        DB::beginTransaction();
        $cashier = auth()->user()->cashier->where('startime', '>=', \Carbon\Carbon::today())->where('endtime', null)->first();
        $open = ($cashier != null) ? $cashier->count() : 0;
        try {
            $paymentitems = auth()->user()->temp_payment_items;
            if ($request->account != null) {
                $entity = Credit::find($request->factura) ?? null;
            } else {
                $entity = ($request->factura ?? null) != null ? Factura::find($request->factura) : null;
            }
            //            dd($entity);
            if ($request->total <= 0) {
                return redirect()->back()->withInput()->with(['falha' => __('messages.sale.request_items')]);
            }
            if ($entity == null) {
                return redirect()->back()->withInput()->with(['falha' => __('messages.payment.request_invoce')]);
            }
            if ($cashier == null) {
                return redirect()->back()->withInput()->with(['falha' => __('messages.payment.request_cashier')]);
            }
            if ($entity->payed) {
                return redirect()->back()->withInput()->with(['info' => __('messages.payment.alread_payed')]);
            }
            $data = [
                'topay' => $request->topay,
                'payed' => $request->total,
                'change' => $request->change,
                'day' => $request->day,
                'cashier_id' => $cashier->id
            ];
            $entity->payed = true;
            $entity->save();
            $payment = $entity->payments()->create($data);
            foreach ($paymentitems as $paymentitem) {
                $data2 = [
                    'way' => $paymentitem->way,
                    'reference' => $paymentitem->reference,
                    'amount' => $paymentitem->amount,
                    'exchanged' => $paymentitem->exchanged,
                    'currency_id' => $paymentitem->currency_id,
                ];
                $payment->items()->create($data2);
                $paymentitem->delete();
            }
            $cashier->present += $request->topay;
            $cashier->update();
            //            Se existir conta
            if ($request->account != null) {
                $account = Account::find($request->account);
                $account->debit += $request->topay;
                $account->balance = $account->debit - $account->credit;
                $account->update();
            }
            DB::commit();
            $request->session()->forget('paymentitems');

            return redirect()->route('payment.show', $payment->id)->with(['sucesso' => __('messages.msg.store'), 'open' => $open, 'jasperPDF' => false, 'report' => true]);
            // return redirect()->route('payment.jasper', $payment->id)->with(['sucesso' => __('messages.msg.store')]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['falha' => __('messages.prompt.request_failure') . ' : ' . $e->getMessage(), 'open' => $open]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        $cashier = auth()->user()->cashier->where('startime', '>=', \Carbon\Carbon::today())->where('endtime', null)->first();
        $open = ($cashier != null) ? $cashier->count() : 0;

        return view('payment.show', compact('payment', 'open', 'cashier', 'payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        $accounts = Payment::latest()->get();
        $cashier = auth()->user()->cashier->where('startime', '>=', \Carbon\Carbon::today())->where('endtime', null)->first();
        $open = ($cashier != null) ? $cashier->count() : 0;
        return view('payment.edit', compact('payment', 'accounts', 'open', 'cashier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Payment\UpdatePayment  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePayment $request, Payment $payment)
    {
        $payment->day = $request->day;
        $payment->account_id = $request->account_id;
        $payment->payment = $request->payment;
        $payment->debit = $request->debit;
        $payment->balance = $request->balance;
        $payment->discount = $request->discount;
        $update = $payment->update();
        $cashier = auth()->user()->cashier->where('startime', '>=', \Carbon\Carbon::today())->where('endtime', null)->first();
        $open = ($cashier != null) ? $cashier->count() : 0;
        if ($update) {
            return redirect()->route('payment.show', $payment->id)->with(['sucesso' => __('messages.msg.update'), 'open' => $open]);
        } else {
            return redirect()->back()->with(['sucesso' => __('messages.prompt.request_failure'), 'open' => $open]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //        $cashier = auth()->user()->cashier->where('startime', '>=', \Carbon\Carbon::today())->where('endtime', null)->first();

        $cashier = $payment->cashier;
        $open = ($cashier != null) ? $cashier->count() : 0;
        DB::beginTransaction();
        try {
            $items = $payment->items;
            foreach ($items as $item) {
                $item->delete();
            }
            /** Update a Credit of Factura */
            $entity = $payment->payment;
            $entity->payed = false;
            $entity->update();
            /* Check if is Credit to correct the account balance */
            $credit = $payment->payment;

            //If its payment for credit
            if ($credit != null) {
                $account = $credit->account;
                if ($account != null) {
                    $account->debit -= $payment->topay;
                    $account->balance = $account->debit - $account->credit;
                    $account->update();
                }
            }
            /* Return money to Cashier */
            $cashier->present -= $payment->topay;
            $cashier->update();
            /* Delete the Cashier * */
            $payment->delete();
            DB::commit();
            return redirect()->route('payment.index')->with(['info' => __('messages.msg.delete'), 'open' => $open]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['falha' => __('messages.prompt.request_failure') . $e->getMessage() . "<bt />" . $e->getCode()]);
        }
    }

    public function search(Request $request)
    {
        $dados = $request->all();
        $string = $request->criterio;
        $payments = $this->payment->where('topay', 'LIKE', '%' . $string . '%')
            ->OrWhere('payed', 'LIKE', '%' . $string . '%')
            ->OrWhere('day', 'LIKE', '%' . $string . '%')
            ->OrWhere('payed', 'LIKE', '%' . $string . '%')
            ->OrWhere('nr', 'LIKE', '%' . $string . '%')
            ->orWhereHasMorph('payment', '*', function ($query, $type) use ($string) {
                if ($type === Factura::class) {
                    $query->where('customer_name', 'LIKE', '%' . $string . '%')
                        ->orWhere('customer_phone', 'LIKE', '%' . $string . '%')
                        ->orWhere('customer_nuit', 'LIKE', '%' . $string . '%')
                        ->orWhere('customer_address', 'LIKE', '%' . $string . '%');
                } else if ($type === Credit::class) {
                    $query->where('nr_requisicao', 'LIKE', '%' . $string . '%')
                        ->OrWhere('nr_factura', 'LIKE', '%' . $string . '%');
                }
            })
            ->latest()->paginate($this->limit);
        $cashier = auth()->user()->cashier->where('startime', '>=', \Carbon\Carbon::today())->where('endtime', null)->first();
        $open = ($cashier != null) ? $cashier->count() : 0;
        return view('payment.search', compact('dados', 'payments', 'open', 'cashier'));
    }

    public function cancel(Request $request)
    {
        $paymentitems = auth()->user()->temp_payment_items;
        foreach ($paymentitems as $paymentitem) {
            $paymentitem->delete();
        }
        $cashier = auth()->user()->cashier->where('startime', '>=', \Carbon\Carbon::today())->where('endtime', null)->first();
        $open = ($cashier != null) ? $cashier->count() : 0;
        return redirect()->route('payment.index')->with(['info' => __('messages.item.deleted'), 'open' => $open]);
    }


    public function creditSearch(Request $request)
    {
        $dados = $request->all();
        $string = $request->criterio ?? '';
        $payments = $this->payment->with("payment")
            ->whereHasMorph('payment', [Credit::class], function ($query) use ($string) {
                $query->select("id", "day")->where('nr_requisicao', 'LIKE', '%' . $string . '%')
                    ->OrWhere('nr_factura', 'LIKE', '%' . $string . '%')
                    ->where('payed', true);
            })
            // ->where('payment_type', 'App\\Models\\Credit')
            // ->OrWhere('day', 'LIKE', '%' . $string . '%')
            // ->when(empty($string), function ($query) {
            //     $query->whereDate("created_at", now()->format("Y-m-d"));
            // })
            ->when(!empty($string), function ($query) use ($string) {
                $query->whereHas("factura", function ($inner) use ($string) {
                    $inner->where("customer_name", 'LIKE', '%' . $string . '%');
                });
                // ->orWhere('nr', 'LIKE', '%' . $string . '%');
            })
            ->latest()->paginate();
        // ->toSql();
        // dd($payments);
        $cashier = auth()->user()->cashier->where('startime', '>=', \Carbon\Carbon::today())->where('endtime', null)->first();
        $open = ($cashier != null) ? $cashier->count() : 0;

        return view('payment.search_credit', compact('dados', 'payments', 'cashier', 'open'));
    }
}
