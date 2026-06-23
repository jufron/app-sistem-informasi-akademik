<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KepalaSekolahPenilaianController;
use App\Http\Controllers\KepalaSekolahLaporanController;

// Grading revision requests
Route::post('revisi-penilaian', [KepalaSekolahPenilaianController::class, 'storeRevisi'])
    ->name('dashboard.kepala-sekolah.revisi.store');

// Academic Reporting Dashboard
Route::controller(KepalaSekolahLaporanController::class)->group(function () {
    Route::get('laporan', 'index')
        ->name('dashboard.kepala-sekolah.laporan.index');

    // Print Reports
    Route::get('laporan/print/siswa', 'printSiswa')
        ->name('dashboard.kepala-sekolah.laporan.print-siswa');

    Route::get('laporan/print/guru', 'printGuru')
        ->name('dashboard.kepala-sekolah.laporan.print-guru');

    Route::get('laporan/print/kelas', 'printKelas')
        ->name('dashboard.kepala-sekolah.laporan.print-kelas');

    Route::get('laporan/print/mapel', 'printMapel')
        ->name('dashboard.kepala-sekolah.laporan.print-mapel');

    Route::get('laporan/print/penilaian', 'printPenilaian')
        ->name('dashboard.kepala-sekolah.laporan.print-penilaian');
});