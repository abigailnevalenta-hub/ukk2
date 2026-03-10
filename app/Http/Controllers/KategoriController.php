<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = Kategori::latest()->paginate(10);
        return view('kategori.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
                'deskripsi' => 'nullable|string|max:1000',
            ]);

            $kategori = Kategori::create($request->all());

            return redirect()->route('kategori.index')
                ->with('success', 'Kategori berhasil ditambahkan.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('kategori.create')
                ->withErrors($e->errors())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $kategori = Kategori::findOrFail($id);

            $request->validate([
                'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $id,
                'deskripsi' => 'nullable|string|max:1000',
            ]);

            $kategori->update($request->all());

            return redirect()->route('kategori.index')
                ->with('success', 'Kategori berhasil diperbarui.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            $kategori = Kategori::findOrFail($id);
            return redirect()->route('kategori.edit', $id)
                ->withErrors($e->errors())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        
        // Check if kategori has related pengaduans
        if ($kategori->pengaduans()->count() > 0) {
            return redirect()->route('kategori.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki data pengaduan terkait.');
        }

        $kategori->delete();

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
