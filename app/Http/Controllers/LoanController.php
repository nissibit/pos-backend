<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Requests\Loan\StoreLoan;
use App\Models\Partner;
use App\Models\Stock;
use DB;

class LoanController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $loan;
    private $limit = 10;

    function __construct(Loan $loan) {
        $this->loan = $loan;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
        $loans = $this->loan->latest()->paginate($this->limit);
        return view('loan.index', compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $partner = Partner::findOrfail($request->id);
        $temps = auth()->user()->temps;
        return view('loan.create', compact('partner', 'temps'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLoan $request) {
        DB::beginTransaction();
        try {
            $articles = auth()->user()->temp_items;
            $store = Store::first();
            if ($articles->count() <= 0) {
                return redirect()->back()->withInput()->with(['falha' => __('messages.sale.request_items')]);
            }
            $loan = $this->loan->create($request->all());

            foreach ($articles as $article) {
                $loan->articles()->create($article->toArray());
                #Update Stock:
                $stock = Stock::where('store_id', $store->id)->where('product_id', $article->product_id)->first();
                $stock->quantity -= $article->quantity;
                $stock->operation = "Empréstimo Nr. {$loan->id}";
                $stock->update();
            }

            auth()->user()->temp_items()->delete();
            DB::commit();
            return redirect()->route('loan.show', $loan->id)->with(['sucesso' => __('messages.prompt.request_done')]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['falha' => __('messages.prompt.request_failure') . ' : ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan) {
        return view('loan.show', compact('loan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan) {
        return view('loan.edit', compact('loan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loan $loan) {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan) {
        DB::beginTransaction();
        try {
//            Devolver o stock:
            $articles = $loan->articles;
            $store = Store::first();
            foreach ($articles as $article) {
                $stock = Stock::where('store_id', $store->id)->where('product_id', $article->product_id)->first();
                $stock->quantity += $article->quantity;
                $stock->operation = "Cancelamento do Empréstimo Nr. {$loan->id}";
                $stock->update();
            }
            $loan->articles()->delete();
            $loan->devolutions()->delete();
            $loan->delete();
            DB::commit();
            return redirect()->route('loan.index')->with(['info' => __('messages.prompt.request_done')]);
        } catch (\Exceprion $e) {
            DB::rollback();
            return redirect()->back()->with(['falha' => __('messages.prompt.request_failure') . ' : ' . $e->getMessage()]);
        }
    }

    public function search(Request $request) {
//        $dados = $request->all();
//        $string = $request->criterio;
//        $loans = $this->loan->where('id', 'LIKE', '%' . $string . '%')
//                        ->OrWhere('customer_id', 'LIKE', '%' . $string . '%')
//                        ->OrWhere('customer_name', 'LIKE', '%' . $string . '%')
//                        ->OrWhere('customer_phone', 'LIKE', '%' . $string . '%')
//                        ->OrWhere('subtotal', 'LIKE', '%' . $string . '%')
//                        ->OrWhere('totalrate', 'LIKE', '%' . $string . '%')
//                        ->OrWhere('discount', 'LIKE', '%' . $string . '%')
//                        ->OrWhere('total', 'LIKE', '%' . $string . '%')
//                        ->OrWhere('day', 'LIKE', '%' . $string . '%')
//                        ->OrWhere('payed', 'LIKE', '%' . $string . '%')
//                        ->latest()->paginate($this->limit);
//        return view('loan.search', compact('dados', 'loans'));
        return redirect()->back()->withInput();
    }

    public function copy(Request $request, $id) {
        $items = $this->loan->find($id)->items;
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

    public function devolutionsByLoan($id) {
        $loan = $this->loan->find($id);
        $devolutions = $loan->devolutions()->latest()->paginate($this->limit);
        return view('loan.devolutions', compact('devolutions', 'loan'));
    }

    public function loanByPartner($id) {
        $loans = Partner::findOrfail($id)->loans()->paginate(10);

        return view('partner.loans', compact('loans'));
    }

}
