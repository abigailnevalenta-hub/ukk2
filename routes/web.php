<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardSiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('login.page');
Route::post('/login', [LoginController::class, 'store'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('auth', 'role:admin');

Route::resource('pengaduan', App\Http\Controllers\PengaduanController::class);

Route::get('/tanggapan', function () {
    return view('tanggapan.tanggapan');
})->name('tanggapan');

Route::get('/menunggu', [App\Http\Controllers\PengaduanController::class, 'menunggu'])->name('menunggu');

Route::get('/diperbaiki', [App\Http\Controllers\PengaduanController::class, 'diperbaiki'])->name('diperbaiki');

Route::get('/selesai', [App\Http\Controllers\PengaduanController::class, 'selesai'])->name('selesai');

Route::get('/dashboard-siswa', [App\Http\Controllers\DashboardSiswaController::class, 'index'])->name('dashboardSiswa')->middleware('auth', 'role:user');

Route::get('kategori', function () {
  return view('kategori.kategori');
})->name('kategori');
