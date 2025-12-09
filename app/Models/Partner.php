<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Partner extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $softCascade = [
        'account', 'outputs'
    ];
    protected $fillable = [
        'fullname',
        'nuit',
        'type',
        'document_type',
        'document_number',
        'phone_nr',
        'phone_nr_2',
        'email',
        'address',
        'description',
    ];

    public function generateTags(): array {
        return [
            'Partner'
        ];
    }

    public function loans() {
        return $this->hasMany(Loan::class);
    }

}
