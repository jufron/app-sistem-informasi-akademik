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
        \App\Services\Interfaces\GuruServiceInterface::class => \App\Services\GuruService::class,
        \App\Services\Interfaces\JadwalPelajaranServiceInterface::class => \App\Services\JadwalPelajaranService::class,
        \App\Services\Interfaces\RuanganKelasServiceInterface::class => \App\Services\RuanganKelasService::class,

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
