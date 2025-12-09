<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProduct;
use App\Http\Requests\Product\StoreProductChild;
use App\Http\Requests\Product\UpdateProduct;
use App\Models\Account;
use App\Models\Category;
use App\Models\Conversao;
use App\Models\Factura;
use App\Models\Item;
use App\Models\Product;
use App\Models\ProductChild;
use App\Models\Stock;
use App\Models\Store;
use App\Models\TempItem;
use App\Models\Unity;
use App\Models\Credit;
use App\Models\Output;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function auth;
use function GuzzleHttp\json_encode;
use function redirect;
use function view;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller {

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
        $products = $this->product->where('search', true)->latest()->paginate($this->limit);
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $categories = Category::all()->sortBy('name');
        $unities = Unity::all()->sortBy('name');
        return view('product.create', compact('categories', 'unities'));
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
        $data = $request->all();
        if ($request->generate_barcode ?? '' != '') {
            $data['barcode'] = $this->generateCode($request->category_id, 'barcode');
        }
        $data['othercode'] = $data['barcode'];
        if ($this->product->where('barcode', $data['barcode'])->orWhere('othercode', $data['othercode'])->count() > 0) {
            return redirect()->back()->with(['falha' => 'O Codigo do produto ja existe.']);
        }
        #dump($request->all());
        #dd($data);
        $insert = $this->product->create($data);
        if ($insert) {
            return redirect()->route('product.show', $insert->id)->with(['sucesso' => 'Produto Criado com sucesso.']);
        } else {
            return redirect()->back()->with(['falha' => 'Falha na criação da categoria.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Product  $product
     * @return Response
     */
    public function show(Product $product) {
        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Product  $product
     * @return Response
     */
    public function edit(Product $product) {
        $categories = Category::all()->sortBy('name');
        $unities = Unity::all()->sortBy('name');
        return view('product.edit', compact('product', 'categories', 'unities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateProduct  $request
     * @param  Product  $product
     * @return Response
     */
    public function update(UpdateProduct $request, Product $product) {
//        if ($this->product->where('barcode', $request->barcode)->orWhere('othercode', $request->othercode)->where('id', '!=',$product->id)->count() > 0) {
//            return redirect()->back()->with(['falha' => 'O Codigo do produto ja existe noutro produto.']);
//        }
//                dd($request->all());
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
        $product->run_out = $request->run_out;
        $product->flap = $request->flap;
        $product->flap_12 = $request->flap_12;
        $product->flap_14 = $request->flap_14;
        $product->flap_18 = $request->flap_18;
        $product->rate = $request->rate;
        $product->buying = $request->buying;
        $product->margem = $request->margem;
        $product->description = $request->description;
        $product->search = ($request->search ?? false) == 'on' ? true : false;
        $update = $product->update();
        if ($update) {
            return redirect()->route('product.show', $product->id)->with(['sucesso' => 'Produto actualizada com sucesso.']);
        } else {
            return redirect()->back()->with(['falha' => 'Falha na actualização do produto']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product  $product
     * @return Response
     */
    public function destroy(Product $product) {
//        $stocks = Stock::where('product_id', $product->id)->get();
        $stocks = $product->stocks();
        foreach ($stocks as $s) {
//            $stock = Stock::find($s->id);
            $stock->delete();
        }
        $delete = $product->delete();
        if ($delete) {
            return redirect()->route('product.index')->with(['info' => 'Produto suprimida com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da categoria.']);
        }
    }

    public function search(Request $request) {
        $dados = $request->all();
        $string = $request->criterio;
        $products = Product::where('search', true)
                        ->where('name', 'LIKE', '%' . $string . '%')
                        ->orWhere(function ($query) use ($string) {
                            $query->Where('barcode', 'LIKE', '%' . $string . '%');
                        })->latest()->paginate($this->limit);

        #dd($products);
        return view('product.search', compact('dados', 'products'));
    }

    public function searchByCategory(Request $request) {
        $dados = $request->all();
        $products = $this->product->where('category_id', $request->category_id)
                ->latest()
                ->paginate($this->limit);
        return view('product.search', compact('dados', 'products'));
    }

    public function searchByUnity(Request $request) {
        $dados = $request->all();
        $products = $this->product->where('unity_id', $request->unity_id)
                ->latest()
                ->paginate($this->limit);
        return view('product.search', compact('dados', 'products'));
    }

    private function searchProduct($string) {
        $products = Product::where('search', true)
                        ->where('name', 'LIKE', '%' . $string . '%')
                        ->OrWhere('barcode', 'LIKE', '%' . $string . '%')
                        ->latest()->take($this->limit)->get();
        return $products;
    }

    private function searchAllProduct($string) {
        $products = Product::where('name', 'LIKE', '%' . $string . '%')
                        ->OrWhere('barcode', 'LIKE', '%' . $string . '%')
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

    public function getProductAutoCompleteAll(Request $request) {
        $string = $request->term ?? '';
        $products = $this->searchAllProduct($string);
        $result = array();
        foreach ($products as $product) {
            array_push($result, ['label' => $product->name . "({$product->barcode})", 'value' => $product->id, 'name' => strtoupper($product->name), 'id' => $product->id, 'barcode' => $product->barcode]);
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

//        dd($request->all());
        return json_encode($product != null ? $product : null);
    }

     public function lastProductAdded() {
        $last = auth()->user()->temp_items()->latest()->first() ?? (new TempItem());
        $product = new Product();
        if ($last->product_id != null) {
            $product = Product::find($last != null ? $last->product_id : 0);
            $store = Store::first();
            $productParent = ProductChild::where('child', $product->id)->first();

            $stock = Stock::where('product_id', ($productParent != null ? $productParent->parent : $product->id))->where('store_id', $store->id)->first();
            $product->description = $stock != null ? $stock->quantity : 0;
        }
        return response()->json($product);
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
        $temps = $user->temp_items()->latest()->get();
        if($request->view){
            return view('layouts.items_added', compact('temps'));
        }
        return json_encode($temps);
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
        $item->barcode = $product->barcode;
        $item->unitprice = $price;
        $item->rate = $product->rate;
        $item->subtotal = $price * $quantity;
        return $item;
    }

    public function addProduct($id) {
      
        $user = auth()->user();
        $product = $this->product->findOrfail($id);
       
        $temp = $user->temp_items->where('product_id', $product->id)->first();
           // dd($id, $product, $temp);
        if ($temp != null) {
            $temp->quantity += 1;
            $temp->update();
        } else {
            $price = $product->price;
            $item = new TempItem();
            $item->quantity = 1;
            $item->product_id = $product->id;
            $item->barcode = $product->barcode;
            $item->name = $product->name;
            $item->unitprice = $price;
            $item->rate = $product->rate;
            $item->subtotal = $price;
            auth()->user()->temp_items()->save($item);
        }
        return redirect()->back()->with(['info' => 'Artigo adicionado!']);
    }

    public function exchangeGet($id) {
        $stores = Store::all();
        $stock = Stock::find($id);
        $product = $stock->product;
        return view('product.exchange', compact('product', 'stock', 'stores'));
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
            return redirect()->route('product.show', $request->product_id)->with(['sucesso' => 'Conversão efectuada com sucesso.']);
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
            return view('product.child_restore', ['productChild' => $pChild->first(), 'data' => $request->all()]);
        }
        try {
            $parent->children()->create($request->all());
            return redirect()->route('product.show', $parent->id)->with(['sucesso' => 'Produto adicionado com sucesso.']);
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
            return redirect()->route('product.show', $child->parent)->with(['sucesso' => "O produto {$product} para retalho foi restaurado."]);
        } catch (\Exceprion $e) {
            return redirect()->back()->with(['falha' => 'Falha na operacao..: ' . $e->getMessage()]);
        }
    }

   public function getStatistic(Request $request) {
        try{
            $data = $request->all();
            $product = $this->product->find($request->id);
            $items = Item::select(DB::raw('DATE(created_at) as created_at, SUM(unitprice) as unitprice, SUM(rate) as rate, SUM(subtotal) as total, SUM(quantity) as qtd, COUNT(*) as vendas'))
                    ->with('product')
                    ->whereDate('created_at', '>=', $request->from)
                    ->whereDate('created_at', '<=', $request->to)
                    ->where('product_id', $product->id)
                    ->whereHasMorph(
                        'item',
                        [Credit::class, Factura::class, Output::class],
                        function (Builder $query){
                            $query->select('id', 'total', 'deleted_at');
                        }
                    )
                    ->groupBy(DB::raw("DATE(created_at)"))
                    ->orderBy('created_at', 'DESC')
                    ->get();

            return view('product.query_statistic', compact('items', 'product', 'data'));
        }catch(\Exception $ex){
            dd("Ocorreu errro ao buscar estatística do produto: {$ex->getMessage}");
        }
    }

    public function getStatisticResume(Request $request) {
        try{
            $data = $request->all();
            $product = $this->product->find($request->id);
            $items = Item::select(DB::raw('item_type, SUM(quantity) as qtd, COUNT(*) as vendas'))
                    ->whereDate('created_at', '>=', $request->from)
                    ->whereDate('created_at', '<=', $request->to)
                    ->where('product_id', $product->id)
                    ->whereHasMorph(
                        'item',
                        [Credit::class, Factura::class, Output::class],
                        function (Builder $query){
                            $query->select('id', 'total', 'deleted_at');
                        }
                    )
                    ->groupBy(DB::raw("item_type"))
                    // ->toSql(); dd($items);
                    ->get();

            return response()->json($items);
        }catch(\Exception $ex){
            dd("Ocorreu errro ao buscar resumo da estatística do produto: {$ex->getMessage}");
        }
    }


    public function getSpecificStatistic(Request $request) {
         try{
            #"DATE(created_at) as created_at, SUM(unitprice) as unitprice, SUM(rate) as rate, SUM(subtotal) as total, SUM(quantity) as qtd, COUNT(*) as vendas, item_type as item_type"
            $items = Item::select(DB::raw('DATE(created_at) as created_at, (unitprice) as unitprice, (rate) as rate, (subtotal) as total, (quantity) as qtd, item_type as item_type'))
                ->with('product')
                ->whereDate('created_at', '=', $request->date)
                ->where('product_id', $request->id)
                ->whereHasMorph(
                    'item',
                    [Credit::class, Factura::class, Output::class],
                    function (Builder $query){
                        $query->select('id', 'total', 'deleted_at');
                    }
                )
                //->groupBy(DB::raw("DATE(created_at), item_type"))
                ->orderBy('created_at', 'DESC')
                // ->toSql(); dd($items);
                ->get();
            
            return response()->json($items);
         }catch(\Exception $ex){
            dd("Ocorreu errro ao buscar estatística descritiva do produto: {$ex->getMessage}");
         }
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

    public function getFlap(Request $request) {
        $product = $this->product->findOrfail($request->id);
        return view("product.flap_table", compact("product"));
    }

    public function editModal(Request $request) {
        $product = $this->product->findOrfail($request->id);
        return view("product.edit_modal", compact("product"));
    }

    public function editPriceModal(Request $request) {
        $product = $this->product->findOrfail($request->id);
        return view("product.prices_modal", compact("product"));
    }

    public function updateModal(Request $request) {
        try {
            $product = $this->product->findOrfail($request->id);
            $product->barcode = $request->barcode;
            $product->othercode = $request->othercode;
            $product->name = $request->name;
            $product->label = $request->label;
            $product->description = $request->description;
            $product->update();
            $sucesso = "O produto {$product->name} para retalho foi actualizado.";
            return view("menu.alert", compact("sucesso"));
        } catch (\Exceprion $e) {
            $falha = "Falha na operacao: {$e->getMessage()}";
            return view("menu.alert", compact("falha"));
        }
    }

    public function updatePriceModal(Request $request) {
        DB::beginTransaction();
        try {
            $product = \App\Models\Product::find($request->id);
            \App\Models\Price::create($request->all());
            $product->price = $request->current;
            $product->buying = $request->buying;
            $product->margem = $request->margen;
            $product->update();
            DB::commit();
            $sucesso = "O produto {$product->name} para retalho foi actualizado.";
            return view("menu.alert", compact("sucesso"));
        } catch (Exception $ex) {
            DB::rollback();
            $falha = "Falha na operacao: {$ex->getMessage()}";
            return view("menu.alert", compact("falha"));
        }
    }

    public function getChildren($id) {
        try {
            $product = $this->product->findOrfail($id);
            $children =  $product->children;
            return view('invoice.product_children', compact('product', 'children'));
        } catch (Exception $ex) {
            $falha = "Falha na operacao: {$ex->getMessage()}";
            return view("menu.alert", compact("falha"));
        }
    }

    public function updateChildren(Request $request) {
        DB::beginTransaction();
        try {
            // dd($request->all());
            foreach($request->product_id as $key => $value){
                $data = [
                    'name' => $request->product_name[$key],
                    'price' => $request->product_price[$key],
                ];

                Product::where('id', $value)->update($data);
            }
            DB::commit();
            return "Produtos Actualizados";
        } catch (Exception $ex) {
            DB::rollback();
            $falha = "Falha na operacao: {$ex->getMessage()}";
            return view("menu.alert", compact("falha"));
        }
    }


    public function formEditable(Request $request) {
        try {
            // dd($request->all());
            $goods = $this->product->whereHas('category', function($query){
                $query->where('name', 'Editavel');
            })->get();
            // dump($goods);
            return view('layouts.product_editable', compact('goods'));
        } catch (Exception $ex) {
            $falha = "Falha na operacao: {$ex->getMessage()}";
            return view("menu.alert", compact("falha"));
        }
    }
    public function postFormEditable(Request $request) {
        try {
            if($request->subtotal > 0){
                $user = auth()->user();
                $temp = $user->temp_items()->create($request->all());
            }
        } catch (Exception $ex) {
            return response()->json(['message' => "Ocorreu um erro: {$ex->getMessage()}"]);
        }
    }
    
}
