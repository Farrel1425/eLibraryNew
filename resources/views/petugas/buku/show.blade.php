@extends('layouts.petugas')

@section('content')
<div class="container">
    <h3>Detail Buku</h3>

    <div class="card my-3">
        <div class="card-body">
            <h5 class="card-title mb-3">{{ $buku->judul }}</h5>

            <p><strong>Kategori:</strong> {{ $buku->kategori->nama_kategori ?? '-' }}</p>
            <p><strong>Penulis:</strong> {{ $buku->penulis }}</p>
            <p><strong>Penerbit:</strong> {{ $buku->penerbit }}</p>
            <p><strong>Tahun Terbit:</strong> {{ $buku->tahun_terbit }}</p>
            <p><strong>Stok:</strong> {{ $buku->stok }}</p>
            <p><strong>Status Buku:</strong> 
                <span class="badge bg-{{ $buku->status_buku === 'Tersedia' ? 'success' : 'secondary' }}">
                    {{ $buku->status_buku }}
                </span>
            </p>
            <p><strong>Dibuat pada:</strong> {{ $buku->created_at->format('d M Y H:i') }}</p>
            <p><strong>Terakhir diperbarui:</strong> {{ $buku->updated_at->format('d M Y H:i') }}</p>
        </div>
    </div>

    <a href="{{ route('petugas.buku.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Buku</a>
</div>
@endsection
