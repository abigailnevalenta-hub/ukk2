<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;

class DashboardSiswaController extends Controller
{
    public function index(Request $request)
    {
        // ambil nisn siswa yang login
        $nisn = Auth::user()->nisn;

        $query = Pengaduan::where('nisn', $nisn);

        // SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('pelapor', 'like', '%' . $request->search . '%')
                  ->orWhere('nisn', 'like', '%' . $request->search . '%')
                  ->orWhere('lokasi', 'like', '%' . $request->search . '%')
                  ->orWhere('sarana', 'like', '%' . $request->search . '%');
            });
        }

        // FILTER TANGGAL
        if ($request->tanggal) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // FILTER BULAN
        if ($request->bulan) {
            $query->whereMonth('created_at', $request->bulan);
        }

        // FILTER KATEGORI
        if ($request->kategori) {
            $query->where('sarana', $request->kategori);
        }

        $pengaduans = $query->latest()->get();

        // CARD DASHBOARD (hanya milik siswa ini)
        $total = Pengaduan::where('nisn', $nisn)->count();
        $pending = Pengaduan::where('nisn', $nisn)->where('status', 'Menunggu')->count();
        $review = Pengaduan::where('nisn', $nisn)->where('status', 'Diperbaiki')->count();
        $completed = Pengaduan::where('nisn', $nisn)->where('status', 'Selesai')->count();
        $rejected = Pengaduan::where('nisn', $nisn)->where('status', 'Ditolak')->count();

        return view('dashboardSiswa.index', compact(
            'pengaduans',
            'total',
            'pending',
            'review',
            'completed',
            'rejected'
        ));
    }
}