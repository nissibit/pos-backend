<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Store extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $softCascade = [
        'products', 'entries', 'transferences', 'incomes'
    ];
    
    protected $fillable = [
        'name',
        'label',
        'description',
    ];

    public function generateTags(): array {
        return [
            'Store'
        ];
    }

    public function products() {
        return $this->belongsToMany(Product::class, 'stocks')->withPivot('quantity')->withTimestamps();
    }

    public function entries() {
        return $this->hasMany(Entry::class);
    }

    public function transferences() {
        return $this->hasMany(Transference::class, 'from');
    }

    public function incomes() {
        return $this->hasMany(Transference::class, 'to');
    }

}
