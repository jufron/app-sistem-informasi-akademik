<?php

declare(strict_types=1);

use App\Http\Controllers\Siswa\NilaiController;
use Illuminate\Support\Facades\Route;

Route::prefix('nilai')->controller(NilaiController::class)->group(function () {
    Route::get('/', 'index')->name('dashboard.siswa.nilai.index');
    Route::get('{ruanganKelas}', 'show')->name('dashboard.siswa.nilai.show');
});