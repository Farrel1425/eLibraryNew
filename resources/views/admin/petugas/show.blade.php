@extends('layouts.admin')

@section('title', 'Detail Petugas')

@section('content')
<div class="mb-3">
    <h2>Detail Petugas</h2>
</div>

<div class="card">
    <div class="card-body">
        <h5>Data User</h5>
        <p><strong>Nama Lengkap:</strong> {{ $petugas->user->name }}</p>
        <p><strong>Username:</strong> {{ $petugas->user->username }}</p>
        <p><strong>Email:</strong> {{ $petugas->user->email }}</p>

        <hr>

        <h5>Data Petugas</h5>
        <p><strong>Nama Petugas:</strong> {{ $petugas->nama_petugas }}</p>
        <p><strong>No. HP:</strong> {{ $petugas->no_hp }}</p>
        <p><strong>Alamat:</strong> {{ $petugas->alamat }}</p>
        <p><strong>Jenis Kelamin:</strong> {{ $petugas->jenis_kelamin }}</p>
        <p><strong>Status:</strong> {{ $petugas->status }}</p>
    </div>
</div>

<a href="{{ route('admin.petugas.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Petugas</a>
@endsection
