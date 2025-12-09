<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Devolution extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $softCascade = [
        'articles'
    ];
    protected $fillable = [
        'description',
        'loan_id',
    ];
    protected $dates = ['return_date'];

    public function generateTags(): array {
        return [
            'Devolution'
        ];
    }

    public function loan() {
        return $this->belongsTo(Loan::class);
    }

    public function articles() {
        return $this->hasManyThrough(Article::class, DevolutionArticle::class);
    }

    public function items() {
        return $this->hasMany(DevolutionArticle::class);
    }

}
