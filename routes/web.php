<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Models\Pengaduan;

Route::get('/', [LoginController::class, 'index'])->name('login.page');
Route::post('/login', [LoginController::class, 'store'])->name('login');

Route::get('/dashboard', function () {
    $pengaduans = Pengaduan::all();
    $total = $pengaduans->count();
    $pending = $pengaduans->where('status', 'Menunggu')->count();
    $review = $pengaduans->where('status', 'Diperbaiki')->count();
    $completed = $pengaduans->where('status', 'Selesai')->count();
    
    return view('dashboard.dashboard', compact('pengaduans', 'total', 'pending', 'review', 'completed'));
})->name('dashboard');

Route::resource('pengaduan', App\Http\Controllers\PengaduanController::class);

Route::get('/tanggapan', function () {
    return view('tanggapan.tanggapan');
})->name('tanggapan');

Route::get('/laporan', function () {
    return view('laporan.laporan');
})->name('laporan');

Route::get('/pengaturan', function () {
    return view('pengaturan.pengaturan');
})->name('pengaturan');
