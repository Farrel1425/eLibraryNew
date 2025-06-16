<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Denda;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    // Menampilkan semua data pengembalian
    public function index()
    {
        $pengembalians = Pengembalian::with(['peminjaman', 'peminjaman.anggota', 'peminjaman.buku', 'peminjaman.petugas'])->latest()->get();
        return view('petugas.pengembalian.index', compact('pengembalians'));
    }

    // Menampilkan form pengembalian berdasarkan peminjaman tertentu
    public function create(Peminjaman $peminjaman)
    {
        // Cek jika sudah dikembalikan, maka tidak bisa input lagi
        if ($peminjaman->status === 'Dikembalikan') {
            return redirect()->route('petugas.peminjaman.index')->withErrors('Buku sudah dikembalikan sebelumnya.');
        }

        return view('petugas.pengembalian.create', compact('peminjaman'));
    }

    // Simpan data pengembalian
    public function store(Request $request, Peminjaman $peminjaman)
    {
        // Validasi input
        $request->validate([
            'tanggal_kembali' => 'required|date|after_or_equal:' . $peminjaman->tanggal_pinjam,
        ]);

        // Hitung denda jika terlambat
        $tanggalKembali = Carbon::parse($request->tanggal_kembali);
        $tanggalHarusKembali = Carbon::parse($peminjaman->tanggal_harus_kembali);

        $terlambat = $tanggalKembali->greaterThan($tanggalHarusKembali);
        $jumlahHariTerlambat = $terlambat ? $tanggalKembali->diffInDays($tanggalHarusKembali) : 0;
        $jumlahDenda = $jumlahHariTerlambat * 1000; // misalnya 1000 per hari

        // Ambil data petugas yang sedang login
        $petugas = Auth::user()->petugas;

        if (!$petugas) {
            return back()->withErrors('Akun login tidak memiliki data petugas.');
        }

        // Simpan data pengembalian
        $pengembalian = Pengembalian::create([
            'id_peminjaman' => $peminjaman->id,
            'tanggal_kembali' => $request->tanggal_kembali,
            'id_petugas' => $petugas->id,
        ]);

        // Update status peminjaman menjadi "Dikembalikan"
        $peminjaman->update(['status' => 'Dikembalikan']);

        // Kembalikan stok buku
        if ($peminjaman->buku) {
            $peminjaman->buku->increment('stok');
        }

        // Jika ada denda, simpan juga ke tabel denda
        if ($jumlahHariTerlambat > 0) {
            Denda::create([
                'id_pengembalian' => $pengembalian->id,
                'jumlah' => $jumlahDenda,
                'status' => 'Belum Dibayar',
            ]);
        }

        return redirect()->route('petugas.peminjaman.index')->with('success', 'Pengembalian berhasil dicatat.');
    }

    // Menampilkan detail pengembalian tertentu
    public function show(Pengembalian $pengembalian)
    {
        $pengembalian->load(['peminjaman', 'peminjaman.anggota', 'peminjaman.buku', 'denda']);
        return view('petugas.pengembalian.show', compact('pengembalian'));
    }

    // Opsi hapus pengembalian jika dibutuhkan (jarang digunakan, hati-hati)
    public function destroy(Pengembalian $pengembalian)
    {
        // Kembalikan status peminjaman jika pengembalian dihapus
        $peminjaman = $pengembalian->peminjaman;

        // Update status menjadi 'Dipinjam' kembali
        $peminjaman->update(['status' => 'Dipinjam']);

        // Kurangi stok karena dianggap belum dikembalikan
        if ($peminjaman->buku) {
            $peminjaman->buku->decrement('stok');
        }

        // Hapus denda jika ada
        if ($pengembalian->denda) {
            $pengembalian->denda->delete();
        }

        $pengembalian->delete();

        return redirect()->route('petugas.pengembalian.index')->with('success', 'Data pengembalian berhasil dihapus.');
    }
}
