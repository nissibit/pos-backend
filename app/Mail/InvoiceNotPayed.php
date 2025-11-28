<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use PDF;
use function response;

class InvoiceNotPayed extends Mailable {

    use Queueable,
        SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
//        $account = Account::find(1);
//        $company = Company::first();
//        $pdf = PDF::loadView("report.credit.divida", compact('account', 'company'))->setPaper('a5', 'landscape');

        try {
            $pdf = PDF::loadView("mail.test");
            $data["email"] = 'edsonpessane13@gmail.com';
            $data["client_name"] = "Edson Pessane";
            $data["subject"] = "Dividas";

            \Mail::send('mail.test', $data, function($message)use($data, $pdf) {
                $message->to($data["email"], $data["client_name"])
                        ->subject($data["subject"])
                        ->attachData($pdf->stream(), "dividas.pdf");
            });
        } catch (JWTException $exception) {
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (Mail::failures()) {
            $this->statusdesc = "Error sending mail";
            $this->statuscode = "0";
        } else {

            $this->statusdesc = "Message sent Succesfully";
            $this->statuscode = "1";
        }
        return response()->json(compact('this'));
    }

}
