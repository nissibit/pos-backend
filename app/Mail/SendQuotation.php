<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Company;
use App\Models\Quotation;
use PDF;

class SendQuotation extends Mailable {

    use Queueable,
        SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $company, $quotation, $description;

    function __construct(Company $company, Quotation $quotation, $description) {
        $this->company = $company;
        $this->quotation = $quotation;
        $this->description = $description;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        $name = $this->quotation->customer_name;
        $company = $this->company;
        $quotation = $this->quotation;
        $description = $this->description;
        $height = "230px";
        $file = $this->view("mail.quotation", compact('quotation', 'company', 'name', 'description'));
        $pdf = PDF::loadView("report.quotation.one", compact('quotation', 'company','height'))->setPaper('a5', 'landscape');
        $output = $pdf->output("Cotação {$quotation->id}.pdf");
        return $file->attachData($output, "Cotação_{$quotation->id}.pdf", [
                    'nime' => 'application.pdf'
                ])->subject("Cotação Nr. {$quotation->id}");
    }

}
