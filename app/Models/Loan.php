<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Loan extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $softCascade = [
        'devolutions', 'articles'
    ];
    protected $fillable = [
        'returned_date',
        'description',
        'partner_id',
        'status',
    ];
    protected $dates = ['returned_date'];

    public function generateTags(): array {
        return [
            'Loan'
        ];
    }

    public function articles() {
        return $this->hasMany(Article::class);
    }

    public function partner() {
        return $this->belongsTo(Partner::class);
    }

    public function devolutions() {
        return $this->hasMany(Devolution::class);
    }

    /**
     * Items returned
     * 
     */
    public function items()
    {
        return $this->hasManyThrough(DevolutionArticle::class, Devolution::class);
    }

}
