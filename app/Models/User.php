<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements Auditable, CanResetPassword
{

    use Notifiable, SoftDeletes, HasApiTokens;
    use \OwenIt\Auditing\Auditable;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
    use \Illuminate\Auth\Passwords\CanResetPassword;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone_number',
        'password2'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'current_sign_in_at',
        'last_sign_in_at'
    ];

    public function generateTags(): array
    {
        return [
            'User'
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasPermission(Permission $permission)
    {
        return $this->hasAnyRoles($permission->roles);
    }

    /**
     * Verifica se o usuário tem qualquer uma das roles passadas.
     *
     * @param array|string $roles
     * @return bool
     */
    public function hasAnyRoles(array|string $roles): bool
    {
        // 1. Garante que $roles seja um array
        if (is_string($roles)) {
            $roles = [$roles];
        }

        // 2. Verifica se o usuário tem alguma das roles
        // 'whereIn' verifica se o 'name' da role está presente no array $roles.
        // 'exists()' é uma forma eficiente de verificar se há resultados.
        return $this->roles()
            ->whereIn('name', $roles)
            ->exists();
    }

    // public function hasAnyRoles($roles)
    // {
    //     if (is_object($roles) || is_array($roles)) {
    //         return !!$roles->intersect($this->roles)->count();
    //     }
    //     return $this->roles->contains('name', $roles);
    // }

    public function cashier()
    {
        return $this->hasMany(Cashier::class);
    }

    public function fund()
    {
        return $this->hasMany(Fund::class);
    }

    public function temp_items()
    {
        return $this->hasMany(TempItem::class);
    }

    public function temp_entries()
    {
        return $this->hasMany(TempEntry::class);
    }

    public function temp_payment_items()
    {
        return $this->hasMany(TempPaymentItem::class);
    }
}
