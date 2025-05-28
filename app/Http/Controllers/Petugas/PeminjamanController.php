<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Petugas;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
   public function index()
    {
        $peminjamans = Peminjaman::with(['anggota', 'buku', 'petugas', 'denda'])->latest()->get();
        return view('petugas.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $anggotas = Anggota::all();
        $bukus = Buku::all();
        $petugas = Petugas::all();
        return view('petugas.peminjaman.create', compact('anggotas', 'bukus', 'petugas'));
    }

   public function store(Request $request)
    {
        // 1. Validasi hanya input dari form
        $validated = $request->validate([
            'id_anggota' => 'required|exists:anggota,id',
            'id_buku' => 'required|exists:buku,id',
            'tanggal_pinjam' => 'required|date',
        ]);

        // 2. Tambahkan nilai tambahan yang tidak dari form
        $validated['id_petugas'] = Auth::user()->petugas->id ?? null;
        $validated['tanggal_harus_kembali'] = Carbon::parse($validated['tanggal_pinjam'])->addDays(7);
        $validated['status'] = 'Dipinjam'; // Default langsung

        // 3. Simpan data peminjaman
        Peminjaman::create($validated);

        return redirect()->route('petugas.peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    public function edit(Peminjaman $peminjaman)
    {
        $anggota = Anggota::all();
        $buku = Buku::all();
        $petugas = Petugas::all();
        return view('peminjaman.edit', compact('peminjaman', 'anggota', 'buku', 'petugas'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'id_anggota' => 'required',
            'id_buku' => 'required',
            'id_petugas' => 'required',
            'tanggal_pinjam' => 'required|date',
            'tanggal_harus_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'tanggal_kembali' => 'nullable|date',
            'status' => 'required|in:Dipinjam,Dikembalikan'
        ]);

        $peminjaman->update($validated);
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diupdate.');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();
        return back()->with('success', 'Peminjaman berhasil dihapus.');
    }
}
