<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\Output;
use App\Models\Company;

class OutputReport extends Controller {

    protected $transferece;

    function __construct(Output $output, Company $company) {
        $this->output = $output;
        $this->company = $company;
        $this->middleware(['auth', 'revalidate']);
    }

    public function output(Request $request) {
        $height = "100%";
        $output = $this->output->find($request->id);
        $company = $this->company->first();
        $pdf = PDF::loadView("report.output.one", compact('output', 'company', 'height'));
        return $pdf->stream("Saida_{$output->id}.pdf", ['Attachment' => true]);
    }

    public function output_2(Request $request) {
        $height = "230px";
        $output = $this->output->find($request->id);
        $company = $this->company->first();
        $pdf = PDF::loadView("report.output.one", compact('output', 'company', 'height'))->setPaper('A5', 'landscape');
        return $pdf->stream("Saida_{$output->id}.pdf", ['Attachment' => true]);
    }

}
