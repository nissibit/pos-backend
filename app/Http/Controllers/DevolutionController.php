<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Devolution;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Requests\Devolution\StoreDevolution;
use App\Models\Loan;
use App\Models\Stock;
use DB;

class DevolutionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $devolution;
    private $limit = 10;

    function __construct(Devolution $devolution) {
        $this->devolution = $devolution;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
        $devolutions = $this->devolution->latest()->paginate($this->limit);
        return view('devolution.index', compact('devolutions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $loan = Loan::findOrfail($request->id);
        $articles = $loan->articles;
        return view('devolution.create', compact('loan', 'articles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function extractIdAndQuantity($data) {
        $articleQuantity = [];
        foreach ($data as $key => $value) {
            if (str_contains($key, 'article_') && $value > 0) {
                $articleQuantity[str_replace('article_', '', $key)] = $value;
            }
        }
        return $articleQuantity;
    }

    public function store(StoreDevolution $request) {
        #dd($request->all());
        DB::beginTransaction();
        try {
            $store = Store::first();
            #Get the quantity to return andcorrecpondent id
            $articleQuantity = $this->extractIdAndQuantity($request->all());
            if (count($articleQuantity) <= 0) {
                return redirect()->back()->withInput()->with(['info' => "Informe pelo menos um produto a devolver."]);
            }
            #dd($articleQuantity);
            #Get the items of loan
            $loan = Loan::find($request->loan_id);
            $articles = $loan->articles;
            #Check if the current quantity is less or equal of required
            foreach ($articleQuantity as $key => $item) {
                $article = Article::find($key);
                #Get total return quantity for especific item
                $totalReturned = $article->devolutions->sum('quantity');
                $quantityToReturn = $articleQuantity[$key];
                $total = $totalReturned + $quantityToReturn;
                $balance = $article->quantity - $totalReturned;
                if ($total > $article->quantity) {
                    return redirect()->back()->withInput()->with(['info' => "A quantidade por retornar para {$article->name} é {$balance} "]);
                }
            }

            $devolution = $this->devolution->create([
                'loan_id' => $request->loan_id,
                'description' => $request->description
            ]);
            foreach ($articleQuantity as $key => $value) {
                $devolution->items()->create([
                    'article_id' => $key,
                    'quantity' => $value,
                ]);
                #Returning the stock
                $product_id = Article::find($key)->product_id;
                $stock = Stock::where('product_id', $product_id)->where('store_id', $store->id)->first();
                $stock->quantity += $value;
                $stock->update();                
            }
            #Determineif all items were returned
            if ($loan->articles->sum('quantity') == $loan->items->sum('quantity')) {
                $loan->status = 'PAGO';
                $loan->update();
            }
            DB::commit();
            return redirect()->route('devolution.show', $devolution->id)->with(['sucesso' => __('messages.prompt.request_done')]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with(['falha' => __('messages.prompt.request_failure') . ' : ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Devolution  $devolution
     * @return \Illuminate\Http\Response
     */
    public function show(Devolution $devolution) {
        return view('devolution.show', compact('devolution'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Devolution  $devolution
     * @return \Illuminate\Http\Response
     */
    public function edit(Devolution $devolution) {
        return view('devolution.edit', compact('devolution'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Request  $request
     * @param  \App\Models\Devolution  $devolution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Devolution $devolution) {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Devolution  $devolution
     * @return \Illuminate\Http\Response
     */
    public function destroy(Devolution $devolution) {
        DB::beginTransaction();
        try {
//            Devolver o stock:
            $items = $devolution->items;
            $store = Store::first();
            foreach ($items as $item) {
                $stock = Stock::where('store_id', $store->id)->where('product_id', $item->article->product_id)->first();
                $stock->quantity += $item->quantity;
                $stock->update();
            }
            $devolution->items()->delete();
            $devolution->delete();
            DB::commit();
            return redirect()->route('devolution.index')->with(['info' => __('messages.prompt.request_done')]);
        } catch (\Exceprion $e) {
            DB::rollback();
            return redirect()->back()->with(['falha' => __('messages.prompt.request_failure') . ' : ' . $e->getMessage()]);
        }
    }

    public function search(Request $request) {
//        $dados = $request->all();
//        $string = $request->criterio;
//        $devolutions = $this->devolution->where('id', 'LIKE', '%' . $string . '%')
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
//        return view('devolution.search', compact('dados', 'devolutions'));

        return redirect()->back()->withInput();
    }

    public function copy(Request $request, $id) {
        $items = $this->devolution->find($id)->items;
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

    public function devolutionByLoan($id) {
        $devolutions = $this->devolution->where('loan_id', $id)->paginate($this->limit);
        return view('loan.devolutions', compact('devolutions'));
    }

}
