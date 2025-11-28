<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;
use App\Http\Requests\Account\StoreQuotation;
use App\Http\Requests\Account\UpdateQuotation;
use App\Models\Store;
use App\Models\Product;
use Carbon\Carbon;
use DB;
use App\Http\Requests\Email\StoreSendEmail;
use Mail;
use App\Mail\SendQuotation;
use App\Models\Company;

class QuotationController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $quotation;
    private $limit = 10;

    function __construct(Quotation $quotation) {
        $this->quotation = $quotation;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
//         $quotations = $this->quotation->latest()->paginate($this->limit);
        $quotations = $this->quotation->whereDate('created_at', '>=', Carbon::today()->subDays(7))->latest()->paginate($this->limit);
        return view('quotation.index', compact('quotations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectCustomer() {
        $accounts = Quotation::latest()->take($this->limit)->get();
        return view('quotation.select_customer', compact('accounts'));
    }

    public function create() {
        $store = Store::first();
        if ($store == null) {
            return redirect()->back()->withInput()->with('info', 'Nao ha loja pra se fazer a venda.');
        }
        return view('quotation.create', compact('accounts', 'store'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuotation $request) {
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
            $quotation = null;
            if ($request->customer_name == null) {
                return redirect()->back()->withInput()->with(['falha' => 'Seleccione ou informe o cliente clientes.']);
            }
            if ($request->total <= 0) {
                return redirect()->back()->withInput()->with(['falha' => 'Seleccione pelo menos um artigo.']);
            }
            $ans = array();
            $quotation = $this->quotation->create($request->all());
            $ans[] = $quotation;
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
                $ans[] = $quotation->items()->create($data); // 
                $item->delete();
            }
            DB::commit();
            if (!in_array(false, $ans)) {
                $request->session()->forget('items');
                return redirect()->route('quotation.show', $quotation->id)->with(['sucesso' => 'Cotação criada com sucesso.']);
            } else {
                return redirect()->back()->with(['falha' => 'Falha na criacao da quotation.']);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['falha' => 'Falha na criacao da factura.: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function show(Quotation $quotation) {
        return view('quotation.show', compact('quotation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function edit(Quotation $quotation) {
        $request = new Request(array('id' => $quotation->id));
//        dd($request->all());
        $artigos = $this->quotation->find($request->id)->items();
        if (!(is_array($request->session()->get('items')))) {
            $items = array();
        } else {
            $items = array();
        }
        dd($artigos);
        $request->session()->put('items', $artigos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Quotation\UpdateQuotation  $request
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuotation $request, Quotation $quotation) {
        $quotation->day = $request->day;
        $quotation->account_id = $request->account_id;
        $quotation->quotation = $request->quotation;
        $quotation->debit = $request->debit;
        $quotation->balance = $request->balance;
        $quotation->discount = $request->discount;
        $update = $quotation->update();
        if ($update) {
            return redirect()->route('quotation.show', $quotation->id)->with(['sucesso' => 'Cotação actualizada com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da quotationo.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quotation $quotation) {
        $delete = $quotation->delete();
        if ($delete) {
            return redirect()->route('quotation.index')->with(['info' => 'Cotação suprimida com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da quotationo.']);
        }
    }

    public function search(Request $request) {
        $dados = $request->all();
        $string = $request->criterio;
        $quotations = $this->quotation->where('id', 'LIKE', '%' . $string . '%')
                        ->OrWhere('customer_id', 'LIKE', '%' . $string . '%')
                        ->OrWhere('customer_name', 'LIKE', '%' . $string . '%')
                        ->OrWhere('customer_phone', 'LIKE', '%' . $string . '%')
                        ->OrWhere('subtotal', 'LIKE', '%' . $string . '%')
                        ->OrWhere('totalrate', 'LIKE', '%' . $string . '%')
                        ->OrWhere('discount', 'LIKE', '%' . $string . '%')
                        ->OrWhere('total', 'LIKE', '%' . $string . '%')
                        ->OrWhere('day', 'LIKE', '%' . $string . '%')
                        ->OrWhere('payed', 'LIKE', '%' . $string . '%')
                        ->latest()->paginate($this->limit);
        return view('quotation.search', compact('dados', 'quotations'));
    }

    public function cancel(Request $request) {
        $request->session()->forget('items');
        return redirect()->route('quotation.create')->with('info', 'Criacao da Cotação cancelada!');
    }

    public function copy(Request $request, $id) {
        $items = $this->quotation->find($id)->items;
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
            $quotation = $this->quotation->find($request->sent_id);
            $to = $request->email;
            $description = $request->description;
            Mail::to($to)->send(new SendQuotation($company, $quotation, $description));
//            Store what was sent
            $subtotal = $quotation->items()->sum('subtotal') / 1.16;
            $subtotalLiquido = $subtotal - $quotation->discount;
            $total = $subtotalLiquido * 1.16;
            $data = [
                'message' => $description,
                'amount' => $total,
                'description' => $description,
            ];
            $quotation->sents()->create($data);
            return redirect()->back()->with(['sucesso' => 'Cotação enviada com sucesso.']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['falha' => 'Ocorreu um erro:' . $e->getMessage()])->withInput();
        }
    }

}
