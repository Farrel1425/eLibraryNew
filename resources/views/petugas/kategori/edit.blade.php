@extends('layouts.petugas')

@section('title', 'Edit Kategori')

@section('content')
<div class="container mt-4">
    <h3>Edit Kategori Buku</h3>

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

    <form action="{{ route('petugas.kategori.update', $kategori->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_kategori" class="form-label">Nama Kategori</label>
            <input type="text" name="nama_kategori" id="nama_kategori" class="form-control"
                   value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
        </div>

        <div class="mb-3">
            <input type="number" name="jumlah_buku" id="jumlah_buku" class="form-control" value="{{ old('jumlah_buku', $kategori->jumlah_buku) }}" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('petugas.kategori.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
