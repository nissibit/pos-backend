<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Unity extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $softCascade = [
        'products'
    ];
    protected $fillable = [
        'name',
        'label',
        'description',
    ];

    public function generateTags(): array {
        return [
            'Unity'
        ];
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

}
