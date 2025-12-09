<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CashFlow extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $softCascade = ['totals'];
    protected $fillable = [
        'amount',
        'type',
        'reason',
        'cashier_id',
    ];

    public function generateTags(): array {
        return [
            'Cash Flow'
        ];
    }

    public function cashier() {
        return $this->belongsTo(Cashier::class);
    }

}
