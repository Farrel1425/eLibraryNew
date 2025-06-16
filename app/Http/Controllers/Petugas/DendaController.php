<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Denda;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DendaController extends Controller
{
    public function index()
    {
        $dendas = Denda::with(['peminjaman.anggota', 'peminjaman.buku'])
            ->latest()
            ->get();

        return view('petugas.denda.index', compact('dendas'));
    }

    public function show($id)
    {
        $denda = Denda::with(['peminjaman.anggota', 'peminjaman.buku'])->findOrFail($id);
        return view('petugas.denda.show', compact('denda'));
    }

    public function update(Request $request, $id)
    {
        $denda = Denda::findOrFail($id);

        if ($denda->status_denda === 'Lunas') {
            return redirect()->back()->with('info', 'Denda sudah lunas.');
        }

        $denda->update([
            'status_denda' => 'Lunas',
        ]);

        return redirect()->route('petugas.denda.index')->with('success', 'Denda berhasil dilunasi.');
    }
}
