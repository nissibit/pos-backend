<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Company;
use App\Models\Credit;
use Illuminate\Support\Facades\Storage;
use PDF;

class SendMailTest extends Mailable {

    use Queueable,
        SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $credit, $company;

    public function __construct(Credit $credit) {
        $this->company = Company::first();
        $this->credit = $credit;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        $credit = $this->credit;
        $company = $this->company;
        $file = $this->view("report.credit.one", compact('credit', 'company'));
        $pdf = PDF::loadView("report.credit.one", compact('credit', 'company'))->setPaper('a5', 'landscape');
        $output = $pdf->output("Credito_{$credit->id}.pdf");
        return $file->attachData($output, 'cotacao.pdf', [
            'nime' => 'application.pdf'            
        ])->subject("Credito_{$credit->id}.pdf");
    }

}
