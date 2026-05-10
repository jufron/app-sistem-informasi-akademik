<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'frond.home')->name('frond.home');
Route::view('tentang', 'frond.tentang')->name('frond.tentang');
Route::view('guru-dan-staf', 'frond.guruDanPengajar')->name('frond.guru-dan-staf');
Route::view('kontak', 'frond.kontak')->name('frond.kontak');
Route::view('detail-guru-dan-staf', 'frond.detailGuruDanStaf')->name('frond.guru-dan-staf.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
