<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Entry extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'quantity',
        'rate',
        'name',
        'old_price',
        'buying_price',
        'current_price',
        'product_id',
        'store_id',
        'invoice_id',
        'description'
    ];

    public function generateTags(): array {
        return [
            'Entry'
        ];
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function store() {
        return $this->belongsTo(Store::class);
    }
    public function invoice() {
        return $this->belongsTo(Invoice::class);
    }

}
