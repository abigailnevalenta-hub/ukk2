<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengaduan::query();

        // SEARCH
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('pelapor', 'like', '%' . $request->search . '%')
                  ->orWhere('nisn', 'like', '%' . $request->search . '%')
                  ->orWhere('lokasi', 'like', '%' . $request->search . '%')
                  ->orWhere('sarana', 'like', '%' . $request->search . '%');
            });
        }

        $pengaduans = $query->latest()->get();

        // CARD DASHBOARD
        $total = Pengaduan::count();
        $pending = Pengaduan::where('status', 'Menunggu')->count();
        $review = Pengaduan::where('status', 'Diperbaiki')->count();
        $completed = Pengaduan::where('status', 'Selesai')->count();

        return view('dashboard.dashboard', compact('pengaduans', 'total', 'pending', 'review', 'completed'));
    }
}