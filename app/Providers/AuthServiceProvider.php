<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
//use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate;
use App\User;
use App\Permission;
use Illuminate\Support\Facades\Schema;

class AuthServiceProvider extends ServiceProvider {

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
            // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(Gate $gate) {
        // $this->registerPolicies($gate);
        // #Iniciando a verificação de permissões:
        // if (Schema::hasTable('permissions')) {
        //     $permissions = Permission::with('roles')->get();
        //     #dd($permissions);
        //     foreach ($permissions as $permission) {
        //         $permissionName = $permission->name;
        //         $gate->define($permissionName, function(User $user) use ($permission) {
        //             return $user->hasPermission($permission);
        //         });
        //     }

        //     $gate->before(function(User $user, $ability) {
        //         if ($user->hasAnyRoles("Administrador")) {
        //             return true;
        //         }
        //     });
        // }
    }

}
