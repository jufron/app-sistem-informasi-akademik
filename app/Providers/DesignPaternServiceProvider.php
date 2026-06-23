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
        \App\Services\Interfaces\AppSettingServiceInterface::class => \App\Services\AppSettingService::class,
        \App\Services\Interfaces\NilaiServiceInterface::class => \App\Services\NilaiService::class,

        // your repository class
        \App\Repositories\Interfaces\AgamaRepositoryInterface::class => \App\Repositories\AgamaRepository::class,
        \App\Repositories\Interfaces\AnggotaKelasRepositoryInterface::class => \App\Repositories\AnggotaKelasRepository::class,
        \App\Repositories\Interfaces\AppSettingRepositoryInterface::class => \App\Repositories\AppSettingRepository::class,
        \App\Repositories\Interfaces\GuruRepositoryInterface::class => \App\Repositories\GuruRepository::class,
        \App\Repositories\Interfaces\JadwalPelajaranRepositoryInterface::class => \App\Repositories\JadwalPelajaranRepository::class,
        \App\Repositories\Interfaces\JenisKelaminRepositoryInterface::class => \App\Repositories\JenisKelaminRepository::class,
        \App\Repositories\Interfaces\KelasRepositoryInterface::class => \App\Repositories\KelasRepository::class,
        \App\Repositories\Interfaces\MataPelajaranRepositoryInterface::class => \App\Repositories\MataPelajaranRepository::class,
        \App\Repositories\Interfaces\RombelRepositoryInterface::class => \App\Repositories\RombelRepository::class,
        \App\Repositories\Interfaces\RuanganKelasRepositoryInterface::class => \App\Repositories\RuanganKelasRepository::class,
        \App\Repositories\Interfaces\SemesterRepositoryInterface::class => \App\Repositories\SemesterRepository::class,
        \App\Repositories\Interfaces\SiswaRepositoryInterface::class => \App\Repositories\SiswaRepository::class,
        \App\Repositories\Interfaces\UserRepositoryInterface::class => \App\Repositories\UserRepository::class,
        \App\Repositories\Interfaces\NilaiRepositoryInterface::class => \App\Repositories\NilaiRepository::class,
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
