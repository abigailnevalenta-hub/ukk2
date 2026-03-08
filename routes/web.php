<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Models\Pengaduan;

Route::get('/', [LoginController::class, 'index'])->name('login.page');
Route::post('/login', [LoginController::class, 'store'])->name('login');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('auth','role:admin');

Route::resource('pengaduan', App\Http\Controllers\PengaduanController::class);

Route::get('/tanggapan', function () {
    return view('tanggapan.tanggapan');
})->name('tanggapan');

Route::get('/menunggu', [App\Http\Controllers\PengaduanController::class, 'menunggu'])->name('menunggu');

Route::get('/diperbaiki', [App\Http\Controllers\PengaduanController::class, 'diperbaiki'])->name('diperbaiki');

Route::get('/selesai', [App\Http\Controllers\PengaduanController::class, 'selesai'])->name('selesai');

// Route::get('/kategori', function () {
//     return view('kategori.kategori');
// })->name('kategori');




