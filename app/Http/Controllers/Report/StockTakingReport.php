<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\StockTaking;
use App\Models\Company;

class StockTakingReport extends Controller {

    private $stocktaking;
    private $company;

    function __construct(StockTaking $stocktaking, Company $company) {
        $this->stocktaking = $stocktaking;
        $this->company = $company;
        $this->middleware(['auth', 'revalidate']);
    }

    public function modelo_a4(Request $request) {
        $stocktaking = $this->stocktaking->find($request->id);
        $products = $stocktaking->products;
        $company = $this->company->first();
        $pdf = PDF::loadView("report.stocktaking.one", compact('stocktaking', 'company', 'products'))->setPaper('A4', 'prostrait');
        return $pdf->stream("Inventário_{$stocktaking->id}.pdf", ['Attachment' => true]);
    }

    public function modelo_a5(Request $request) {
        $stocktaking = $this->stocktaking->find($request->id);
        $products = $stocktaking->products;
        $company = $this->company->first();
        $pdf = PDF::loadView("report.stocktaking.one", compact('stocktaking', 'company', 'products'))->setPaper('A5', 'landscape');
        ;
        return $pdf->stream("Inventário_{$stocktaking->id}.pdf", ['Attachment' => true]);
    }

}
