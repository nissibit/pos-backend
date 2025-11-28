<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempItem extends Model {

    protected $fillable = [
        'user_id',
        'product_id',
        'name',
        'barcode',
        'quantity',
        'unitprice',
        'rate',
        'subtotal',
    ];
    
    public function user() {
        return $this->belongsTo(App\User::class);
    }

}
