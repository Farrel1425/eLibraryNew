<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class KunjunganController extends Controller
{
     public function index()
    {
        $tanggal = date('Y-m-d'); // tanggal hari ini

        $kunjungan = Kunjungan::with('anggota')
            ->whereDate('waktu_kunjungan', $tanggal)
            ->get();

        $total = $kunjungan->count();

        return view('petugas.kunjungan.index', compact('kunjungan', 'tanggal', 'total'));
    }
}
