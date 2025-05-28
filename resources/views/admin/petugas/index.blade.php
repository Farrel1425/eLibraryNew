@extends('layouts.admin')

@section('title', 'Kelola Petugas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Data Petugas</h2>
    <a href="{{ route('admin.petugas.create') }}" class="btn btn-primary">Tambah Petugas</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($petugas as $item)
        <tr>
            <td>{{ $item->user ? $item->user->name : '-' }}</td>
            <td>{{ $item->user ? $item->user->email : '-' }}</td>
            <td>
                <a href="{{ route('admin.petugas.show', $item->id) }}" class="btn btn-sm btn-info">Detail</a>
                <a href="{{ route('admin.petugas.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('admin.petugas.destroy', $item->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Yakin ingin hapus?')" class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
