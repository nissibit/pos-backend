<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Reinforcement extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    
    protected $fillable = [
        'amount',
        'fund_id',
        'description'
    ];
    public function generateTags(): array {
        return [
            'Reinforcement'
        ];
    }

     public function fund() {
        return $this->belongsTo(Fund::class);
    }

}
