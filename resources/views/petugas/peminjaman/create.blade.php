@extends('layouts.petugas')

@section('title', 'Tambah Peminjaman')

@section('content')
<div class="container mt-4">
    <h3>Tambah Peminjaman Baru</h3>

    <a href="{{ route('petugas.peminjaman.index') }}" class="btn btn-secondary mb-3">← Kembali ke Daftar</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('petugas.peminjaman.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="id_anggota" class="form-label">Anggota</label>
            <select name="id_anggota" id="id_anggota" class="form-select" required>
                <option value="" disabled selected>-- Pilih Anggota --</option>
                @foreach($anggotas as $anggota)
                    <option value="{{ $anggota->id }}" {{ old('id_anggota') == $anggota->id ? 'selected' : '' }}>
                        {{ $anggota->nama }} ({{ $anggota->nis }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="id_buku" class="form-label">Buku</label>
            <select name="id_buku" id="id_buku" class="form-select" required>
                <option value="" disabled selected>-- Pilih Buku --</option>
                @foreach($bukus as $buku)
                    <option value="{{ $buku->id }}" {{ old('id_buku') == $buku->id ? 'selected' : '' }}>
                        {{ $buku->judul }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control"
                   value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label for="tanggal_harus_kembali" class="form-label">Tanggal Harus Kembali</label>
            <input type="date" name="tanggal_harus_kembali" id="tanggal_harus_kembali" class="form-control"
                   value="{{ old('tanggal_harus_kembali', date('Y-m-d', strtotime('+7 days'))) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
