<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Currency extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

//    protected $softCascade = [];
    protected $fillable = [
        'name',
        'label',
        'sign'
    ];

    public function generateTags(): array {
        return [
            'Currency'
        ];
    }

    public function exchanges() {
        return $this->hasMany(Exchange::class);
    }

    public function payments() {
        return $this->belongsTo(PaymentItem::class);
    }

}
