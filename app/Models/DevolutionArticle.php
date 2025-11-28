<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DevolutionArticle extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'devolution_id',
        'article_id',
        'quantity'
    ];

    public function generateTags(): array {
        return [
            'Article'
        ];
    }

    public function article() {
        return $this->belongsTo(Article::class);
    }

    public function devolution() {
        return $this->belongsTo(Devolution::class);
    }

}
