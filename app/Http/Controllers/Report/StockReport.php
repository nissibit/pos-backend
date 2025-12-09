<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Stock;
use PDF;
class StockReport extends Controller {

    protected $stock;
    protected $company;

    function __construct(Stock $stock, Company $company) {
        $this->stock = $stock;
        $this->company = $company;
        $this->middleware(['auth', 'revalidate']);
    }

    public function all(Request $request) {
        $stocks = $this->stock->all();
        $company = $this->company->first();
        $pdf = PDF::loadView("report.stock.all", compact('stocks', 'company'));
        return $pdf->download("Stock_actual.pdf");
    }

}
