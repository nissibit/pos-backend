<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
    use \OwenIt\Auditing\Auditable;

//    protected $softCascade = [
//        'items', 'entries', 'stock', 'children'
//    ];
    protected $fillable = [
        'barcode',
        'othercode',
        'name',
        'label',
        'category_id',
        'unity_id',
        'rate',
        'price',
        'run_out',
        'flap',
        'flap_12',
        'flap_14',
        'flap_18',
        'search',
        'description',
        'buying',
        'margem',
    ];

    public function generateTags(): array {
        return [
            'Product'
        ];
    }

    public function unity() {
        return $this->belongsTo(Unity::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function items() {
        return $this->hasMany(Item::class);
    }

    public function prices() {
        return $this->hasMany(Price::class);
    }

    public function entries() {
        return $this->hasMany(Entry::class);
    }

    public function store() {
        return $this->belongsToMany(Store::class, 'stocks')->withPivot('quantity')->withTimestamps();
    }

    public function stocks() {
        return $this->hasMany(Stock::class);
//        return $this->belongsToMany(Stock::class);
    }

    public function stock() {
        return $this->hasMany(Stock::class);
    }

    public function children() {
        return $this->hasMany(ProductChild::class, 'parent');
    }

    public function parents() {
        return $this->hasMany(ProductChild::class, 'child');
    }

}
