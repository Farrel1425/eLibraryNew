<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class KunjunganController extends Controller
{
    // Tampilkan form input NIS
    public function create()
    {
        return view('anggota.kunjungan.create');
    }

    // Proses simpan kunjungan
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|numeric',
        ]);

        // Cari anggota berdasarkan NIS
        $anggota = Anggota::where('nis', $request->nis)->first();

        if (!$anggota) {
            return redirect()->back()->with('error', 'NIS tidak ditemukan.');
        }

        // Cek apakah sudah mengisi kunjungan hari ini
        $today = Carbon::today();
        $sudahKunjungan = Kunjungan::where('id_anggota', $anggota->id)
            ->whereDate('waktu_kunjungan', $today)
            ->exists();

        if ($sudahKunjungan) {
            return redirect()->back()->with('warning', 'Anda sudah mengisi kunjungan hari ini.');
        }

        // Simpan kunjungan baru
        Kunjungan::create([
            'id_anggota' => $anggota->id,
            'waktu_kunjungan' => now(),
        ]);

        return redirect()->back()->with('success', 'Kunjungan berhasil dicatat. Selamat datang, ' . $anggota->nama);
    }
}
