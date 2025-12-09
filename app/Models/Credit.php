<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Credit extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $softCascade = [
        'items', 'payments'
    ];
    protected $fillable = [
        'subtotal',
        'totalrate',
        'discount',
        'total',
        'account_id',
        'day',
        'extenso',
        'nr_requisicao',
        'nr_factura',
        'payed'
    ];
    protected $dates = [
        'day'
    ];

    public function generateTags(): array {
        return [
            'Credit'
        ];
    }

    public function account() {
        return $this->belongsTo(Account::class);
    }

//
//    public function functionName() {
//        return $this->morphedByMany($related, $name)
//    }

    public function items() {
        return $this->morphMany(Item::class, 'item');
    }

    public function payments() {
        return $this->morphMany(Payment::class, 'payment');
    }

    public function customer() {
       return $this->morph(Customer::class, Account::class, 'id', 'customer_id')->where('accountable_type', array_search(static::class, \Illuminate\Database\Eloquent\Relations\Relation::morphMap()) ?: static::class);
    }

}
