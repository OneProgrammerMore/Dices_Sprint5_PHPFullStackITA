<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

//Use Passport 
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        //To ignore all routes of passport:
        //Passport::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
