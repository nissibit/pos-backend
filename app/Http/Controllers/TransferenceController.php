<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transference;
use Illuminate\Http\Request;
use App\Http\Requests\Store\StoreTransference;
use App\Http\Requests\Store\UpdateTransference;
use App\Models\Store;
use App\Models\Stock;
use App\Models\Item;

class TransferenceController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $transference;
    private $limit = 10;

    function __construct(Transference $transference) {
        $this->transference = $transference;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
        $transferences = $this->transference->latest()->take($this->limit)->get();
        return view('transference.index', compact('transferences'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $stores = Store::all();
        $product = Product::find($request->id ?? 0);
        return view('transference.create', compact('stores', 'product'));
    }

    /**
     * Transference a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransference $request) {
        if ($request->from == $request->to) {
            return redirect()->back()->withInput()->with(['falha' => 'Destino deve ser diferente de origem.']);
        }
        $items = $request->session()->get('items');
        $store_from = Store::findOrfail($request->from);
        $store_to = Store::findOrfail($request->to);
        foreach ($items as $item) {
            if ($item->quantity > 0) {
                $product = Product::find($item->product_id);
                $stock = Stock::where('product_id', $item->product_id)->where('store_id', $request->from)->first();
                $resto = $stock != null ? $stock->quantity : 0;
                if ($stock == null || $item->quantity > $stock->quantity) {
                    return redirect()->back()->withInput()->with(['falha' => "Nao e possivel transferir {$item->quanity} do produto {$product->name}. Stock e: [$resto] na {$store_from->name}."]);
                }
            }
        }
        $ans = array();
        $transference = new Transference();
        \DB::transaction(function () use($items, &$ans, &$request, &$store_from, &$store_to, &$transference) {
            $transference = $this->transference->create($request->all());
            $ans[] = $transference;
            foreach ($items as $item) {
                if ($item->quantity > 0) {
                    $product = Product::findOrfail($item->product_id);
                    $stock_from = Stock::where('store_id', $store_from->id)->where('product_id', $product->id)->first();
                    $stock_to = Stock::where('store_id', $store_to->id)->where('product_id', $product->id)->first();
                    if ($stock_from == null) {#create a new Stock;
                        return redirect()->back()->with(['falha' => 'Nao existe a quantidade do produto desejado no armazem de origem.']);
                    }
                    if ($stock_to == null) {
                        $ans[] = $stock_to = Stock::create(['store_id' => $store_to->id, 'product_id' => $product->id, 'quantity' => $item->quantity, 'description' => 'Recebimento de ' . $store_from->name]);
                    } else {
                        $stock_to->quantity += $item->quantity;
                        $ans[] = $stock_to->update();
                    }
                    $ans[] = $transference->items()->save($item);
                    $ans[] = $stock_from->quantity -= $item->quantity;
                    $ans[] = $stock_from->update();
                }
            }
        });
        #Reset a session
        if (!in_array(false, $ans)) {
            $request->session()->forget('items');
            return redirect()->route('transference.show', $transference->id)->with(['sucesso' => 'Transferência efectuada com sucesso.']);
        } else {
            return redirect()->back()->with(['falha' => 'Falha na criacao da transference.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transference  $transference
     * @return \Illuminate\Http\Response
     */
    public function show(Transference $transference) {
        return view('transference.show', compact('transference'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transference  $transference
     * @return \Illuminate\Http\Response
     */
    public function edit(Transference $transference) {
        $stores = Store::all();
        $product = Product::find($transference->product_id ?? 0);
        return view('transference.edit', compact('transference', 'stores', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Product\UpdateTransference  $request
     * @param  \App\Models\Transference  $transference
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransference $request, Transference $transference) {
        $transference->quantity = $request->quantity;
        $transference->product_id = $request->product_id;
        $transference->transference_id = $request->transference_id;
        $update = $transference->update();
        if ($update) {
            return redirect()->route('transference.show', $transference->id)->with(['sucesso' => 'Transference actualizada com sucesso.']);
        } else {
            return redirect()->back()->with(['info' => 'Falha na supressao da transference.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transference  $transference
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transference $transference) {
        $ans = array();
        \DB::transaction(function () use(&$ans, &$transference) {
            $items = $transference->items;
            foreach ($items as $value) {
                $item = Item::find($value->id);
                if ($item->quantity > 0) {
                    $stock_from = Stock::where('store_id', $transference->from)->where('product_id', $item->product_id)->first();
                    $stock_to = Stock::where('store_id', $transference->to)->where('product_id', $item->product_id)->first();
                    $ans[] = $stock_from->quantity += $item->quantity;
                    $ans[] = $stock_from->update();
                    $ans[] = $stock_to->quantity -= $item->quantity;
                    $ans[] = $stock_to->update();
                }
            }
            $ans[] = $transference->delete();
        });
        if (!in_array(false, $ans)) {
            return redirect()->route('transference.index')->with(['info' => 'Operação efectuada com sucesso.']);
        } else {
            return redirect()->back()->with(['falha' => 'Falha na criacao da transference.']);
        }
    }

    public function search(Request $request) {
        $dados = $request->all();
        $string = $request->criterio;
        $transferences = $this->transference->whereHas('store_from', function ($query) use($string) {
                    $query->where('name', 'LIKE', '%' . $string . '%')
                    ->oRwhere('label', 'LIKE', '%' . $string . '%');
                })->orWhereHas('store_to', function ($query1) use($string) {
                    $query1->where('name', 'LIKE', '%' . $string . '%')
                    ->oRwhere('label', 'LIKE', '%' . $string . '%');
                })
                ->Orwhere('day', 'LIKE', '%' . $string . '%')
                ->orWhere('motive', 'LIKE', '%' . $string . '%')
                ->orWhere('description', 'LIKE', '%' . $string . '%')
                ->latest()
                ->paginate($this->limit);
        return view('transference.search', compact('dados', 'transferences'));
    }

    public function print(Request $request) {
        $transference = $this->transference->find($request->id);
        return view('transference.print', compact('transference'));
    }

}
