<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Permission\PermissionRegistrar;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
