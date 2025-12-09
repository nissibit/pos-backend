<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Sent extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $softCascade = [
        'Sent'
    ];
    protected $fillable = [
        'message',
        'sent_type',
        'sent_id',
        'amount',
        'description',
    ];

    public function sent() {
        return $this->morphTo();
    }

}
