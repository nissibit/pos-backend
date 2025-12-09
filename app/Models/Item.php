<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class Item extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'product_id',
        'name',
        'barcode',
        'quantity',
        'unitprice',
        'rate',
        'subtotal',
        'items_type',
        'items_id',
    ];

    public function generateTags(): array {
        return [
            'Account'
        ];
    }
    
    public function item() {
        return $this->morphTo();
    }
    
    public function product() {
        return $this->belongsTo(Product::class);
    }
}
