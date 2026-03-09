<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengaduan::query();

        // SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('pelapor', 'like', '%'.$request->search.'%')
                    ->orWhere('nisn', 'like', '%'.$request->search.'%')
                    ->orWhere('kelas', 'like', '%'.$request->search.'%')
                    ->orWhere('sarana', 'like', '%'.$request->search.'%');
            });
        }

        // FILTER TANGGAL
        if ($request->tanggal) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // FILTER BULAN
        if ($request->bulan) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        // FILTER SISWA
        if ($request->siswa) {
            $query->where('pelapor', 'like', '%'.$request->siswa.'%');
        }

        // FILTER KATEGORI SARANA
        if ($request->kategori) {
            $query->where('sarana', $request->kategori);
        }

        $nevas = $query->latest()->get();

        return view('pengaduan.index', compact('nevas'));
    }

    public function create()
    {
        return view('pengaduan.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nisn' => 'required',
            'pelapor' => 'required',
            'kelas' => 'required',
            'sarana' => 'required',
            'lokasi' => 'string|nullable',
            'detail' => 'string|nullable',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // tambahkan tanggal otomatis
        $validatedData['tanggal'] = now();

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('public/fotos');
            $validatedData['foto'] = basename($fotoPath);
        }

        $validatedData['status'] = 'Menunggu';
        Pengaduan::create($validatedData);

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dibuat!');
    }

    public function show($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        return response()->json($pengaduan);
    }

    public function update(Request $request, $id)
    {

        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update([

            'pelapor' => $request->pelapor,
            'kelas' => $request->kelas,
            'sarana' => $request->sarana,
            'lokasi' => $request->lokasi,
            'detail' => $request->detail,
            'status' => $request->status,


        ]);

        return redirect()->back()->with('success','Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->delete();

        return redirect()->back()->with('success','Data berhasil dihapus');
    }

    public function menunggu(Request $request)
    {
        $query = Pengaduan::where('status', 'Menunggu');

        if ($request->tanggal) {
            $query->whereDate('created_at', $request->tanggal);
        }

        if ($request->bulan) {
            $query->whereMonth('created_at', $request->bulan);
        }

        if ($request->siswa) {
            $query->where('pelapor', 'like', '%'.$request->siswa.'%');
        }

        if ($request->kategori) {
            $query->where('sarana', $request->kategori);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('pelapor', 'like', '%'.$request->search.'%')
                    ->orWhere('nisn', 'like', '%'.$request->search.'%')
                    ->orWhere('kelas', 'like', '%'.$request->search.'%');
            });
        }

        $pengaduans = $query->latest()->get();

        return view('menunggu.menunggu', compact('pengaduans'));
    }

    public function diperbaiki(Request $request)
    {
        $query = Pengaduan::where('status', 'Diperbaiki');

        // SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('pelapor', 'like', '%'.$request->search.'%')
                    ->orWhere('nisn', 'like', '%'.$request->search.'%')
                    ->orWhere('kelas', 'like', '%'.$request->search.'%')
                    ->orWhere('sarana', 'like', '%'.$request->search.'%');
            });
        }

        // FILTER TANGGAL
        if ($request->tanggal) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // FILTER BULAN
        if ($request->bulan) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        // FILTER SISWA
        if ($request->siswa) {
            $query->where('pelapor', 'like', '%'.$request->siswa.'%');
        }

        // FILTER KATEGORI
        if ($request->kategori) {
            $query->where('sarana', $request->kategori);
        }

        $pengaduans = $query->latest()->get();

        return view('diperbaiki.diperbaiki', compact('pengaduans'));
    }

    public function selesai(Request $request)
    {
        $query = Pengaduan::where('status', 'Selesai');

        // SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('pelapor', 'like', '%'.$request->search.'%')
                    ->orWhere('nisn', 'like', '%'.$request->search.'%')
                    ->orWhere('kelas', 'like', '%'.$request->search.'%')
                    ->orWhere('sarana', 'like', '%'.$request->search.'%');
            });
        }

        // FILTER TANGGAL
        if ($request->tanggal) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // FILTER BULAN
        if ($request->bulan) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        // FILTER SISWA
        if ($request->siswa) {
            $query->where('pelapor', 'like', '%'.$request->siswa.'%');
        }

        // FILTER KATEGORI
        if ($request->kategori) {
            $query->where('sarana', $request->kategori);
        }

        $pengaduans = $query->latest()->get();

        return view('selesai.selesai', compact('pengaduans'));
    }
}
