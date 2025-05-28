@extends('layouts.admin')

@section('title', 'Edit Petugas')

@section('content')
<div class="mb-3">
    <h2>Edit Petugas</h2>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <strong>Oops!</strong> Ada masalah dengan inputan Anda.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.petugas.update', $petugas->id) }}" method="POST">
    @csrf
    @method('PUT')

    <h5>Data User</h5>
    <div class="mb-3">
        <label for="name" class="form-label">Nama Lengkap</label>
        <input type="text" name="name" value="{{ old('name', $petugas->user->name) }}" class="form-control" id="name" required>
    </div>

    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" value="{{ old('username', $petugas->user->username) }}" class="form-control" id="username" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email', $petugas->user->email) }}" class="form-control" id="email" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password <small>(kosongkan jika tidak ingin ganti)</small></label>
        <input type="password" name="password" class="form-control" id="password" placeholder="Isi hanya jika ingin mengganti password">
    </div>

    <hr>

    <h5>Data Petugas</h5>
    <div class="mb-3">
        <label for="nama_petugas" class="form-label">Nama Petugas</label>
        <input type="text" name="nama_petugas" value="{{ old('nama_petugas', $petugas->nama_petugas) }}" class="form-control" id="nama_petugas" required>
    </div>

    <div class="mb-3">
        <label for="no_hp" class="form-label">No. HP</label>
        <input type="text" name="no_hp" value="{{ old('no_hp', $petugas->no_hp) }}" class="form-control" id="no_hp" required>
    </div>

    <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea name="alamat" class="form-control" id="alamat" rows="3" required>{{ old('alamat', $petugas->alamat) }}</textarea>
    </div>

    <div class="mb-3">
        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
            <option value="">-- Pilih Jenis Kelamin --</option>
            <option value="Laki-laki" {{ old('jenis_kelamin', $petugas->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
            <option value="Perempuan" {{ old('jenis_kelamin', $petugas->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-select" required>
            <option value="">-- Pilih Status --</option>
            <option value="Aktif" {{ old('status', $petugas->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="Cuti" {{ old('status', $petugas->status) == 'Cuti' ? 'selected' : '' }}>Cuti</option>
            <option value="Resign" {{ old('status', $petugas->status) == 'Resign' ? 'selected' : '' }}>Resign</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('admin.petugas.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
