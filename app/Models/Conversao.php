<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Conversao extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'from',
        'to',
        'quantity',
        'flap',
        'total'
    ];

    public function generateTags(): array {
        return [
            'Product'
        ];
    }

    public function stock_from() {
        return $this->belongsTo(Stock::class, 'from');
    }

    public function stock_to() {
        return $this->belongsTo(Stock::class, 'to');
    }

}
