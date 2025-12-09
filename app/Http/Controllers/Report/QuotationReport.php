<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\Quotation;
use App\Models\Company;

class QuotationReport extends Controller {

    protected $transferece;

    function __construct(Quotation $quotation, Company $company) {
        $this->quotation = $quotation;
        $this->company = $company;
        $this->middleware(['auth', 'revalidate']);
    }

    public function quotation(Request $request) {
        $quotation = $this->quotation->find($request->id);
        $company = $this->company->first();
        $height = "100%";
        $pdf = PDF::loadView("report.quotation.one", compact('quotation', 'company', 'height'));

        return $pdf->stream("Cotação_{$quotation->id}.pdf", ['Attachment' => true]);
    }

    public function quotation_2(Request $request) {
        $height = "230px";
        $quotation = $this->quotation->find($request->id);
        $company = $this->company->first();
        $pdf = \App::make('dompdf.wrapper');
        /* Careful: use "enable_php" option only with local html & script tags you control.
          used with remote html or scripts is a major security problem (remote php injection) */
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView("report.quotation.one", compact('quotation', 'company','height'))->setPaper('A5', 'landscape');
        return $pdf->stream("Cotação_{$quotation->id}.pdf", ['Attachment' => true]);
    }

}
