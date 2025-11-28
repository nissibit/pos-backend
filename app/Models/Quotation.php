<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Quotation extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $softCascade = [
        'items'
    ];
    protected $fillable = [
        'customer_id',
        'customer_name',
        'customer_phone',
        'customer_nuit',
        'customer_address',
        'subtotal',
        'totalrate',
        'discount',
        'total',
        'day',
        'payed',
        'extenso'
    ];
    protected $dates = [
        'day'
    ];

    public function generateTags(): array {
        return [
            'Quotation'
        ];
    }

    public function account() {
        return $this->belongsTo(Account::class);
    }

    public function items() {
        return $this->morphMany(Item::class, 'item');
    }
    
    public function payments() {
        return $this->morphMany(Payment::class, 'payment');
    }
    
    public function sents() {
        return $this->morphMany(Sent::class, 'sent');
    }
}
