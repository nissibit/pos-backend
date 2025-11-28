<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CashierTotal extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'way',
        'amount',
        'cashier_id',
    ];
    
     public function generateTags(): array {
        return [
            'Cashier Totals'
        ];
    }
    
    public function cashier() {
        return $this->belongsTo(Cashier::class);
    }
}
