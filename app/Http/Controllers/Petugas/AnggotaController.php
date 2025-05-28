<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = Anggota::with('user')->get();
        return view('petugas.anggota.index', compact('anggota'));
    }

    public function create()
    {
        $users = User::doesntHave('anggota')->get(); // hanya user yang belum jadi anggota
        return view('petugas.anggota.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'nis'            => 'required|string|unique:anggota,nis',
            'nama_anggota'   => 'required|string|max:255',
            'no_hp'          => 'required|string|max:20',
            'alamat'         => 'required|string',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
        ]);

        // Buat user baru
        $user = User::create([
            'name'     => $request->nama_anggota,
            'username' => $request->nis,
            'email'    => $request->email,
            'password' => Hash::make('123456789'),
        ]);

        // Buat data anggota dan simpan ke variabel
        $anggota = Anggota::create([
            'id_user'       => $user->id,
            'nis'           => $request->nis,
            'nama_anggota'  => $request->nama_anggota,
            'no_hp'         => $request->no_hp,
            'alamat'        => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            // status_anggota default: Aktif
        ]);

        return redirect()->route('petugas.anggota.show', $anggota->id)
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $anggota = Anggota::with('user')->findOrFail($id);
        return view('petugas.anggota.show', compact('anggota'));
    }

    public function edit(string $id)
    {
        $anggota = Anggota::with('user')->findOrFail($id);
        return view('petugas.anggota.edit', compact('anggota'));
    }

    public function update(Request $request, string $id)
    {
        $anggota = Anggota::findOrFail($id);
        $user = $anggota->user;

        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email,' . $user->id,
            'nis'            => 'required|string|unique:anggota,nis,' . $anggota->id,
            'nama_anggota'   => 'required|string|max:255',
            'no_hp'          => 'required|string|max:20',
            'alamat'         => 'required|string',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'status_anggota' => 'required|in:Aktif,Non-Aktif',
        ]);

        // Update user
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // Update anggota
        $anggota->update([
            'nis'            => $request->nis,
            'nama_anggota'   => $request->nama_anggota,
            'no_hp'          => $request->no_hp,
            'alamat'         => $request->alamat,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'status_anggota' => $request->status_anggota,
        ]);

        return redirect()->route('petugas.anggota.show', $anggota->id)
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();

        return redirect()->route('petugas.anggota.index')
            ->with('success', 'Anggota berhasil dihapus.');
    }
}
