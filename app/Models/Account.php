<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Account extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'credit',
        'debit',
        'balance',
        'discount',
        'accountable_type',
        'accountable_id',
        'extra_price',
        'days'
    ];

    public function generateTags(): array {
        return [
            'Account'
        ];
    }

    public function customer() {
        return $this->belongsTo(Customer::class, 'accountable_id');
    }

    public function credits() {
        return $this->hasMany(Credit::class);
    }

    public function accountable() {
        return $this->morphTo();
    }

    public function invoices() {
        return $this->hasMany(Invoice::class);
    }

    public function sents() {
        return $this->morphMany(Sent::class, 'sent');
    }

}
