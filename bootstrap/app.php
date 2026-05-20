<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            // auth
            Route::middleware('web')->group(base_path('routes/auth.php'));
            // admin rouet
            Route::middleware('web', 'auth', 'role:admin')->group(base_path('routes/dashboard/admin.php'));
            // guru rouet
            Route::middleware('web', 'auth', 'role:guru')->group(base_path('routes/dashboard/guru.php'));
            // siswa rouet
            Route::middleware('web', 'auth', 'role:siswa')->group(base_path('routes/dashboard/siswa.php'));
            // kepala sekolah rouet
            Route::middleware('web', 'auth', 'role:kepala-sekolah')->group(base_path('routes/dashboard/kepalaSekolah.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
