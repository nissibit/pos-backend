<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\Factura;
use App\Models\Company;
use App\Models\Payment;
use App\Models\CreditNote;
use PHPJasper\PHPJasper;
use Storage;
use Carbon\Carbon;

class FacturaReport extends Controller {

    protected $transferece;
    private $factura, $company;

    function __construct(Factura $factura, Company $company) {
        $this->factura = $factura;
        $this->company = $company;
        $this->middleware(['auth', 'revalidate']);
    }

//
    public function factura($id) {
        $payment = Payment::find($id);
        $factura = $payment->payment;
//        dd($factura);
        $company = $this->company->first();
        // $custompaper = array(0, 0, 567.00, 283.80);
        $custompaper = array(0, 0, 842.00 * 2, 283.80);
//        $custompaper = array(0,0,0,283.80);
        $pdf = PDF::loadView("report.factura.one", compact('factura', 'company', 'payment'))->setPaper($custompaper, 'landscape');
        $output = $pdf->output();
//        header('Content-type: application/pdf');
//        readfile("Factura_{$factura->id}.pdf");        
//        return $output;
        return response($output, 200, [
            'Content-Type' => 'application/pdf',
            'Conetent-Disposition' => 'inine',
            'filename' => "VD_{}$payment->nr"
        ]);
    }

    public function pedido($id) {

        $factura = $this->factura->withTrashed()->find($id);
        $company = $this->company->first();
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

    public function creditnote(Request $request) {
        $creditnote = CreditNote::find($request->id);
        $company = $this->company->first();
        $pdf = \App::make('dompdf.wrapper');
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

    protected static function facturaJasper(Request $request) {
        $id =$request->id;
        $payment = Payment::find($id);
        $factura = $payment->payment;
        $company = Company::first();
        $user = auth()->user();
        $json = "factura_{$id}_{$user->id}.json";
        $filename = md5($json);
        $input = base_path() . '/resources/views/report/factura/one.jrxml';
        $output = base_path() . "/public/reports/{$filename}";
        $logo = asset("img/logo.png");
        $storageFolder = "/public/reports/json/{$json}";
        $data_file = base_path() . "/public/storage/reports/json/{$json}";

        $items = $factura->items()->latest()->get();

        $totalQtd = 0;
        $totalPrice = 0;
        $totalSubTotal = 0;
        $totalRate = 0;
        foreach ($items as $item) {
            $totalQtd += $item->quantity;
            $totalPrice += $item->unitprice;
            $totalRate += ($item->subtotal * $item->rate) / 100;
            $totalSubTotal += $item->subtotal;
        }

        Storage::disk('local')->put($storageFolder,
                json_encode([
            "factura" => array(
                "company" => "<b>$company->name</b>",
                "tel" => "Tel: {$company->tel}  / {$company->otherPhone}",
                "email" => "Email: {$company->email}",
                "address" => "Endereço: {$company->address}",
                "nuit" => "NUIT: {$company->nuit}",
                "logo" => $logo,
                "date" => "<b>Data:</b> {$factura->day->format('d-m-Y')}",
                "customerName" => "<b>Cliente</b>: {$factura->customer_name}",
                "customerNUIT" => "<b>NUIT</b>: {$factura->customer_nuit}",
                "customerAddress" => "<b>Morada</b>: {$factura->customer_address}",
                "customerPhone" => "<b>Tel</b>: {$factura->customer_phone}",
                "payment" => "<b>Pagt.</b>: {$payment->nr}",
                "subtotalText" => "<b>Subtotal</b>",
                "subtotal" => $totalSubTotal,
                "discountText" => "<b>Desconto</b>",
                "discount" => $factura->discount,
                "ivaText" => "<b>IVA(16%)</b>",
                "iva" => "Incluído",
                "totalText" => "<b>Total</b>",
                "total" => $factura->total,
                "signatureStamp" => "<b>Assinatura e Carimbo<b/>",
                "responsable" => "(O responsável)",
                "headerNote" => "<b>{$company->description}</b>",
                "printedBy" => "Impresso por: " . auth()->user()->name,
                "printedDate" => Carbon::now()->format('d-m-Y') . ' / ' . \Carbon\Carbon::now()->format('h:i'),
                "greetings" => "Volte sempre.",
                'items' => $items
        )]));
        $options = [
            'format' => ['pdf'],
            'locale' => 'en',
            'db_connection' => [
                'driver' => 'json',
                'data_file' => $data_file,
                'json_query' => 'factura'
            ]
        ];

        $jasper = new PHPJasper;
        $jasper->process(
                $input,
                $output,
                $options
        )->execute();
        $cashier = auth()->user()->cashier->where('startime', '>=', \Carbon\Carbon::today())->where('endtime', null)->first();
        $open = ($cashier != null) ? $cashier->count() : 0;
        return $filename;
    }

}
