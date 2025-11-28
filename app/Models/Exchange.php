<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Exchange extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'currency_id',
        'amount',
        'day',
    ];
    protected $dates = ['day'];

    public function generateTags(): array {
        return [
            'Exchange'
        ];
    }

    public function currency() {
        return $this->belongsTo(Currency::class);
    }

}
