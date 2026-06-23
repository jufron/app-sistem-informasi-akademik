<?php

use App\Http\Controllers\GuruRuanganKelasController;
use App\Http\Controllers\GuruPenilaianController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard/guru')->controller(GuruRuanganKelasController::class)->group(function () {
    Route::get('ruangan-kelas', 'index')->name('dashboard.guru.ruangan-kelas.index');
    Route::get('ruangan-kelas/{ruanganKelas}', 'show')->name('dashboard.guru.ruangan-kelas.show');
    Route::get('siswa/{siswa}', 'showSiswa')->name('dashboard.guru.siswa.show');
});

Route::prefix('dashboard/guru')->controller(GuruPenilaianController::class)->group(function () {
    Route::get('penilaian', 'index')->name('dashboard.guru.penilaian.index');
    Route::get('penilaian/{ruanganKelas}', 'showGrades')->name('dashboard.guru.penilaian.show');
    Route::post('penilaian/{ruanganKelas}', 'storeGrades')->name('dashboard.guru.penilaian.store');
});

