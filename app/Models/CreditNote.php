<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CreditNote extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'payment_id',
        'total',
        'reason',
        'return_money',
        'description'
    ];
    protected $dates = [
        'day'
    ];

    public function generateTags(): array {
        return [
            'Credit Note',
        ];
    }

    public function payment() {
        return $this->belongsTo(Payment::class);
    }

    public function items() {
        return $this->morphMany(Item::class, 'item');
    }

}
