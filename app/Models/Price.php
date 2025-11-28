<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Price extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'buying',
        'margen',
        'current',
        'product_id'
    ];

    public function generateTags(): array {
        return [
            'Product'
        ];
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
