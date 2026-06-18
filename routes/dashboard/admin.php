<?php

use App\Http\Controllers\GuruController;
use App\Http\Controllers\JadwalPelajaranController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\RuanganKelasController;
use App\Http\Controllers\AppSettingController;
use Illuminate\Support\Facades\Route;

// * mata pelajaran CRUD
Route::post('mata-pelajaran/bulk-destroy', [MataPelajaranController::class, 'bulkDestroy'])
    ->name('dashboard.mata-pelajaran.bulk-destroy');
Route::resource('mata-pelajaran', MataPelajaranController::class)
    ->parameters(['mata-pelajaran' => 'mataPelajaran'])
    ->names([
        'index' => 'dashboard.mata-pelajaran.index',
        'create' => 'dashboard.mata-pelajaran.create',
        'store' => 'dashboard.mata-pelajaran.store',
        'show' => 'dashboard.mata-pelajaran.show',
        'edit' => 'dashboard.mata-pelajaran.edit',
        'update' => 'dashboard.mata-pelajaran.update',
        'destroy' => 'dashboard.mata-pelajaran.destroy',
    ]);

// * siswa
Route::post('guru/import', [GuruController::class, 'import'])
    ->name('dashboard.guru.import');
Route::get('guru/template', [GuruController::class, 'template'])
    ->name('dashboard.guru.template');
Route::post('guru/bulk-destroy', [GuruController::class, 'bulkDestroy'])
    ->name('dashboard.guru.bulk-destroy');
Route::resource('guru', GuruController::class)
    ->parameters(['guru' => 'guru'])
    ->names([
        'index' => 'dashboard.guru.index',
        'create' => 'dashboard.guru.create',
        'store' => 'dashboard.guru.store',
        'show' => 'dashboard.guru.show',
        'edit' => 'dashboard.guru.edit',
        'update' => 'dashboard.guru.update',
        'destroy' => 'dashboard.guru.destroy',
    ]);
// * kelas
Route::get('ruangan-kelas/{ruanganKelas}/pdf', [RuanganKelasController::class, 'pdf'])
    ->name('dashboard.ruangan-kelas.pdf');
Route::post('ruangan-kelas/bulk-destroy', [RuanganKelasController::class, 'bulkDestroy'])
    ->name('dashboard.ruangan-kelas.bulk-destroy');
Route::resource('ruangan-kelas', RuanganKelasController::class)
    ->parameters(['ruangan-kelas' => 'ruanganKelas'])
    ->names([
        'index' => 'dashboard.ruangan-kelas.index',
        'create' => 'dashboard.ruangan-kelas.create',
        'store' => 'dashboard.ruangan-kelas.store',
        'show' => 'dashboard.ruangan-kelas.show',
        'edit' => 'dashboard.ruangan-kelas.edit',
        'update' => 'dashboard.ruangan-kelas.update',
        'destroy' => 'dashboard.ruangan-kelas.destroy',
    ]);

// * jadwal pelajaran
Route::get('jadwal-pelajaran/events', [JadwalPelajaranController::class, 'events'])
    ->name('dashboard.jadwal-pelajaran.events');
Route::post('jadwal-pelajaran/bulk-destroy', [JadwalPelajaranController::class, 'bulkDestroy'])
    ->name('dashboard.jadwal-pelajaran.bulk-destroy');
Route::resource('jadwal-pelajaran', JadwalPelajaranController::class)
    ->parameters(['jadwal-pelajaran' => 'jadwalPelajaran'])
    ->names([
        'index' => 'dashboard.jadwal-pelajaran.index',
        'create' => 'dashboard.jadwal-pelajaran.create',
        'store' => 'dashboard.jadwal-pelajaran.store',
        'show' => 'dashboard.jadwal-pelajaran.show',
        'edit' => 'dashboard.jadwal-pelajaran.edit',
        'update' => 'dashboard.jadwal-pelajaran.update',
        'destroy' => 'dashboard.jadwal-pelajaran.destroy',
    ]);

// *laporan akademik

// * pengaturan aplikasi
Route::get('app-setting', [AppSettingController::class, 'index'])->name('dashboard.app-setting.index');
Route::get('app-setting/edit', [AppSettingController::class, 'edit'])->name('dashboard.app-setting.edit');
Route::put('app-setting', [AppSettingController::class, 'update'])->name('dashboard.app-setting.update');
