<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // ADMIN lihat semua
        // SISWA hanya lihat pengaduannya sendiri
        if ($user->role === 'admin') {
            $query = Pengaduan::query();
        } else {
            $query = Pengaduan::where('nisn', $user->nisn);
        }

        // SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('pelapor', 'like', '%' . $request->search . '%')
                    ->orWhere('nisn', 'like', '%' . $request->search . '%')
                    ->orWhere('kelas', 'like', '%' . $request->search . '%')
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

        // FILTER SISWA (hanya admin)
        if ($request->siswa && $user->role === 'admin') {
            $query->where('pelapor', 'like', '%' . $request->siswa . '%');
        }

        // FILTER KATEGORI
        if ($request->kategori) {
            $query->where('sarana', $request->kategori);
        }

        $nevas = $query->latest()->paginate(10);

        return view('pengaduan.index', compact('nevas'));
    }

    public function create()
    {
        $kategoris = \App\Models\Kategori::all();
        return view('pengaduan.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nisn' => 'required',
            'pelapor' => 'required',
            'kelas' => 'required',
            'sarana' => 'required|exists:kategoris,nama_kategori',
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

        $validatedData = $request->validate([
            'nisn' => 'required',
            'pelapor' => 'required',
            'kelas' => 'required',
            'sarana' => 'required|exists:kategoris,nama_kategori',
            'lokasi' => 'string|nullable',
            'detail' => 'string|nullable',
            'tanggapan' => 'string|nullable',
        ]);

        $data = $validatedData;

        // hanya admin boleh ubah status
        if ($request->user() && $request->user()->role === 'admin') {
            $data['status'] = $request->status;
        }
        $pengaduan->update($data);

        return back()->with('success', 'Pengaduan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function menunggu(Request $request)
    {
        $query = Pengaduan::where('status', 'Menunggu');

        if ($request->tanggal) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->bulan) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->siswa) {
            $query->where('pelapor', 'like', '%' . $request->siswa . '%');
        }

        if ($request->kategori) {
            $query->where('sarana', $request->kategori);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('pelapor', 'like', '%' . $request->search . '%')
                    ->orWhere('nisn', 'like', '%' . $request->search . '%')
                    ->orWhere('kelas', 'like', '%' . $request->search . '%');
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
                $q->where('pelapor', 'like', '%' . $request->search . '%')
                    ->orWhere('nisn', 'like', '%' . $request->search . '%')
                    ->orWhere('kelas', 'like', '%' . $request->search . '%')
                    ->orWhere('sarana', 'like', '%' . $request->search . '%');
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
            $query->where('pelapor', 'like', '%' . $request->siswa . '%');
        }

        // FILTER KATEGORI
        if ($request->kategori) {
            $query->where('sarana', $request->kategori);
        }

        $pengaduans = $query->latest()->get();

        return view('diperbaiki.diperbaiki', compact('pengaduans'));
    }

    public function ditolak(Request $request)
    {
        $query = Pengaduan::where('status', 'Ditolak');

        // SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('pelapor', 'like', '%' . $request->search . '%')
                    ->orWhere('nisn', 'like', '%' . $request->search . '%')
                    ->orWhere('kelas', 'like', '%' . $request->search . '%')
                    ->orWhere('sarana', 'like', '%' . $request->search . '%');
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
            $query->where('pelapor', 'like', '%' . $request->siswa . '%');
        }

        // FILTER KATEGORI
        if ($request->kategori) {
            $query->where('sarana', $request->kategori);
        }

        $pengaduans = $query->latest()->get();

        return view('ditolak.ditolak', compact('pengaduans'));
    }

    public function selesai(Request $request)
    {
        $query = Pengaduan::where('status', 'Selesai');

        // SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('pelapor', 'like', '%' . $request->search . '%')
                    ->orWhere('nisn', 'like', '%' . $request->search . '%')
                    ->orWhere('kelas', 'like', '%' . $request->search . '%')
                    ->orWhere('sarana', 'like', '%' . $request->search . '%');
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
            $query->where('pelapor', 'like', '%' . $request->siswa . '%');
        }

        // FILTER KATEGORI
        if ($request->kategori) {
            $query->where('sarana', $request->kategori);
        }

        $pengaduans = $query->latest()->get();

        return view('selesai.selesai', compact('pengaduans'));
    }

    public function tanggapan(Request $request, $id)
    {
        try {
            $pengaduan = Pengaduan::findOrFail($id);

            $validatedData = $request->validate([
                'tanggapan' => 'nullable|string'
            ]);

            // Otomatis ubah status menjadi "Diperbaiki" jika ada tanggapan
            if (!empty($validatedData['tanggapan'])) {
                $validatedData['status'] = 'Diperbaiki';
            }

            // Log data untuk debugging
            Log::info('Tanggapan data:', [
                'id' => $id,
                'validated_data' => $validatedData,
                'before_update' => $pengaduan->toArray()
            ]);

            $pengaduan->update($validatedData);

            // Log hasil update
            Log::info('After update:', [
                'pengaduan' => $pengaduan->fresh()->toArray()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tanggapan berhasil disimpan',
                'data' => $pengaduan->fresh()
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving tanggapan:', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan tanggapan: ' . $e->getMessage()
            ], 500);
        }
    }



    public function getUserByNisn(Request $request)
    {
        $nisn = $request->nisn;
        $user = User::where('nisn', $nisn)->first();

        if ($user) {
            return response()->json([
                'success' => true,
                'name' => $user->name
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'User not found'
        ]);
    }

    public function getTanggapanList(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin lihat semua tanggapan
            $tanggapanList = Pengaduan::whereNotNull('tanggapan')
                ->where('tanggapan', '!=', '')
                ->latest('updated_at')
                ->take(10)
                ->get(['id', 'pelapor', 'status', 'tanggapan', 'updated_at']);
        } else {
            // User hanya lihat tanggapan dari pengaduannya sendiri
            $tanggapanList = Pengaduan::where('nisn', $user->nisn)
                ->whereNotNull('tanggapan')
                ->where('tanggapan', '!=', '')
                ->latest('updated_at')
                ->take(10)
                ->get(['id', 'pelapor', 'status', 'tanggapan', 'updated_at']);
        }

        return response()->json([
            'success' => true,
            'data' => $tanggapanList
        ]);
    }

    public function tanggapanIndex(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin lihat semua tanggapan
            $tanggapans = Pengaduan::whereNotNull('tanggapan')
                ->where('tanggapan', '!=', '')
                ->latest('updated_at')
                ->paginate(10);
        } else {
            // User hanya lihat tanggapan dari pengaduannya sendiri
            $tanggapans = Pengaduan::where('nisn', $user->nisn)
                ->whereNotNull('tanggapan')
                ->where('tanggapan', '!=', '')
                ->latest('updated_at')
                ->paginate(10);
        }

        return view('tanggapan.tanggapan', compact('tanggapans'));
    }
}
