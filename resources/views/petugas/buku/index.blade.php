@extends('layouts.petugas')

@section('title', 'Daftar Buku')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Daftar Buku</h3>
            <a href="{{ route('petugas.buku.create') }}" class="btn btn-primary">+ Tambah Buku</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif


    <div class="table-responsive"> 
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr class="text-center">
                    <th class="align-middle py-3" style="width: 50px;">No</th>
                    <th class="align-middle py-3">Judul</th>
                    <th class="align-middle py-3">Penulis</th>
                    <th class="align-middle py-3">Kategori</th>
                    <th class="align-middle py-3">Stok</th>
                    <th class="align-middle py-3">Status</th>
                    <th class="align-middle py-3" style="width: 200px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($buku as $index => $item)
                    <tr>
                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                        <td title="{{ $item->judul }}" style="width: 350px;">{{ Str::limit($item->judul, 40, '...') }}</td>
                        <td class="text-center align-middle">{{ $item->penulis }}</td>
                        <td class="text-center align-middle">{{ $item->kategori ? $item->kategori->nama_kategori : '-' }}</td>
                        <td class="text-center align-middle">{{ $item->stok }}</td>
                        <td class="text-center align-middle">{{ $item->status_buku }}</td>
                        <td class="text-center align-middle text-nowrap">
                            <a href="{{ route('petugas.buku.show', $item->id) }}" class="btn btn-sm btn-info">Detail</a>
                            <a href="{{ route('petugas.buku.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('petugas.buku.destroy', $item->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Data buku belum tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- <div class="mt-6">
            {{ $bukus->links('pagination::tailwind') }}
        </div> --}}


    </div>
</div>
@endsection
