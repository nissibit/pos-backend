<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Transference extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $softCascade = [
         'items'
    ];
    protected $fillable = [
        'from',
        'to',
        'motive',
        'day',
        'description',
    ];
    protected $dates = ['day'];

    public function generateTags(): array {
        return [
            'Category'
        ];
    }

    public function store_from() {
        return $this->belongsTo(Store::class, 'from');
    }

    public function store_to() {
        return $this->belongsTo(Store::class, 'to');
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function items() {
        return $this->morphMany(Item::class, 'item');
    }

}
