<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\Cashier;
use App\Models\Company;
use Carbon\Carbon;
use DB;

class CashierReport extends Controller {

    protected $transferece;

    function __construct(Cashier $cashier, Company $company) {
        $this->cashier = $cashier;
        $this->company = $company;
        $this->middleware('auth');
    }

    public function cashier(Request $request) {
        $cashier = $this->cashier->find($request->id);
        $company = $this->company->first();
        // $custompaper = array(0, 0, 567.00, 283.80);
        $pdf = PDF::loadView("report.cashier.cashier", compact('cashier', 'company'))->setPaper('A5', 'landscape');
        return $pdf->stream("Caixa_{$cashier->startime->format('d-m-y-h:i:s')}.pdf", ['Attachment' => true]);
    }

    public function cashierSells(Request $request) {
        $cashier = $this->cashier->find($request->id);
        $company = $this->company->first();
        $custompaper = array(0, 0, 567.00, 283.80);
        $pdf = PDF::loadView("report.cashier.sells", compact('cashier', 'company'))->setPaper($custompaper, 'landscape');
        return $pdf->stream("Vendas_{$cashier->id}.pdf", ['Attachment' => true]);
    }

    public function cashierFlow(Request $request) {
        $cashier = $this->cashier->find($request->id);
        $company = $this->company->first();
        $custompaper = array(0, 0, 567.00, 283.80);
        $pdf = PDF::loadView("report.cashier.cashflow", compact('cashier', 'company'))->setPaper($custompaper, 'landscape');
        return $pdf->stream("Entradas_Saidas_{$cashier->id}.pdf", ['Attachment' => true]);
    }

    public function resumoA4($from, $to) {
        $dados = array('from' => $from, 'to' => $to);
        $company = $this->company->first();
        $cashiers = $this->cashier->where('endtime', '<>', null)->whereBetween(DB::raw('DATE(startime)'), array($from, $to))
                ->latest()
                ->get();
        $pdf = PDF::loadView("report.cashier.resumo", compact('dados', 'company', 'cashiers'))->setPaper('A4', 'prostrait');
        return $pdf->stream("Resumo_caixa_" . Carbon::now()->format('d-m-Y') . ".pdf", ['Attachment' => true]);
    }

    public function resumoA5($from, $to) {
        $dados = array('from' => $from, 'to' => $to);
        $company = $this->company->first();
        $cashiers = $this->cashier->where('endtime', '<>', null)->whereBetween(DB::raw('DATE(startime)'), array($from, $to))
                ->latest()
                ->get();

        $pdf = PDF::loadView("report.cashier.resumo", compact('dados', 'company', 'cashiers'))->setPaper('A5', 'landscape');
        return $pdf->stream("Resumo_caixa_" . Carbon::now()->format('d-m-Y') . ".pdf", ['Attachment' => true]);
    }

      public function products($id, $m) {
        $company = $this->company->first();
        $cashier = Cashier::find($id);
        if($m == 'a4'){
            $pdf = PDF::loadView("report.cashier.products", compact('company', 'cashier'));
        }elseif($m == 'a5'){
            $pdf = PDF::loadView("report.cashier.products", compact( 'company', 'cashier'))->setPaper('A5', 'landscape');            
        }
        return $pdf->stream("Produtos_Vendidos" . Carbon::now()->format('d-m-Y') . ".pdf", ['Attachment' => true]);
    }

}
