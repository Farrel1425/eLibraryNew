@extends('layouts.petugas')

@section('title', 'Edit Buku')

@section('content')
<div class="container mt-4">
    <h3>Edit Buku</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops! Ada masalah dengan input Anda:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('petugas.buku.update', $buku->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="judul" class="form-label">Judul Buku</label>
            <input type="text" name="judul" id="judul" class="form-control" 
                   value="{{ old('judul', $buku->judul) }}" required>
        </div>

        <div class="mb-3">
            <label for="penulis" class="form-label">Penulis</label>
            <input type="text" name="penulis" id="penulis" class="form-control" 
                   value="{{ old('penulis', $buku->penulis) }}" required>
        </div>

        <div class="mb-3">
            <label for="penerbit" class="form-label">Penerbit</label>
            <input type="text" name="penerbit" id="penerbit" class="form-control" 
                   value="{{ old('penerbit', $buku->penerbit) }}" required>
        </div>

        <div class="mb-3">
            <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
            <input type="number" name="tahun_terbit" id="tahun_terbit" class="form-control" 
                   value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" 
                   min="1900" max="{{ date('Y') }}" required>
        </div>

        <div class="mb-3">
            <label for="id_kategori" class="form-label">Kategori</label>
            <select name="id_kategori" id="id_kategori" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategori as $kat)
                    <option value="{{ $kat->id }}" 
                        {{ old('id_kategori', $buku->id_kategori) == $kat->id ? 'selected' : '' }}>
                        {{ $kat->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" name="stok" id="stok" class="form-control" 
                   value="{{ old('stok', $buku->stok) }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="status_buku" class="form-label">Status Buku</label>
            <select name="status_buku" id="status_buku" class="form-select" required>
                <option value="Tersedia" {{ old('status_buku', $buku->status_buku) == 'Tersedia' ? 'selected' : '' }}>
                    Tersedia
                </option>
                <option value="Tidak Tersedia" {{ old('status_buku', $buku->status_buku) == 'Tidak Tersedia' ? 'selected' : '' }}>
                    Tidak Tersedia
                </option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('petugas.buku.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection

