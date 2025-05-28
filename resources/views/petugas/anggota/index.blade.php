@extends('layouts.petugas')

@section('title', 'Daftar Anggota')

@section('content')
<div class="container mt-4">
    
    <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Daftar Anggota</h3>
            <a href="{{ route('petugas.anggota.create') }}" class="btn btn-primary">+ Tambah Anggota</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif


    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>No HP</th>
                    <th>Jenis Kelamin</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($anggota as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->nis }}</td>
                        <td>{{ $item->nama_anggota }}</td>
                        <td>{{ $item->no_hp }}</td>
                        <td>{{ $item->jenis_kelamin }}</td>
                        <td class="text-center">
                            <span class="badge bg-{{ $item->status_anggota === 'Aktif' ? 'success' : 'secondary' }}">
                                {{ $item->status_anggota }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('petugas.anggota.show', $item->id) }}" class="btn btn-sm btn-info">Detail</a>
                            <a href="{{ route('petugas.anggota.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('petugas.anggota.destroy', $item->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data anggota.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
