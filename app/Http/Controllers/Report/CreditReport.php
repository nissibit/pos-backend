<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\Credit;
use App\Models\Company;
use App\Models\Account;

class CreditReport extends Controller {

    protected $transferece;

    function __construct(Credit $credit, Company $company) {
        $this->credit = $credit;
        $this->company = $company;
        $this->middleware(['auth', 'revalidate']);
    }

    public function modelo_a4(Request $request) {
        $height = "100%";
        $credit = $this->credit->find($request->id);
        $company = $this->company->first();
        $pdf = PDF::loadView("report.credit.one", compact('credit', 'company', 'height'));
        return $pdf->download("Credito_{$credit->id}.pdf");
    }

    public function modelo_a5(Request $request) {
        $height = "230px";
        $credit = $this->credit->find($request->id);
        $company = $this->company->first();
        $pdf = PDF::loadView("report.credit.one", compact('credit', 'company', 'height'))->setPaper('a5', 'landscape');
        return $pdf->download("Credito_{$credit->id}.pdf");
    }
 
    public function divida_a4(Request $request) {
        $account = Account::find($request->id);
        $company = $this->company->first();
        $pdf = PDF::loadView("report.credit.divida", compact('account', 'company'));
        return $pdf->download("Divida_{$account->accountable->fullname}.pdf");
    }
   
    public function divida_a5(Request $request) {
        $account = Account::find($request->id);
        $company = $this->company->first();
        $pdf = PDF::loadView("report.credit.divida", compact('account', 'company'))->setPaper('a5', 'landscape');
        return $pdf->download("Divida_{$account->accountable->fullname}.pdf");
    }
 
    public function extrato_a4(Request $request) {
        $account = Account::find($request->id);
        $company = $this->company->first();
        $pdf = PDF::loadView("report.credit.extrato", compact('account', 'company'));
        return $pdf->download("Divida_{$account->accountable->fullname}.pdf");
    }
   
    public function extrato_a5(Request $request) {
        $account = Account::find($request->id);
        $company = $this->company->first();
        $pdf = PDF::loadView("report.credit.extrato", compact('account', 'company'))->setPaper('a5', 'landscape');
        return $pdf->download("Divida_{$account->accountable->fullname}.pdf");
    }

}
