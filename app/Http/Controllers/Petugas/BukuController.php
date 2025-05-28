<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori_buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    // Tampilkan daftar semua buku dengan relasi kategori
    public function index()
    {
        $buku = Buku::with('kategori')->get();
        return view('petugas.buku.index', compact('buku'));
    }

    // Tampilkan form tambah buku
    public function create()
    {
        $kategori = Kategori_buku::all();
        return view('petugas.buku.create', compact('kategori'));
    }

    // Simpan data buku baru
    public function store(Request $request)
    {
        $request->validate([
            'judul'         => 'required|string|max:255',
            'penulis'       => 'required|string|max:255',
            'penerbit'      => 'required|string|max:255',
            'tahun_terbit'  => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'stok'          => 'required|integer|min:0',
            'id_kategori'   => 'required|exists:kategori,id',
            'status_buku'   => 'required|in:Tersedia,Tidak Tersedia',
        ]);

        $buku = Buku::create($request->all());

        // Update jumlah buku pada kategori terkait
        $this->updateJumlahBuku($request->id_kategori);

        return redirect()->route('petugas.buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);
        return view('petugas.buku.show', compact('buku'));
    }

    // Tampilkan form edit buku
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategori = Kategori_buku::all();
        return view('petugas.buku.edit', compact('buku', 'kategori'));
    }

    // Update data buku
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'         => 'required|string|max:255',
            'penulis'       => 'required|string|max:255',
            'penerbit'      => 'required|string|max:255',
            'tahun_terbit'  => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'stok'          => 'required|integer|min:0',
            'id_kategori'   => 'required|exists:kategori,id',
            'status_buku'   => 'required|in:Tersedia,Tidak Tersedia',
        ]);

        $buku = Buku::findOrFail($id);
        $oldKategoriId = $buku->id_kategori;
        $buku->update($request->all());

        // Update jumlah buku pada kategori lama dan kategori baru jika berbeda
        $this->updateJumlahBuku($oldKategoriId);
        if ($oldKategoriId != $request->id_kategori) {
            $this->updateJumlahBuku($request->id_kategori);
        }

       return redirect()->route('petugas.buku.show', $buku->id)
    ->with('success', 'Data buku berhasil diperbarui.');

    }

    // Hapus buku
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $kategoriId = $buku->id_kategori;
        $buku->delete();

        // Update jumlah buku pada kategori terkait
        $this->updateJumlahBuku($kategoriId);

        return redirect()->route('petugas.buku.index')->with('success', 'Buku berhasil dihapus.');
    }

    // Fungsi untuk update jumlah buku berdasarkan kategori
    private function updateJumlahBuku($kategoriId)
    {
        $kategori = Kategori_buku::find($kategoriId);
        if ($kategori) {
            $kategori->jumlah_buku = $kategori->buku()->count();
            $kategori->save();
        }
    }
}
