<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::controller(PagesController::class)->group(function () {
    Route::get('/', 'index')->name('frond.home');
    Route::get('tentang', 'tentang')->name('frond.tentang');
    Route::get('guru-dan-staf', 'guruDanPengajar')->name('frond.guru-dan-staf');
    Route::get('kontak', 'kontak')->name('frond.kontak');
    Route::get('detail-guru-dan-staf', 'detailGuruDanStaf')->name('frond.guru-dan-staf.show');
});

Route::get('dashboard', [DashboardController::class, 'dashboard'])->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
