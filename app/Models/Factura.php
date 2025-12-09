<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Factura extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $softCascade = [
        'items', 'payments'
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
        "destroy_reason", "destroy_username", "destroy_date"
    ];
    protected $dates = [
        'day',
        "destroy_date"
    ];

    protected $casts = [
        'day' =>'date',
        'destroy_date' => 'date',
    ];

    public function generateTags(): array {
        return [
            'Factura'
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

    /**
     * Get the products that was selled without corrspondig stock
     */
    
    public function runOutProducts($param) {
        return $this->hasMany(RunOutSell::class);
    }
}
