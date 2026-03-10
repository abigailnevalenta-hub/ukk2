<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    $data = [
        'pelapor' => $request->pelapor,
        'kelas' => $request->kelas,
        'sarana' => $request->sarana,
        'lokasi' => $request->lokasi,
        'detail' => $request->detail,
    ];

    // hanya admin boleh ubah status
    if ($request->user() && $request->user()->role === 'admin') {
    $data['status'] = $request->status;
    }
    $pengaduan->update($data);

    return back()->with('success','Pengaduan berhasil diperbarui');
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
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->bulan) {
            $query->whereMonth('tanggal', $request->bulan);
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
}
