@extends('layouts.petugas')

@section('content')
<div class="container">
    <h4>Data Denda</h4>

    <a href="{{ route('petugas.denda.create') }}" class="btn btn-primary mb-3">+ Tambah Denda</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Anggota</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Tgl Bayar</th>
                <th>Petugas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($denda as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->peminjaman->anggota->nama ?? '-' }}</td>
                    <td>@currency($peminjaman->denda)</td>
                    <td>{{ $item->status_denda }}</td>
                    <td>{{ $item->tanggal_pembayaran ?? '-' }}</td>
                    <td>{{ $item->petugas->nama ?? '-' }}</td>
                    <td>
                        <a href="{{ route('petugas.denda.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('petugas.denda.destroy', $item->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
