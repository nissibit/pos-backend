<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProduct;
use App\Http\Requests\Product\UpdateProduct;
use App\Models\Account;
use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use App\Models\TempItem;
use App\Models\Unity;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Store;
use function auth;
use function GuzzleHttp\json_encode;
use function redirect;
use function view;
use DB;
use App\Models\Conversao;
use App\Http\Requests\Product\StoreProductChild;
use App\Models\ProductChild;
use App\Models\Factura;

class MotherController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    private $product;
    private $limit = 10;

    function __construct(Product $product) {
        $this->product = $product;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
//        $products = $this->product->latest()->take($this->limit)->get();
        $products = $this->product->where('search', false)->latest()->paginate($this->limit);
        return view('mother.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $categories = Category::all()->sortBy('name');
        $unities = Unity::all()->sortBy('name');
        return view('mother.create', compact('categories', 'unities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    private function generateCode($id, $field) {
        $category = Category::findOrfail($id);
        $qtd = $category->products()->withTrashed()->count() + 1;
        $prefixo = substr($category->label, 0, 4);
        $code = $prefixo . str_pad($qtd, 4, '0', STR_PAD_LEFT);
        while ($this->product->where($field, $code)->withTrashed()->count() > 0) {
            $qtd++;
            $code = $prefixo . str_pad($qtd, 4, '0', 0);
        }
        return $code;
    }

    public function updateProducts() {
        $products = $this->product->all();
        foreach ($products as $p) {
            $product = $this->product->find($p->id);
            echo "{$product->barcode} / ";
            $code = $this->generateCode($product->category_id, 'barcode');
            $product->barcode = $code;
            $product->othercode = $code;
            $product->update();
            echo "{$product->barcode} updated <br />";
        }
    }

    public function store(StoreProduct $request) {
        try {
            $data = $request->except(['stock']);
            if ($request->generate_barcode ?? '' != '') {
                $data['barcode'] = $this->generateCode($request->category_id, 'barcode');
            }
            $data['othercode'] = $data['barcode'];
            $data['search'] = false;
            if ($this->product->where('barcode', $data['barcode'])->orWhere('othercode', $data['othercode'])->count() > 0) {
                return redirect()->back()->with(['falha' => 'O Codigo do produto ja existe.']);
            }
            #dump($request->all());
            #dd($data);

            DB::beginTransaction();
            $product = $this->product->create($data);
            $stock = Stock::create(['product_id' => $product->id, 'quantity' => $request->quantity, 'store_id' => Store::first()->id, 'description' => '']);
            DB::commit();
            return redirect()->route('mother.show', $product->id)->with(['sucesso' => "Produto Criado com sucesso. Stock {$stock->quantity}"]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['falha' => __('messages.prompt.request_failure') . ' : ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Product  $product
     * @return Response
     */
    public function show($id) {
        $product = $this->product->find($id);
        return view('mother.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Product  $product
     * @return Response
     */
    public function edit($id) {
        $product = $this->product->find($id);
        $categories = Category::all()->sortBy('name');
        $unities = Unity::all()->sortBy('name');
        return view('mother.edit', compact('product', 'categories', 'unities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateProduct  $request
     * @param  Product  $product
     * @return Response
     */
    public function update(UpdateProduct $request, $id) {
//        if ($this->product->where('barcode', $request->barcode)->orWhere('othercode', $request->othercode)->where('id', '!=',$product->id)->count() > 0) {
//            return redirect()->back()->with(['falha' => 'O Codigo do produto ja existe noutro produto.']);
//        }
//                dd($request->all());
        $product = $this->product->find($id);
        #Update barcode and other code
        $code = $product->barcode;
        if ($product->category_id != $request->category_id) {
            $code = $this->generateCode($request->category_id, 'barcode');
        }
        $product->barcode = $code;
        $product->othercode = $code;
        $product->name = $request->name;
        $product->label = $request->label;
        $product->category_id = $request->category_id;
        $product->unity_id = $request->unity_id;
        $product->price = $request->price;
        $product->margem = $request->margem;
        $product->run_out = $request->run_out;
        $product->flap = $request->flap;
        $product->flap_12 = $request->flap_12;
        $product->flap_14 = $request->flap_14;
        $product->flap_18 = $request->flap_18;
        $product->rate = $request->rate;
        $product->description = $request->description;
        $product->search = ($request->search ?? false) == 'on' ? true : false;
        $update = $product->update();
        if ($update) {
            return redirect()->route('mother.show', $product->id)->with(['sucesso' => 'Produto actualizado com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na actualização do produto mãe.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id Id of product
     * @return Response
     */
    public function destroy($id) {
        try {
            $product = Product::find($id);
            $stocks = $product->stocks();
//            dd($product);
            foreach ($stocks as $stock) {
//                $stock = Stock::find($s->id);
                $stock->delete();
            }
            $product->delete();
            return redirect()->route('mother.index')->with(['info' => 'Produto principal suprimido.']);
        } catch (Exception $ex) {
            return redirect()->back()->with(['falha' => __('messages.prompt.request_failure') . "<br />" . $ex->getMessage()]);
        }
    }

    public function search(Request $request) {
        $dados = $request->all();
        $products = $this->product->where("search", false)
                        ->where('name', 'LIKE', '%' . $request->criterio . '%')                        
                        ->latest()->paginate($this->limit);
        return view('mother.index', compact('dados', 'products'));
    }

    public function searchByCategory(Request $request) {
        $dados = $request->all();
        $products = $this->product->where('category_id', $request->category_id)
                ->latest()
                ->paginate($this->limit);
        return view('mother.index', compact('dados', 'products'));
    }

    public function searchByUnity(Request $request) {
        $dados = $request->all();
        $products = $this->product->where('unity_id', $request->unity_id)
                ->latest()
                ->paginate($this->limit);
        return view('mother.index', compact('dados', 'products'));
    }

    private function searchProduct($string) {
        $products = Product::where('id', 'LIKE', '%' . $string . '%')
                        ->OrWhere('barcode', 'LIKE', '%' . $string . '%')
                        ->OrWhere('othercode', 'LIKE', '%' . $string . '%')
                        ->OrWhere('price', 'LIKE', '%' . $string . '%')
//                        ->OrWhere('stock', 'LIKE', '%' . $string. '%')
                        ->OrWhere('rate', 'LIKE', '%' . $string . '%')
                        ->OrWhere('name', 'LIKE', '%' . $string . '%')
                        ->orWhere('label', 'LIKE', '%' . $string . '%')
                        ->orWhere('description', 'LIKE', '%' . $string . '%')
                        ->orWhereHas('category', function($query) use ($string) {
                            $query->Where('name', 'LIKE', '%' . $string . '%');
                            $query->orWhere('label', 'LIKE', '%' . $string . '%');
                            $query->orWhere('description', 'LIKE', '%' . $string . '%');
                        })
                        ->orWhereHas('category', function($query_2) use ($string) {
                            $query_2->Where('name', 'LIKE', '%' . $string . '%');
                            $query_2->orWhere('label', 'LIKE', '%' . $string . '%');
                            $query_2->orWhere('description', 'LIKE', '%' . $string . '%');
                        })->whereHas('store', function($query3) {
                            $query3->where('quantity', '>', 0);
                        })
                        ->latest()->take($this->limit)->get();
        return $products;
    }

    public function getProductAutoComplete(Request $request) {
        $string = $request->term ?? '';
        $products = $this->searchProduct($string);
        $result = array();
        foreach ($products as $product) {
            if ($product->search) {
                array_push($result, ['label' => $product->name . "({$product->barcode})", 'value' => $product->id, 'name' => strtoupper($product->name), 'id' => $product->id, 'barcode' => $product->barcode]);
            }
        }
        return json_encode($result);
    }

    /*     * * Para items de venda *** /
     * 
     */

    public function getProduct(Request $request) {
        $id = $request->id;
        $searchBy = $request->searchBy;
        $product = Product::where($searchBy ?? 'id', $id)->first();
        $store = Store::first();
        $stock = Stock::where('store_id', $store->id)->where('product_id', $product->id)->first();
        $product->description = $stock != null ? $stock->quantity : 0;

        dd($request->all());
        return json_encode($product != null ? $product : null);
    }

    public function lastProductAdded(Request $request) {
        $id = auth()->user()->temp_items()->latest()->first()->product_id;
        $product = Product::find($id ?? 0);
        $store = Store::first();
        $productParent = ProductChild::where('child', $product->id)->first();

        $stock = Stock::where('product_id', ($productParent != null ? $productParent->parent : $product->id))->where('store_id', $store->id)->first();

        $product->description = $stock != null ? $stock->quantity : 0;
        return json_encode($product != null ? $product : null);
    }

    public function Additems(Request $request) {
        $id = $request->id;
        $operation = $request->operation;
        $searchBy = $request->searchBy;
        $quantity = $request->quantity ?? 1;
        $account = $request->account_id ?? null;
        $product = Product::where($searchBy ?? 'id', $id)->first();
        $user = auth()->user();
        $items = $user->temp_items;
        $this->update_items($items, $product, $operation, $quantity, $account);
        $data = $user->temp_items()->latest()->get();
        return json_encode($data);
    }

    private function update_items($items, $product, $operation, $quantity, $account) {
        if ($product != null) {
            $price = $product->price;
            $Account = new Account();
            if ($account != null) {
                $Account = Account::find($account);
                $price += $price * $Account->extra_price / 100;
            }
            // dd($price);
            $found = false;
            foreach ($items as $item) {
                if (($item->product_id ?? '') == $product->id) {
                    $found = true;
                    if ($operation == 0) {
                        $item->quantity = 0;
                        $item->subtotal = 0;
                        $item->delete();
                    } elseif ($operation == 1) {
                        $item->quantity += 1;
                        $item->subtotal += $price;
                        $item->update();
                    } elseif ($operation == -1) {
                        $item->quantity -= 1;
                        $item->subtotal -= $price;
                        $item->update();
                    } elseif ($operation == 99) {
                        $item->quantity = $quantity;
                        $item->subtotal = $price * $quantity;
                        $item->update();
                    }
                }
            }
            if (!$found) {
                $item = $this->createNewitem($product, $quantity, $price);
                auth()->user()->temp_items()->create($item->toArray());
            }
        }
//        return $items;
    }

    private function createNewitem($product, $quantity, $price) {
        $item = new TempItem();
        $item->quantity = $quantity;
        $item->product_id = $product->id;
        $item->name = $product->name;
        $item->unitprice = $price;
        $item->rate = $product->rate;
        $item->subtotal = $price * $quantity;
        return $item;
    }

    public function addProduct($id) {
        $user = auth()->user();
        $product = $this->product->find($id);
        $temp = $user->temp_items->where('product_id', $product->id)->first();
        if ($temp != null) {
            $temp->quantity += 1;
            $temp->update();
        } else {
            $price = $product->price;
            $item = new TempItem();
            $item->quantity = 1;
            $item->product_id = $product->id;
            $item->name = $product->name;
            $item->unitprice = $price;
            $item->rate = $product->rate;
            $item->subtotal = $price;
            auth()->user()->temp_items()->save($item);
        }
        return redirect()->back()->with(['info' => 'Artigo adicionado!']);
    }

    public function exchangeGet($id) {
        $stores = \App\Models\Store::all();
        $stock = Stock::find($id);
        $product = $stock->product;
        return view('mother.exchange', compact('product', 'stock', 'stores'));
    }

    public function exchangePost(Request $request) {
        if ($request->product_id == $request->product_destin) {
            return redirect()->back()->withInput()->with(['info' => 'Os produtos envolvidos devem ser diferenres.']);
        } else if ($request->quantity == 0 || $request->quantity < $request->send_quantity) {
            return redirect()->back()->withInput()->with(['info' => 'Stock insuficiente para executar.']);
        }
        $store = Store::first();
        $stock_from = Stock::where('store_id', $store->id)->where('product_id', $request->product_id)->first();
        $stock_to = Stock::where('store_id', $store->id)->where('product_id', $request->product_destin)->first();
        if ($stock_to == null) {
            return redirect()->back()->withInput()->with(['info' => 'Nao pode transferir para esse produto.']);
        }
        if (strtoupper($stock_to->product->category->name) != 'RETALHO') {
            return redirect()->back()->withInput()->with(['info' => 'O produto destino não está na categoria RETALHO.']);
        }

        DB::beginTransaction();
        try {
            $total = $request->send_quantity * $request->flap;
            $stock_from->quantity -= $request->send_quantity;
            $stock_from->update();
            $stock_to->quantity += $total;
            $stock_to->update();
            //Save to Table conversao
            $data = [
                'from' => $stock_from->id,
                'to' => $stock_to->id,
                'quantity' => $request->send_quantity,
                'flap' => $request->flap,
                'total' => $total
            ];
            Conversao::create($data);
            DB::commit();
            return redirect()->route('mother.show', $request->product_id)->with(['sucesso' => 'Conversão efectuada com sucesso.']);
        } catch (\Exceprion $e) {
            DB::rollback();
            return redirect()->back()->with(['falha' => 'Falha na operacao..: ' . $e->getMessage()]);
        }
    }

    public function storeChild(StoreProductChild $request) {
//        dd($request->all());
        if ($request->parent == $request->child) {
            return redirect()->back()->withInput()->with(['info' => 'Os produtos envolvidos devem ser diferenres.']);
        }
        $parent = $this->product->find($request->parent);
        $child = $this->product->find($request->child);
//        if ($child->category->name != 'RETALHO') {
//            return redirect()->back()->withInput()->with(['info' => 'O produto DEVE PERTENCER  a categoria RETALHO.']);
//        }
        $pChild = ProductChild::where('child', $child->id)->where('parent', $parent->id)->withTrashed();
        if ($pChild->count() > 0) {
            #Vamos adidionar novamente o produto
//            return redirect()->back()->withInput()->with(['info' => 'O produto já foi adicionado. Contacte o administrador.']);
            return view('mother.child_restore', ['productChild' => $pChild->first(), 'data' => $request->all()]);
        }
        try {
            $parent->children()->create($request->all());
            return redirect()->route('mother.show', $parent->id)->with(['sucesso' => 'Produto adicionado com sucesso.']);
        } catch (\Exceprion $e) {
            return redirect()->back()->with(['falha' => 'Falha na operacao..: ' . $e->getMessage()]);
        }
    }

    public function destroyChild(Request $request) {
        try {
            $child = ProductChild::find($request->id);
            $child->delete();
            return redirect()->back()->with(['info' => 'O produto suprimido.']);
        } catch (\Exceprion $e) {
            return redirect()->back()->with(['falha' => 'Falha na operacao..: ' . $e->getMessage()]);
        }
    }

    public function restoreChild(Request $request) {
        try {
            $child_deleted = ProductChild::withTrashed()->where('id', $request->id)->first();
            $child_deleted->restore();
            $child = ProductChild::find($request->id);
            $child->quantity = $request->quantity;
            $child->update();
            $product = $child->productByChild->name;
            return redirect()->route('mother.show', $child->parent)->with(['sucesso' => "O produto {$product} para retalho foi restaurado."]);
        } catch (\Exceprion $e) {
            return redirect()->back()->with(['falha' => 'Falha na operacao..: ' . $e->getMessage()]);
        }
    }

    public function getStatistic(Request $request) {
        $data = $request->all();
        $product = $this->product->find($request->id);
//        dd($product);
        $items = \App\Models\Item::with('product')->whereDate('created_at', '>=', $request->from)
                ->whereDate('created_at', '<=', $request->to)
                ->where('item_type', 'App\Models\Factura')
                ->where('product_id', $product->id)
                ->groupBy('created_at')
                ->orderBy('created_at', 'DESC')
                ->get(array(
            DB::raw('created_at as created_at'),
            DB::raw('SUM(unitprice) as "unitprice"'),
            DB::raw('SUM(rate) as "rate"'),
            DB::raw('SUM(subtotal) as "total"'),
            DB::raw('SUM(quantity) as "qtd"'),
            DB::raw('COUNT(*) as "vendas"')
        ));

        return view('mother.query_statistic', compact('items', 'product', 'data'));
    }

    public function setCustomerDetails(Request $request) {
        $validatedData = $request->except('_token');
        if (empty($request->session()->get('item'))) {
            $item = new Factura();
        } else {
            $item = $request->session()->get('item');
        }
        $item->fill($validatedData);
        $request->session()->put('item', $item);
        return json_encode($item);
    }

}
