<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Denda;
use App\Models\Petugas;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DendaController extends Controller
{
   public function index()
    {
        $denda = Denda::with(['peminjaman', 'petugas'])->latest()->get();
        return view('denda.index', compact('denda'));
    }

    public function create()
    {
        $peminjaman = Peminjaman::with('anggota')->doesntHave('denda')->get(); // hanya yang belum punya denda
        $petugas = Petugas::all();
        return view('denda.create', compact('peminjaman', 'petugas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_peminjaman' => 'required|exists:peminjaman,id',
            'jumlah' => 'required|numeric|min:0',
            'tanggal_pembayaran' => 'nullable|date',
            'status_denda' => 'required|in:Lunas,Belum Lunas',
            'id_petugas' => 'nullable|exists:petugas,id'
        ]);

        Denda::create($validated);
        return redirect()->route('denda.index')->with('success', 'Denda berhasil ditambahkan.');
    }

    public function edit(Denda $denda)
    {
        $petugas = Petugas::all();
        return view('denda.edit', compact('denda', 'petugas'));
    }

    public function update(Request $request, Denda $denda)
    {
        $validated = $request->validate([
            'jumlah' => 'required|numeric|min:0',
            'tanggal_pembayaran' => 'nullable|date',
            'status_denda' => 'required|in:Lunas,Belum Lunas',
            'id_petugas' => 'nullable|exists:petugas,id'
        ]);

        $denda->update($validated);
        return redirect()->route('denda.index')->with('success', 'Denda berhasil diupdate.');
    }

    public function destroy(Denda $denda)
    {
        $denda->delete();
        return back()->with('success', 'Denda berhasil dihapus.');
    }
}
