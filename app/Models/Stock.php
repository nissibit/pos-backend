<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Stock extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'quantity',
        'product_id',
        'store_id',
        'description',
        'operation',
    ];

    public function generateTags(): array {
        return [
            'Stock'
        ];
    }

    public function product() {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function store() {
        return $this->belongsTo(Store::class)->withTrashed();
    }

}
