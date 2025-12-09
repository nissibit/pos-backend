<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Article extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'barcode',
        'name',
        'quantity',
        'product_id',
        'loan_id',
    ];

    public function generateTags(): array {
        return [
            'Article'
        ];
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function loan() {
        return $this->belongsTo(Loan::class);
    }

    public function devolutions() {
        return $this->hasMany(DevolutionArticle::class);
    }

}
