<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Cashier extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $softCascade = ['totals', 'payments', 'cashflows'];
    protected $fillable = [
        'user_id',
        'startime',
        'endtime',
        'initial',
        'informed',
        'present',
        'missing',
        'description'
    ];
    protected $dates = [
        'startime',
        'endtime'
    ];

    public function generateTags(): array {
        return [
            'Cashier'
        ];
    }

    public function user() {
        return $this->belongsTo(\App\User::class);
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }

    public function totals() {
        return $this->hasMany(CashierTotal::class);
    }

    public function cashflows() {
        return $this->hasMany(CashFlow::class);
    }

    public function paymentItems() {
        return $this->hasManyThrough(PaymentItem::class, Payment::class);
    }
}
