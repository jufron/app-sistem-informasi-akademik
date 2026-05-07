<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DesignPaternServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public $singletons = [
        // your service class

        // your repository class

    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
