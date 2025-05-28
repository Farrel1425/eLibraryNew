<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $peminjamans = Peminjaman::with(['anggota', 'buku', 'petugas', 'denda'])->latest()->get();
        return view('petugas.pengembalian.index', compact('peminjamans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
           
        ]);

        $tanggal_kembali = now();

        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);
       
        $peminjaman->update([
            'tanggal_kembali' => $tanggal_kembali,
            'status' => 'dikembalikan',
        ]);
        // dd($peminjaman);
        // calculate denda if the return date is past the due date
        $denda = 0;
        // dd($denda);
        if ($tanggal_kembali > $peminjaman->tanggal_harus_kembali) {
            // dd($peminjaman->tanggal_harus_kembali);
            $selisih_hari = $tanggal_kembali->diffInDays($peminjaman->tanggal_harus_kembali);
        //    make $selisih hari as integer
            $selisih_hari = (int) $selisih_hari;
            // dd($selisih_hari);
            $denda = $selisih_hari * -2000; // Assuming denda is 1000 per day
        }
       
        $peminjaman->denda()->updateOrCreate(
            ['id_peminjaman' => $peminjaman->id],
            ['jumlah' => $denda],
            ['status_denda' => "Belum Lunas"],
            ['id_petugas' => Auth::user()->petugas->id ?? null]
        );

        return redirect()->route('petugas.pengembalian.index')->with('success', 'Pengembalian berhasil dicatat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
