@extends('layouts.petugas')

@section('content')
<div class="container">
    <h3>Detail Kategori Buku</h3>

    <div class="card my-3">
        <div class="card-body">
            <h5 class="card-title mb-3">{{ $kategori->nama_kategori }}</h5>
            
            <p><strong>Deskripsi:</strong> {{ $kategori->deskripsi ?? '-' }}</p>
            <p><strong>Jumlah Buku:</strong> {{ $kategori->jumlah_buku }}</p>
            <p><strong>Dibuat pada:</strong> {{ $kategori->created_at->format('d M Y H:i') }}</p>
            <p><strong>Terakhir diperbarui:</strong> {{ $kategori->updated_at->format('d M Y H:i') }}</p>
        </div>
    </div>

    <a href="{{ route('petugas.kategori.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar</a>
</div>
@endsection
