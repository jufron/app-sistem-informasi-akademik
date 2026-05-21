<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MataPelajaranController;

// * mata pelajaran CRUD
Route::post('mata-pelajaran/bulk-destroy', [MataPelajaranController::class, 'bulkDestroy'])
        ->name('dashboard.mata-pelajaran.bulk-destroy');
Route::resource('mata-pelajaran', MataPelajaranController::class)
        ->parameters(['mata-pelajaran' => 'mataPelajaran'])
        ->names([
            'index'     => 'dashboard.mata-pelajaran.index',
            'create'    => 'dashboard.mata-pelajaran.create',
            'store'     => 'dashboard.mata-pelajaran.store',
            'show'      => 'dashboard.mata-pelajaran.show',
            'edit'      => 'dashboard.mata-pelajaran.edit',
            'update'    => 'dashboard.mata-pelajaran.update',
            'destroy'   => 'dashboard.mata-pelajaran.destroy',
        ]);

// * siswa
Route::post('guru/import', [\App\Http\Controllers\GuruController::class, 'import'])
        ->name('dashboard.guru.import');
Route::get('guru/template', [\App\Http\Controllers\GuruController::class, 'template'])
        ->name('dashboard.guru.template');
Route::post('guru/bulk-destroy', [\App\Http\Controllers\GuruController::class, 'bulkDestroy'])
        ->name('dashboard.guru.bulk-destroy');
Route::resource('guru', \App\Http\Controllers\GuruController::class)
        ->parameters(['guru' => 'guru'])
        ->names([
            'index'     => 'dashboard.guru.index',
            'create'    => 'dashboard.guru.create',
            'store'     => 'dashboard.guru.store',
            'show'      => 'dashboard.guru.show',
            'edit'      => 'dashboard.guru.edit',
            'update'    => 'dashboard.guru.update',
            'destroy'   => 'dashboard.guru.destroy',
        ]);
// * kelas
// * jadwal pelajaran
// *laporan akademik