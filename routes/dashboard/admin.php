<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MataPelajaranController;

// * mata pelajaran CRUD
Route::resource('mata-pelajaran', MataPelajaranController::class)
        ->parameters(['mata-pelajaran' => 'mataPelajaran'])
        ->names([
            'index'     => 'dashboard.mata-pelajaran.index',
            'create'    => 'dashboard.mata-pelajaran.create',
            'store'     => 'dashboard.mata-pelajaran.store',
            'show'      => 'dashboard.mata-pelajaran.show',
            'update'    => 'dashboard.mata-pelajaran.update',
            'destroy'   => 'dashboard.mata-pelajaran.destroy',
        ]);

// * siswa
// * guru
// * kelas
// * jadwal pelajaran
// *laporan akademik