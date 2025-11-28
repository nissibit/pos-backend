<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemStock extends Model {

    protected $fillable = [
        'quantity',
        'product_id',
        'stock_taking_id'
    ];

    public function stock_taking() {
        return $this->belongsTo(StockTaking::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

}
