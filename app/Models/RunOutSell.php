<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RunOutSell extends Model implements Auditable {

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
        'factura_id',
    ];

    public function generateTags(): array {
        return [
            'Run Out Sells'
        ];
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function factura() {
        return $this->belongsTo(Factura::class);
    }

}
