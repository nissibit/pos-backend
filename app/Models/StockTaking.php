<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class StockTaking extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $softCascade = [
        'products'
    ];
    protected $fillable = [
        'startime',
        'endtime',
        'store_id',
        'description'
    ];
    protected $dates = [
        'startime',
        'endtime'
    ];

    public function products() {
        return $this->hasMany(ItemStock::class);
    }

    public function store() {
        return $this->belongsTo(Store::class);
    }

}
