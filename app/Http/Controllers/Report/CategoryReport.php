<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Company;
use PDF;

class CategoryReport extends Controller {

    protected $category;
    protected $company;

    function __construct(Category $category, Company $company) {
        $this->category = $category;
        $this->company = $company;
        $this->middleware(['auth', 'revalidate']);
    }

    public function all() {
        $categories = $this->category->orderBy('name')->get();
        $company = $this->company->first();
        $pdf = PDF::loadView("report.category.all", compact('categories', 'company'));
        return $pdf->download("Categoria_Produtos.pdf");
    }

    public function products($id) {
//        dd($category);
        $category = $this->category->find($id);
        $company = $this->company->first();
        $pdf = PDF::loadView("report.category.products", compact('category', 'company'));
        return $pdf->download("Produtos_da_Categoria_{$category->name}.pdf");
    }

}
