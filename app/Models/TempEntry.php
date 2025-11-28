<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempEntry extends Model {

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
        'description',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(App\User::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
