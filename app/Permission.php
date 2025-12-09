<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;

class Permission extends Model implements Auditable
{
    use Notifiable, SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    
    protected $fillable = [
        'name',
        'label',
        'description'
    ];
  
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    
    public function roles() {
        return $this->belongsToMany(\App\Role::class);
    }
    
    
    public function generateTags() : array
    {
        return [
            'Permission'
        ];
    }
}
