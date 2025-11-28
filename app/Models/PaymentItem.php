<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PaymentItem extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'way',
        'reference',
        'amount',
        'exchanged',
        'currency_id',
        'payment_id',
    ];

    public function generateTags(): array {
        return [
            'Payment Item'
        ];
    }

    public function currency() {
        return $this->belongsTo(Currency);
    }

    public function payment() {
        return $this->belongsTo(Payment::class);
    }
    
    public function factura() {
        return $this->hasOneThrough(Factura::class, PaymentItem::class);
    }

}
