<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\Loan;
use App\Models\Company;

class LoanReport extends Controller {

    protected $transferece;

    function __construct(Loan $loan, Company $company) {
        $this->loan = $loan;
        $this->company = $company;
        $this->middleware(['auth', 'revalidate']);
    }

    public function loan(Request $request) {
        $height = "100%";
        $loan = $this->loan->find($request->id);        
        $company = $this->company->first();
        $pdf = PDF::loadView("report.loan.one", compact('loan', 'company', 'height'))->setPaper('A5', 'landscape');
        return $pdf->stream("Empréstimo_{$loan->id}.pdf", ['Attachment' => true]);
    }

}
