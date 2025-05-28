<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Kategori_buku;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori_buku::all();
        return view('petugas.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('petugas.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
        ]);

        Kategori_buku::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            // jumlah_buku akan default = 1 sesuai migrasi
        ]);

        return redirect()->route('petugas.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori_buku $kategori)
    {
        return view('petugas.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori_buku $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('petugas.kategori.show', $kategori->id)
            ->with('success', 'Kategori berhasil diperbarui.');
    }


    public function show(Kategori_buku $kategori)
    {
        return view('petugas.kategori.show', compact('kategori'));
    }


    public function destroy(Kategori_buku $kategori)
    {
        $kategori->delete();

        return redirect()->route('petugas.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
