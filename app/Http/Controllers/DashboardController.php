<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $pengaduans = \App\Models\Pengaduan::all();
        $total = $pengaduans->count();
        $pending = $pengaduans->where('status', 'Menunggu')->count();
        $review = $pengaduans->where('status', 'Diperbaiki')->count();
        $completed = $pengaduans->where('status', 'Selesai')->count();  
        return view('dashboard.dashboard', compact('pengaduans', 'total', 'pending', 'review', 'completed'));
    }
}
