<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use App\Models\Company;
use App\Models\Account;
use PDF;

class SendCredit extends Mailable {

    use Queueable,
        SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $company, $account, $description, $type;

    function __construct(Company $company, Account $account, $description, $type) {
        $this->company = $company;
        $this->account = $account;
        $this->description = $description;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        $name = $this->account->customer_name;
        $company = $this->company;
        $account = $this->account;
        $description = $this->description;
        $date = Carbon::today()->format('d-m-Y');
        if ($this->type == "DIVIDAS") {
            $file = $this->view("mail.divida", compact('account', 'company', 'name', 'description'));
            $pdf = PDF::loadView("report.credit.divida", compact('account', 'company'))->setPaper('a5', 'landscape');
            $output = $pdf->output("Facturas não pagas até {$date}.pdf");
            return $file->attachData($output, "Facturas não pagas até {$date}.pdf", [
                        'nime' => 'application.pdf'
                    ])->subject("Facturas não pagas até {$date}");
        } else {
            $file = $this->view("mail.extrato", compact('account', 'company', 'name', 'description'));
            $pdf = PDF::loadView("report.credit.extrato", compact('account', 'company'))->setPaper('a5', 'landscape');
            $output = $pdf->output("Extracto_{$date}.pdf");
            return $file->attachData($output, "Extrato - {$date}.pdf", [
                        'nime' => 'application.pdf'
                    ])->subject("Extracto - {$date}");
        }
    }

}
