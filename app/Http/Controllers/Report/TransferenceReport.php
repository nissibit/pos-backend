<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transference;
use App\Models\Company;
use PDF;
class TransferenceReport extends Controller {

    protected $transferece;

    function __construct(Transference $transference, Company $company) {
        $this->transference = $transference;
        $this->company = $company;
        $this->middleware(['auth', 'revalidate']);
    }

    public function tranference(Request $request) {
        $transference = $this->transference->find($request->id);
        $company = $this->company->first();
        $pdf = PDF::loadView("report.transference.one", compact('transference', 'company'));
        return $pdf->download("Transferemcia_{$transference->id}.pdf");
    }

}
