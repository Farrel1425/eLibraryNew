{{-- @dd($peminjamans) --}}
@extends('layouts.petugas')

@section('title', 'Daftar Peminjaman Buku')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Peminjaman</h3>
        <a href="{{ route('petugas.peminjaman.create') }}" class="btn btn-primary">+ Tambah Peminjaman</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr class="text-center">
                <th class="align-middle py-3" style="width: 50px;">No</th>
                <th class="align-middle py-3">Anggota</th>
                <th class="align-middle py-3">Petugas</th>
                <th class="align-middle py-3">Tanggal Pinjam</th>
                <th class="align-middle py-3">Tanggal Kembali</th>
                <th class="align-middle py-3">Status</th>
                <th class="align-middle py-3" style="width: 200px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peminjamans as $peminjaman)
                <tr>
                    <td class="text-center align-middle">{{ $loop->iteration }}</td>
                    <td class="align-middle">{{ $peminjaman->anggota->nama_anggota ?? '-' }}</td>
                    <td class="align-middle">{{ $peminjaman->petugas->nama_petugas ?? '-' }}</td>

                    {{-- Pastikan tanggal_pinjam bukan null sebelum memformat --}} 
                    <td class="text-center align-middle">
                        {{ optional($peminjaman->tanggal_pinjam)->format('d-m-Y') ?? '-' }}
                    </td>

                    {{-- Pastikan tanggal_kembali bukan null sebelum memformat --}}
                    <td class="text-center align-middle">
                        {{ optional($peminjaman->tanggal_kembali)->format('d-m-Y') ?? '-' }}
                    </td>

                    <td class="text-center align-middle">{!! $peminjaman->status !!}</td>
                    <td class="text-center align-middle text-nowrap">
                        <a href="{{ route('petugas.peminjaman.show', $peminjaman->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('petugas.peminjaman.edit', $peminjaman->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('petugas.peminjaman.destroy', $peminjaman->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin ingin menghapus peminjaman ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center align-middle">Belum ada data peminjaman.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>

</div>
@endsection
