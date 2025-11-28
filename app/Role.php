<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Notifications\Notifiable;

class Role extends Model implements Auditable
{
    use Notifiable;
    use \OwenIt\Auditing\Auditable;
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

    protected $softCascade = ['user', "permissions"];
    
    protected $fillable = [
        'name',
        'label',
        'description'
    ];
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function permissions() {
        return $this->belongsToMany(Permission::class);
    }
}
