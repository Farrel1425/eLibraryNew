@extends('layouts.petugas')

@section('title', 'Detail Anggota')

@section('content')
<div class="container mt-4">
    <h3>Detail Anggota</h3>

    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title">{{ $anggota->nama_anggota }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{ $anggota->user->email }}</h6>

            <p class="card-text">
                <strong>NIS:</strong> {{ $anggota->nis }} <br>
                <strong>Nomor HP:</strong> {{ $anggota->no_hp }} <br>
                <strong>Alamat:</strong> {{ $anggota->alamat }} <br>
                <strong>Jenis Kelamin:</strong> {{ $anggota->jenis_kelamin }} <br>
                <strong>Status:</strong> {{ $anggota->status_anggota }}
            </p>

            <a href="{{ route('petugas.anggota.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('petugas.anggota.edit', $anggota->id) }}" class="btn btn-primary">Edit</a>
        </div>
    </div>
</div>
@endsection
