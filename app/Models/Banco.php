<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Banco extends Model implements Auditable {
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

    protected $softCascade = ["contas"];
    protected $fillable = [
        'name',
        'alias',      
        'description',
    ];

    public function generateTags(): array {
        return [
            'Banco'
        ];
    }
    
    public function contas() {
        return $this->hasMany(ContaPagamento::class);
    }
}
