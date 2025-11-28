<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Company;
use PDF;
class ProductReport extends Controller
{   
    protected $product;
    protected $company;

    function __construct(Product $product, Company $company) {
        $this->product = $product;
        $this->company = $company;
        $this->middleware(['auth', 'revalidate']);
    }

    public function all() {
        $products = Product::with('category')->get();
        $company = $this->company->first();
        $pdf = PDF::loadView("report.product.all", compact('products', 'company'));
        return $pdf->stream("Lista_Produtos.pdf");
    }
   
  
}
