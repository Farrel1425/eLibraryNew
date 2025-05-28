@extends('layouts.petugas')

@section('title', 'Daftar Kategori Buku')

@section('content')
<div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Daftar Kategori</h3>
            <a href="{{ route('petugas.kategori.create') }}" class="btn btn-primary">+ Tambah Kategori</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr class="text-center">
                    <th class="align-middle py-3" style="width: 50px;">No</th>
                    <th class="align-middle py-3">Nama Kategori</th>
                    <th class="align-middle py-3">Deskripsi</th>
                    <th class="align-middle py-3" style="width: 130px;">Jumlah Buku</th>
                    <th class="align-middle py-3" style="width: 200px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kategoris as $kategori)
                    <tr>
                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $kategori->nama_kategori }}</td>
                        <td class="align-middle">{{ $kategori->deskripsi ?? '-' }}</td>
                        <td class="text-center align-middle">{{ $kategori->jumlah_buku }}</td>
                        <td class="text-center align-middle text-nowrap">
                            <a href="{{ route('petugas.kategori.show', $kategori->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('petugas.kategori.edit', $kategori->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('petugas.kategori.destroy', $kategori->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center align-middle">Belum ada kategori buku.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>



    </div>
</div>
@endsection
