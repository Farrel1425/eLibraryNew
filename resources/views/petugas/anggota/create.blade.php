@extends('layouts.petugas')

@section('title', 'Tambah Anggota')

@section('content')
<div class="container mt-4">
    <h3>Tambah Anggota</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops! Ada kesalahan pada input:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('petugas.anggota.store') }}" method="POST">
        @csrf

        <!-- Input untuk User -->
        <div class="mb-3">
            <label for="name" class="form-label">Nama User</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email User</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <!-- Input untuk anggota -->
        <div class="mb-3">
            <label for="nis" class="form-label">NIS</label>
            <input type="text" name="nis" id="nis" class="form-control" value="{{ old('nis') }}" required>
        </div>

        <div class="mb-3">
            <label for="nama_anggota" class="form-label">Nama Lengkap</label>
            <input type="text" name="nama_anggota" id="nama_anggota" class="form-control" value="{{ old('nama_anggota') }}" required>
        </div>

        <div class="mb-3">
            <label for="no_hp" class="form-label">Nomor HP</label>
            <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ old('no_hp') }}" required>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                <option value="">-- Pilih --</option>
                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('petugas.anggota.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
