<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProduct;
use App\Http\Requests\Product\StoreProductChild;
use App\Http\Requests\Product\UpdateProduct;
use App\Http\Resources\ProductResource;
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
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function auth;
use function redirect;
use function view;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    private $product;
    private $limit = 10;

    function __construct(Product $product)
    {
        $this->product = $product;
        $this->middleware(['auth']);
    }

    public function index()
    {
        return view('product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
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
    private function generateCode($id, $field)
    {
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

    public function updateProducts()
    {
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

    public function store(StoreProduct $request)
    {
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
    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Product  $product
     * @return Response
     */
    public function edit(Product $product)
    {
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
    public function update(UpdateProduct $request, Product $product)
    {
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
    public function destroy(Product $product)
    {
        $delete = $product->delete();
        if ($delete) {
            return redirect()->route('product.index')->with(['info' => 'Produto suprimida com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da categoria.']);
        }
    }

    public function fetch(Request $request)
    {
        $q = $request->q ?? '';

        $products = Product::query()
            ->when($q !== '', function ($query) use ($q) {
                // $query->where('name', 'like', "%{$q}%");
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('barcode', 'like', "%{$q}%")
                        ->orWhere('price', 'like', "%{$q}%");
                });
            })
            ->take($this->limit)
            ->get();

        return ProductResource::collection($products);
    }
}
