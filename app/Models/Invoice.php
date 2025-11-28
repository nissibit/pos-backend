<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Invoice extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'number',
        'subtotal',
        'totalrate',
        'discount',
        'total',
        'account_id',
        'day',
    ];
    
    protected $casts = [
        'day' => 'date',
        'subtotal' => 'float',
        'totalrate' => 'float',
        'discount' => 'float',
        'total' => 'float',
    ];
    public function generateTags(): array {
        return [
            'Invoice'
        ];
    }

    public function account() {
        return $this->belongsTo(Account::class);
    }

    public function entries() {
        return $this->hasMany(Entry::class);
    }
    
    
}
