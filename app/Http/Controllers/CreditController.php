<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Http\Requests\Account\StoreCredit;
use App\Http\Requests\Account\UpdateCredit;
use App\Models\Store;
use App\Models\Product;
use App\Models\Stock;
use Carbon\Carbon;
use DB;
use App\Http\Requests\Email\StoreSendEmail;
use PDF;
use Mail;
use App\Models\Company;
use App\Models\ProductChild;

class CreditController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $credit;
    private $limit = 10;

    function __construct(Credit $credit) {
        $this->credit = $credit;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
        //$credits = $this->credit->whereDate('created_at', Carbon::today())->orWhere('payed', false)->take($this->limit)->get();
        $credits = $this->credit->where('payed', false)->latest()->paginate($this->limit);
        return view('credit.index', compact('credits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectCustomer() {
        $accounts = Account::whereHasMorph('accountable', \App\Models\Customer::class, function($query) {
                    $query->where('fullname', '<>', '');
                })->latest()->paginate($this->limit);
        return view('credit.select_customer', compact('accounts'));
    }

    public function create(Request $request) {
        $account = Account::findOrfail($request->id);
        $accounts = Account::latest()->get();
        $stores = Store::all();
        return view('credit.create', compact('accounts', 'account', 'stores'));
    }

    public function create2(Request $request) {
        $account = Account::findOrfail($request->id);
        $accounts = Account::latest()->get();
        $stores = Store::all();
        return view('credit.create', compact('accounts', 'account', 'stores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCredit $request) {
        DB::beginTransaction();

        try {
            $items = auth()->user()->temp_items;
             $subtotal = $items->sum('subtotal');
            $discount = $request->discount;
            $discountp = $discount/$subtotal*100;
            $request->merge([
                "subtotal" => $subtotal,
                "discountp" => $discountp,
                "total" => ($subtotal - $discount)
            ]);
            $store = Store::find($request->store_id);
            foreach ($items as $item) {
                $product = Product::find($item->product_id);
                $productParent = ProductChild::where('child', $item->product_id)->first();
                $stock = Stock::where('product_id', ($productParent != null ? $productParent->parent : $item->product_id))->where('store_id', $store->id)->first();

//                $stock = Stock::where('product_id', $item->product_id)->where('store_id', $request->store_id)->first();
                $resto = $stock != null ? $stock->quantity : 0;
                $quantity = $productParent != null ? ($item->quantity * $productParent->quantity) : $item->quantity;
                if ($stock == null) {
                // if ($stock == null || $quantity > $stock->quantity) {
                    return redirect()->back()->withInput()->with(['falha' => "Nao e possivel vender a quantidade {$item->quantity} do produto {$product->name}. Stock e: [$resto] na(o) {$store->name}."]);
                }
            }
            $credit = $this->credit->create($request->all());
            foreach ($items as $item) {
                $data = [
                    'barcode' => $item->barcode,
                    'product_id' => $item->product_id,
                    'name' => $item->name,
                    'quantity' => $item->quantity,
                    'unitprice' => $item->unitprice,
                    'rate' => $item->rate,
                    'subtotal' => $item->subtotal,
                ];
                $productParent = ProductChild::where('child', $item->product_id)->first();
                $stock = Stock::where('product_id', ($productParent != null ? $productParent->parent : $item->product_id))->where('store_id', $store->id)->first();
                $stock->quantity -= $productParent != null ? ($productParent->quantity * $item->quantity) : $item->quantity;
                $stock->operation = "Crédito Nr. {$credit->id}";

//                $stock = Stock::where('product_id', $item->product_id)->where('store_id', $request->store_id)->first();
//                $stock->quantity -= $item->quantity;
                $credit->items()->create($data);
                $stock->update(); #Update account
                $item->delete();
            }
            $account = Account::find($request->account_id);
            $account->credit += $request->total;
            $account->balance = $account->debit - $account->credit;
            $account->update();
            DB::commit();
            return redirect()->route('credit.show', $credit->id)->with(['sucesso' => 'Credito criada com sucesso.']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['falha' => 'Falha na criacao da credito:' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Credit  $credit
     * @return \Illuminate\Http\Response
     */
    public function show(Credit $credit) {
        return view('credit.show', compact('credit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Credit  $credit
     * @return \Illuminate\Http\Response
     */
    public function edit(Credit $credit) {
        $accounts = Account::latest()->get();
        return view('credit.edit', compact('credit', 'accounts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Credit\UpdateCredit  $request
     * @param  \App\Models\Credit  $credit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCredit $request, Credit $credit) {
        $credit->day = $request->day;
        $credit->account_id = $request->account_id;
        $credit->credit = $request->credit;
        $credit->debit = $request->debit;
        $credit->balance = $request->balance;
        $credit->discount = $request->discount;
        $update = $credit->update();
        if ($update) {
            return redirect()->route('credit.show', $credit->id)->with(['sucesso' => 'Credito actualizado com sucesso.']);
        } else {
            return redirect()->back()->with(['falha' => 'Falha na Actualização da credito.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Credit  $credit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Credit $credit) {
        DB::beginTransaction();
        try {
            $store = Store::first();
            $items = $credit->items;
            foreach ($items as $item) {
//                    $item = \App\Models\Item::find($item->id);
                $productParent = ProductChild::where('child', $item->product_id)->first();
                $stock = Stock::where('product_id', ($productParent != null ? $productParent->parent : $item->product_id))->where('store_id', $store->id)->first();
                $quantity = $productParent != null ? ($item->quantity * $productParent->quantity) : $item->quantity;
                $stock->quantity += $quantity;
                $stock->operation = "Cancelamento do Crédito Nr. {$credit->id}";
                $stock->update(); #Update account
                $item->delete();
            }
            $account = $credit->account;
            $account->credit -= $credit->total;
            $account->balance = $account->debit - $account->credit;
            $account->update();
            $credit->delete();
            DB::commit();
            return redirect()->route('credit.index')->with(['info' => 'Credito suprimido com sucesso.']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['falha' => 'Falha na criacao da credito: ' . $e->getMessage()]);
        }
    }

    public function search(Request $request) {
        $dados = $request->except("_token");
        $string = $request->criterio;
        $credits = $this->credit->where('id', 'LIKE', '%' . $string . '%')
                        ->orWhere('nr_requisicao', 'LIKE', '%' . $string . '%')
                        ->orWhere('nr_factura', 'LIKE', '%' . $string . '%')
                        ->orWhereHas('account', function($query) use ($string) {
                            $query->where('account_id', 'LIKE', '%' . $string . '%')
                            ->orWhere('credit', 'LIKE', '%' . $string . '%')
                            ->orWhere('debit', 'LIKE', '%' . $string . '%')
                            ->orWhere('balance', 'LIKE', '%' . $string . '%')
                            ->orWhere('discount', 'LIKE', '%' . $string . '%')
                            ->OrWhereHasMorph('accountable', '*', function($query) use ($string) {
                                $query->where('fullname', 'like', '%' . $string . '%')
                                ->orWhere('nuit', 'like', '%' . $string . '%')
                                ->orWhere('phone_nr', 'like', '%' . $string . '%')
                                ->orWhere('phone_nr_2', 'like', '%' . $string . '%')
                                ->orWhere('address', 'like', '%' . $string . '%');
                            });
                        })
                        ->latest()->paginate($this->limit);
        return view('credit.search', compact('dados', 'credits'));
    }

    public function byAccount(Request $request) {
        $account = Account::find($request->id);
        $credits = $account->credits()->latest()->paginate($this->limit);
        return view('credit.by_account', compact('credits'));
    }

    public function searchByAccount(Request $request) {
        $account = Account::find($request->id);
//        dd($account->credits);
        $dados = $request->all();
        $string = $request->criterio;
        $credits = $account->credits()->where('id', 'LIKE', '%' . $string . '%')
                        ->orWhere('nr_requisicao', 'LIKE', '%' . $string . '%')
                        ->orWhere('nr_factura', 'LIKE', '%' . $string . '%')
                        ->orWhereHas('account', function($query) use ($string) {
                            $query->where('account_id', 'LIKE', '%' . $string . '%')
                            ->orWhere('credit', 'LIKE', '%' . $string . '%')
                            ->orWhere('debit', 'LIKE', '%' . $string . '%')
                            ->orWhere('balance', 'LIKE', '%' . $string . '%')
                            ->orWhere('discount', 'LIKE', '%' . $string . '%');
                        })
//                        ->orWhereHasMorph('accountable', '*', function($query) use ($string) {
//                            $query->where('id', 'LIKE', '%' . $string . '%') > orWhere('fullname', 'LIKE', '%' . $string . '%')
//                                    ->orWhere('fullname', 'LIKE', '%' . $string . '%')
//                                    ->orWhere('type', 'LIKE', '%' . $string . '%')
//                                    ->orWhere('nuit', 'LIKE', '%' . $string . '%')
//                                    ->orWhere('document_type', 'LIKE', '%' . $string . '%')
//                                    ->orWhere('document_number', 'LIKE', '%' . $string . '%')
//                                    ->orWhere('phone_nr', 'LIKE', '%' . $string . '%')
//                                    ->orWhere('phone_nr_2', 'LIKE', '%' . $string . '%')
//                                    ->orWhere('email', 'LIKE', '%' . $string . '%')
//                                    ->orWhere('address', 'LIKE', '%' . $string . '%')
//                                    ->orWhere('description', 'LIKE', '%' . $string . '%');
//                        })
                        ->latest()->paginate($this->limit);
        return view('credit.search', compact('dados', 'credits'));
    }

    public function cancel(Request $request) {
        $request->session()->forget('items');
        return redirect()->route('credit.create', ['id' => $request->id])->with('info', 'Criacao de credito cancelada!');
    }

    public function copy(Request $request, $id) {
        $items = $this->credit->find($id)->items;
        foreach ($items as $item) {
            $product = Product::find($item->product_id);
            if ($product != null) {
                $data = [
                    'product_id' => $product->id,                    
                    'barcode' => $product->barcode,
                    'name' => $product->name,
                    'quantity' => $item->quantity,
                    'unitprice' => $product->price,
                    'rate' => $product->rate,
                    'subtotal' => $product->price * $item->quantity,
                ];
                if (auth()->user()->temp_items()->where('product_id', $item->product_id)->first() == null) {
                    auth()->user()->temp_items()->create($data);
                }
            }
        }
        return redirect()->back()->with(['sucesso' => __('messages.item.copied')]);
    }

    public function send(StoreSendEmail $request) {
//        dd($request->all());
        try {
            $company = Company::first();
            $account = Account::find($request->sent_id);
            $to = $request->email;
            $description = $request->description;
            $type = $request->type;
            Mail::to($to)->send(new \App\Mail\SendCredit($company, $account, $description, $type));
//            Store what was sent
            if ($type == "DIVIDAS") {
                $total = $account->credits()->where('payed', false)->sum('total');
            } else {
                $total = $account->credits()->sum('total');
            }
            $data = [
                'message' => $description,
                'amount' => $total,
                'description' => $description,
            ];
            $account->sents()->create($data);
            return redirect()->back()->with(['sucesso' => 'Cotação enviada com sucesso.']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['falha' => 'Ocorreu um erro:' . $e->getMessage()])->withInput();
        }
    }

}
