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
            $query->where(function ($q) use ($request) {
                $q->where('pelapor', 'like', '%' . $request->search . '%')
                  ->orWhere('nisn', 'like', '%' . $request->search . '%')
                  ->orWhere('kelas', 'like', '%' . $request->search . '%')
                  ->orWhere('sarana', 'like', '%' . $request->search . '%');
            });
        }

        // FILTER TANGGAL RANGE
        if ($request->tanggal_mulai && $request->tanggal_akhir) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir]);
        } elseif ($request->tanggal_mulai) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        } elseif ($request->tanggal_akhir) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        // FILTER BULAN
        if ($request->bulan) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        // FILTER SISWA
        if ($request->siswa) {
            $query->where('pelapor', 'like', '%' . $request->siswa . '%');
        }

        // FILTER KATEGORI
        if ($request->kategori) {
            $query->where('sarana', $request->kategori);
        }

        $pengaduans = $query->latest()->get();

        // CARD DASHBOARD
        $total = Pengaduan::count();
        $pending = Pengaduan::where('status', 'Menunggu')->count();
        $review = Pengaduan::where('status', 'Diperbaiki')->count();
        $completed = Pengaduan::where('status', 'Selesai')->count();
        $rejected = Pengaduan::where('status', 'Ditolak')->count();

        return view('dashboard.dashboard', compact(
            'pengaduans',
            'total',
            'pending',
            'review',
            'completed',
            'rejected'
        ));
    }
}