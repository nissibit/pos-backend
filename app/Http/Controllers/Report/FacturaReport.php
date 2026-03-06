<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\Factura;
use App\Models\Payment;
use App\Models\CreditNote;
use Illuminate\Support\Facades\App;

class FacturaReport extends Controller
{

    protected $transferece;
    private $factura;

    function __construct(Factura $factura)
    {
        $this->factura = $factura;
        $this->middleware(['auth', 'revalidate']);
    }

    //
    public function factura($id)
    {
        $payment = Payment::find($id);
        $factura = $payment->payment;
        $custompaper = array(0, 0, 842.00 * 2, 283.80);
        $pdf = PDF::loadView("report.factura.one", compact('factura', 'payment'))->setPaper($custompaper, 'landscape');
        $output = $pdf->output();
        return response($output, 200, [
            'Content-Type' => 'application/pdf',
            'Conetent-Disposition' => 'inline',
            'filename' => "VD_{$payment->nr}"
        ]);
    }

    public function pedido($id)
    {

        $factura = $this->factura->withTrashed()->find($id);
        $custompaper = array(0, 0, 567.00, 283.80);
        //        $custompaper = array(0,0,0,283.80);
        $pdf = PDF::loadView("report.requisicao.one", compact('factura', 'company'))->setPaper($custompaper, 'landscape');
        $output = $pdf->output();
        //        header('Content-type: application/pdf');
        //        readfile("Factura_{$factura->id}.pdf");        
        //        return $output;
        return response($output, 200, [
            'Content-Type' => 'application/pdf',
            'Conetent-Disposition' => 'inine',
            'filename' => "VD_{}$factura->id"
        ]);
    }

    public function creditnote(Request $request)
    {
        $creditnote = CreditNote::find($request->id);
        $pdf = App::make('dompdf.wrapper');
        /* Careful: use "enable_php" option only with local html & script tags you control.
          used with remote html or scripts is a major security problem (remote php injection) */
        $pdf->getDomPDF()->set_option("enable_php", true);
        if ($request->m == "a4") {
            $pdf->loadView("report.factura.creditnote", compact('creditnote', 'company'));
        } else {
            $pdf->loadView("report.factura.creditnote", compact('creditnote', 'company'))->setPaper('A5', 'landscape');
        }
        return $pdf->stream("Nota_Cred_{$creditnote->id}.pdf", ['Attachment' => true]);
    }


}
