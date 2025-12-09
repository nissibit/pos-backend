<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Company extends Model  implements Auditable
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'name',
        'foto',
        'tel',
        'fax',
        'email',
        'website',
        'otherPhone',
        'init',
        'nuit',
        'address',
        'description'
    ];
    
    public function generateTags() : array
    {
        return [
            'Company'
        ];
    }
    
}
