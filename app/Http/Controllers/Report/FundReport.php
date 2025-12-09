<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\Fund;
use App\Models\Company;
use Carbon\Carbon;
use DB;

class FundReport extends Controller {

    protected $transferece;

    function __construct(Fund $fund, Company $company) {
        $this->fund = $fund;
        $this->company = $company;
        $this->middleware('auth');
    }

    public function fund(Request $request) {
        $fund = $this->fund->find($request->id);
        $company = $this->company->first();
        // $custompaper = array(0, 0, 567.00, 283.80);
        $pdf = PDF::loadView("report.fund.fund", compact('fund', 'company'))->setPaper('A5', 'landscape');
        return $pdf->stream("Caixa_{$fund->startime->format('d-m-y-h:i:s')}.pdf", ['Attachment' => true]);
    }
    public function moneyflow(Request $request) {
        $fund = $this->fund->find($request->id);
        $company = $this->company->first();
        $custompaper = array(0, 0, 567.00, 283.80);
        $pdf = PDF::loadView("report.fund..moneyflow", compact('fund', 'company'))->setPaper($custompaper, 'landscape');
        return $pdf->stream("Caixa_{$fund->startime->format('d-m-y-h:i:s')}.pdf", ['Attachment' => true]);
    }

    public function resumo($m, $from, $to) {
        $dados = array('from' => $from, 'to' => $to);
        $company = $this->company->first();
        $funds = $this->fund->where('endtime', '<>', null)->whereBetween(DB::raw('DATE(startime)'), array($from, $to))
                ->latest()
                ->get();
        if ($m == 'a4') {
            $pdf = PDF::loadView("report.fund.resumo", compact('dados', 'company', 'funds'));
        } else {
            $pdf = PDF::loadView("report.fund.resumo", compact('dados', 'company', 'funds'))->setPaper('A5', 'landscape');
        }
        return $pdf->stream("Resumo_caixa_" . Carbon::now()->format('d-m-Y') . ".pdf", ['Attachment' => true]);
    }

}
