<?php

namespace App\Providers;

use App\Models\Company;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        date_default_timezone_set('Africa/Maputo');

        View::composer('*', function ($view) {

            $imagePath = public_path('/img/logo.png');
            $image = file_exists($imagePath)
                ? base64_encode(file_get_contents($imagePath))
                : null;

            $company = null;

            try {
                if (Schema::hasTable('companies')) {
                    $company = Company::first();
                }
            } catch (\Exception $e) {
                $company = null;
            }

            $view->with('image', $image)
                ->with('company', $company);
        });
    }
}
