<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Fund extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $softCascade = ['totals', 'reinforcements', 'moneyflows'];
    protected $fillable = [
        'user_id',
        'startime',
        'endtime',
        'initial',
        'informed',
        'present',
        'missing',
        'description'
    ];
    protected $dates = [
        'startime',
        'endtime'
    ];

    public function generateTags(): array {
        return [
            'Fund'
        ];
    }

    public function user() {
        return $this->belongsTo(\App\User::class);
    }

    public function moneyflows() {
        return $this->hasMany(MoneyFlow::class);
    }
    public function reinforcements() {
        return $this->hasMany(Reinforcement::class);
    }
}
