<?php

namespace App\Http\Controllers\Petugas;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PeminjamanController extends Controller
{
    // Menampilkan daftar semua peminjaman
    public function index()
    {
        $peminjamans = Peminjaman::all();
        return view('petugas.peminjaman.index', compact('peminjamans'));
    }

    // Menampilkan form untuk membuat peminjaman baru
    public function create()
    {
        // Ambil semua anggota dan buku yang stoknya masih tersedia
        $anggotas = Anggota::all();
        $bukus = Buku::where('stok', '>', 0)->get();
        return view('petugas.peminjaman.create', compact('anggotas', 'bukus'));

    }


    // Menyimpan data peminjaman baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'id_anggota' => 'required|exists:anggota,id',
            'id_buku' => 'required|array|min:1',
            'id_buku.*' => 'exists:buku,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_harus_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $petugas = Auth::user()->petugas;
        if (!$petugas) return back()->withErrors('Akun login tidak memiliki data petugas.');

        // Simpan header peminjaman
        $peminjaman = Peminjaman::create([
            'id_anggota' => $request->id_anggota,
            'id_petugas' => $petugas->id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_harus_kembali' => $request->tanggal_harus_kembali,
            'status' => 'Dipinjam',
        ]);

        // Simpan detail peminjaman (bisa banyak buku)
        foreach ($request->id_buku as $id_buku) {
            $buku = Buku::findOrFail($id_buku);
            if ($buku->stok <= 0) return back()->withErrors("Stok buku '{$buku->judul}' habis.");

            // Kurangi stok buku
            $buku->decrement('stok');

            // Simpan detail
            PeminjamanDetail::create([
                'id_peminjaman' => $peminjaman->id,
                'id_buku' => $id_buku,
                'status' => 'Dipinjam',
            ]);
        }
        return redirect()->route('petugas.peminjaman.index')->with('success', 'Peminjaman berhasil disimpan.');
    }

    // Menampilkan detail satu peminjaman
    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['anggota', 'petugas', 'details.buku']);
        return view('petugas.peminjaman.show', compact('peminjaman'));
    }

    // Menampilkan form edit untuk peminjaman
    public function edit(Peminjaman $peminjaman)
    {
        // Ambil semua anggota dan buku
        $anggotas = Anggota::all();
        $bukus = Buku::all();

        return view('petugas.peminjaman.edit', compact('peminjaman', 'anggotas', 'bukus'));
    }

    // Memperbarui data peminjaman yang sudah ada
    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'id_anggota' => 'required|exists:anggota,id',
            'id_buku' => 'required|array|min:1',
            'id_buku.*' => 'exists:buku,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_harus_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        // Kembalikan stok buku-buku lama
        foreach ($peminjaman->details as $detail) {
            $detail->buku->increment('stok');
            $detail->delete();
        }

        // Update header
        $peminjaman->update([
            'id_anggota' => $request->id_anggota,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_harus_kembali' => $request->tanggal_harus_kembali,
        ]);

        // Simpan detail baru
        foreach ($request->id_buku as $id_buku) {
            $buku = Buku::findOrFail($id_buku);
            if ($buku->stok <= 0) return back()->withErrors("Stok buku '{$buku->judul}' habis.");
            $buku->decrement('stok');

            PeminjamanDetail::create([
                'id_peminjaman' => $peminjaman->id,
                'id_buku' => $id_buku,
                'status' => 'Dipinjam',
            ]);
        }

        return redirect()->route('petugas.peminjaman.index')->with('success', 'Data peminjaman berhasil diperbarui.');
    }


    // Menghapus peminjaman
    public function destroy(Peminjaman $peminjaman)
    {
        // Kembalikan stok semua buku yang masih 'Dipinjam'
        foreach ($peminjaman->details as $detail) {
            if ($detail->status === 'Dipinjam') {
                $detail->buku->increment('stok');
            }
            $detail->delete();
        }

        $peminjaman->delete();

        return redirect()->route('petugas.peminjaman.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }


    // Fungsi untuk mengembalikan buku
    public function kembalikan(Peminjaman $peminjaman)
    {
        if ($peminjaman->status === 'Dikembalikan') {
            return back()->withErrors('Buku sudah dikembalikan sebelumnya.');
        }

        // Kembalikan semua buku & update detail
        foreach ($peminjaman->details as $detail) {
            if ($detail->status === 'Dipinjam') {
                $detail->buku->increment('stok');
                $detail->update(['status' => 'Dikembalikan']);
            }
        }

        $peminjaman->update([
            'status' => 'Dikembalikan',
            'tanggal_kembali' => Carbon::now()->toDateString(),
        ]);

        return redirect()->route('petugas.peminjaman.index')->with('success', 'Buku berhasil dikembalikan.');
    }


}
