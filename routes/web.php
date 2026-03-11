<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardSiswaController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('login.page');
Route::post('/login', [LoginController::class, 'store'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('auth', 'role:admin');

Route::resource('pengaduan', App\Http\Controllers\PengaduanController::class);
Route::get('/api/user-by-nisn', [App\Http\Controllers\PengaduanController::class, 'getUserByNisn']);
Route::get('/api/tanggapan-list', [App\Http\Controllers\PengaduanController::class, 'getTanggapanList'])->middleware('auth');
Route::put('/pengaduan/{id}/tanggapan', [App\Http\Controllers\PengaduanController::class, 'tanggapan'])->name('pengaduan.tanggapan');
Route::post('/pengaduan/{id}/tanggapan', [App\Http\Controllers\PengaduanController::class, 'tanggapan']);

Route::get('/tanggapan', [App\Http\Controllers\PengaduanController::class, 'tanggapanIndex'])->name('tanggapan')->middleware('auth');

Route::get('/pengaduan-saya', [App\Http\Controllers\PengaduanController::class, 'pengaduanSaya'])->name('pengaduan.saya')->middleware('auth', 'role:user');

Route::get('/menunggu', [App\Http\Controllers\PengaduanController::class, 'menunggu'])->name('menunggu');

Route::get('/diperbaiki', [App\Http\Controllers\PengaduanController::class, 'diperbaiki'])->name('diperbaiki');

Route::get('/selesai', [App\Http\Controllers\PengaduanController::class, 'selesai'])->name('selesai');

Route::get('/dashboard-siswa', [App\Http\Controllers\DashboardSiswaController::class, 'index'])->name('dashboardSiswa')->middleware('auth', 'role:user');

Route::resource('kategori', KategoriController::class)->middleware('auth', 'role:admin');

Route::resource('user', App\Http\Controllers\UserController::class)->middleware('auth', 'role:admin');
