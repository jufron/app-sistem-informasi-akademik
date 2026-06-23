<?php

use App\Http\Controllers\GuruRuanganKelasController;
use App\Http\Controllers\GuruPenilaianController;
use App\Http\Controllers\GuruAbsensiController;
use Illuminate\Support\Facades\Route;

// ? ruangan kelas
Route::prefix('dashboard/guru')->controller(GuruRuanganKelasController::class)->group(function () {
    Route::get('ruangan-kelas', 'index')->name('dashboard.guru.ruangan-kelas.index');
    Route::get('ruangan-kelas/{ruanganKelas}', 'show')->name('dashboard.guru.ruangan-kelas.show');
    Route::get('siswa/{siswa}', 'showSiswa')->name('dashboard.guru.siswa.show');
});

// ? penilaian guru
Route::prefix('dashboard/guru')->controller(GuruPenilaianController::class)->group(function () {
    Route::get('penilaian', 'index')->name('dashboard.guru.penilaian.index');
    Route::get('penilaian/{ruanganKelas}', 'showGrades')->name('dashboard.guru.penilaian.show');
    Route::post('penilaian/{ruanganKelas}', 'storeGrades')->name('dashboard.guru.penilaian.store');
    Route::post('penilaian/revisi/{revisi}/resolve', 'resolveRevisi')->name('dashboard.guru.penilaian.revisi.resolve');
});

// ? absensi guru
Route::prefix('dashboard/guru')->controller(GuruAbsensiController::class)->group(function () {
    Route::get('absensi', 'index')->name('dashboard.guru.absensi.index');
    Route::get('absensi/{ruanganKelas}', 'showAbsensi')->name('dashboard.guru.absensi.show');
    Route::post('absensi/{ruanganKelas}', 'storeAbsensi')->name('dashboard.guru.absensi.store');
});

