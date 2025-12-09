<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Credit;
use App\Models\Company;
use Mail;
USE Carbon\Carbon;

class SendDivida extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:devedores';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia emails para os devedores.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $credits = Credit::where('payed', false)->get();
        $company = Company::first();
        foreach ($credits as $credit) {
            $account = $credit->account;
            $to = $account->accountable->email;
            if ($to != null && Carbon::today()->isAfter($credit->day->endOfMonth())) {
//            if ($to != null ) {
                $description = '';
                $type = 'DIVIDAS';
                Mail::to($to)->send(new \App\Mail\SendCredit($company, $account, $description, $type));
//            Store what was sent
                $total = $account->credits()->where('payed', false)->sum('total');
                $data = [
                    'message' => $description,
                    'amount' => $total,
                    'description' => $description,
                ];
                $account->sents()->create($data);
            }
        }
    }

}
