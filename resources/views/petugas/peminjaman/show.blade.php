@extends('layouts.petugas')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="container mt-4">
    <h3>Detail Peminjaman</h3>

    <a href="{{ route('petugas.peminjaman.index') }}" class="btn btn-secondary mb-3">← Kembali ke Daftar</a>

    <div class="card">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Nama Anggota</dt>
                <dd class="col-sm-9">{{ $peminjaman->anggota->nama_anggota ?? '-' }}</dd>

                <dt class="col-sm-3">Judul Buku</dt>
                <dd class="col-sm-9">{{ $peminjaman->buku->judul ?? '-' }}</dd>

                <dt class="col-sm-3">Petugas</dt>
                <dd class="col-sm-9">{{ $peminjaman->petugas->nama_petugas ?? '-' }}</dd>

                <dt class="col-sm-3">Tanggal Pinjam</dt>
                <dd class="col-sm-9">{{ $peminjaman->tanggal_pinjam->format('d-m-Y') }}</dd>

                <dt class="col-sm-3">Tanggal Harus Kembali</dt>
                <dd class="col-sm-9">{{ $peminjaman->tanggal_harus_kembali->format('d-m-Y') }}</dd>

                <dt class="col-sm-3">Tanggal Kembali</dt>
                <dd class="col-sm-9">{{ optional($peminjaman->tanggal_kembali)->format('d-m-Y') ?? '-' }}</dd>

                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">{{ $peminjaman->status }}</dd>

                @if($peminjaman->denda)
                    <dt class="col-sm-3">Denda</dt>
                    <dd class="col-sm-9">Rp {{ number_format($peminjaman->denda->jumlah, 0, ',', '.') }}</dd>
                @endif
            </dl>
        </div>
    </div>
</div>
@endsection
