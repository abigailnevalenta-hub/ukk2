<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;

class PengaduanController extends Controller
{
    public function index()
    {
        $nevas = Pengaduan::all();
        return view('pengaduan.index', compact('nevas'));
    }

    public function create()
    {
        return view('pengaduan.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode' => 'required|unique:pengaduans,kode',
            'pelapor' => 'required',
            'kelas' => 'required',
            'sarana' => 'required',
            'lokasi' => 'string|nullable',
            'detail' => 'string|nullable',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);
            
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
        'detail' => $request->detail

    ]);

    return redirect()
        ->route('pengaduan.index')
        ->with('success','Laporan berhasil diperbarui');

}

    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->delete();
        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dihapus!');
    }
}


