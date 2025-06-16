@extends('layouts.petugas')

@section('title', 'Data Pengembalian Buku')

@section('content')
<div class="container mt-4">
    <h4>Data Pengembalian Buku</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm mt-3">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Anggota</th>
                        <th>Judul Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Harus Kembali</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                        <th>Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjamans as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->anggota->nama ?? '-' }}</td>
                            <td>{{ $item->buku->judul ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_harus_kembali)->format('d-m-Y') }}</td>
                            <td>{{ optional($item->detail)->tanggal_kembali ? $item->detail->tanggal_kembali->format('d-m-Y') : '-' }}</td>

                            <td>
                                <span class="badge {{ $item->status === 'Terlambat' ? 'bg-danger' : 'bg-success' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td>
                                @if($item->denda)
                                    {!! $item->denda->status_label !!}
                                    <br>
                                    <small>Rp {{ number_format($item->denda->jumlah, 0, ',', '.') }}</small>
                                @else
                                    <span class="badge bg-secondary">Tidak Ada</span>
                                @endif
                            </td>
                            <td>{{ $item->petugas->nama ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Belum ada data pengembalian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
