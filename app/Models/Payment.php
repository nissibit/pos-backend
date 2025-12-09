<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Payment extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $softCascade = [
        'items'
    ];
    protected $fillable = [
        'topay',
        'payed',
        'change',
        'day',
        'cashier_id'
    ];
    protected $dates = [
        'day'
    ];

    public function generateTags(): array {
        return [
            'Payment'
        ];
    }

    public function payment() {
        return $this->morphTo();
    }

    public function factura() {
        return $this->belongsTo(Factura::class, 'payment_id');
    }

    public function items() {
        return $this->hasMany(PaymentItem::class);
    }

    public function cashier() {
        return $this->belongsTo(Cashier::class);
    }

    public function credit_notes() {
        return $this->hasMany(CreditNote::class);
    }
    
    public function credit_note_items() {
        return $this->hasManyThrough(Item::class, CreditNote::class,'id', 'item_id');
    }
}
