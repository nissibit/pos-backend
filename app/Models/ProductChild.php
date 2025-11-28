<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProductChild extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $softCascade = [];
    protected $fillable = [
        'parent',
        'child',
        'quantity',
    ];

    public function generateTags(): array {
        return [
            'Product Child'
        ];
    }
    
    public function productByChild() {
        return $this->belongsTo(Product::class, 'child', 'id');
    }
    public function productByParent() {
        return $this->belongsTo(Product::class, 'parent', 'id');
    }
    
}
