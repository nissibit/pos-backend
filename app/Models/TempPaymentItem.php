<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempPaymentItem extends Model {

    protected $fillable = [
        'way',
        'reference',
        'amount',
        'exchanged',
        'currency_id',
        'currency',
    ];

    public function temp_payment_items() {
        return $this->belongsTo(App\User::class);
    }
    
    

}
