@extends('layouts.petugas')

@section('title', 'Daftar Peminjaman Buku')

@section('content')
<div class="container mt-4" id="mainContent">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Peminjaman</h3>
        <a href="{{ route('petugas.peminjaman.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Peminjaman
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Search & Filter --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" id="searchInput" placeholder="Cari anggota, petugas, tanggal..." autocomplete="off">
                <button class="btn btn-outline-secondary" type="button" onclick="resetSearch()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <div class="col-md-4 d-flex gap-2">
            <select class="form-select" id="statusFilter">
                <option value="">Semua Status</option>
                <option value="dipinjam">Dipinjam</option>
                <option value="dikembalikan">Dikembalikan</option>
            </select>
            <button class="btn btn-outline-secondary" onclick="PeminjamanManager.clearAllFilters()" title="Reset Filter">
                <i class="fas fa-rotate-left"></i>
            </button>
        </div>

        <div class="col-md-2 text-end">
            <span class="badge bg-secondary fs-6" id="resultCount">
                Total: {{ $peminjamans->count() }} peminjaman
            </span>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped" id="peminjamanTable">
            <thead class="table-dark text-center">
                <tr>
                    <th>No</th>
                    <th>Anggota</th>
                    <th>Petugas</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                    <th>Denda</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="peminjamanTableBody">
                @forelse($peminjamans as $peminjaman)
                    <tr class="peminjaman-row" data-search="{{ strtolower(($peminjaman->anggota->nama_anggota ?? '') . ' ' . ($peminjaman->petugas->nama_petugas ?? '') . ' ' . optional($peminjaman->tanggal_pinjam)->format('d-m-Y') . ' ' . optional($peminjaman->tanggal_kembali)->format('d-m-Y') . ' ' . $peminjaman->status) }}">
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>
                            <strong>{{ $peminjaman->anggota->nama_anggota ?? '-' }}</strong>
                            @if($peminjaman->anggota?->nis)
                                <br><small class="text-muted">NIS: {{ $peminjaman->anggota->nis }}</small>
                            @endif
                        </td>
                        <td>{{ $peminjaman->petugas->nama_petugas ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge bg-info">{{ $peminjaman->formatted_tanggal_pinjam ?? '-' }}</span>
                        </td>
                        <td class="text-center">
                           @if($peminjaman->formatted_tanggal_kembali)
                                <span class="badge bg-success">{{ $peminjaman->formatted_tanggal_kembali }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge
                                @if(strtolower($peminjaman->status) === 'dipinjam') bg-danger
                                @elseif(strtolower($peminjaman->status) === 'dikembalikan') bg-success
                                @else bg-secondary
                                @endif">
                                {{ ucfirst($peminjaman->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($peminjaman->formatted_denda)
                                <span class="badge bg-warning text-dark">{{ $peminjaman->formatted_denda }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('petugas.peminjaman.show', $peminjaman->id) }}" class="btn btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('petugas.peminjaman.edit', $peminjaman->id) }}" class="btn btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                <button class="btn btn-danger" onclick="confirmDelete('Peminjaman {{ $peminjaman->anggota->nama_anggota ?? 'Unknown' }}', '{{ route('petugas.peminjaman.destroy', $peminjaman->id) }}')" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-book fa-2x mb-2"></i>
                            <p class="mb-0">Belum ada data peminjaman</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div id="noResults" class="text-center py-4 d-none">
        <i class="fas fa-search fa-2x text-muted mb-2"></i>
        <p class="text-muted">Tidak ditemukan peminjaman yang sesuai</p>
        <small class="text-muted">Coba gunakan kata kunci berbeda</small>
    </div>

    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection

@push('scripts')
<script>
    const PeminjamanManager = {
        init() {
            this.bindSearch();
            this.bindFilter();
        },
        bindSearch() {
            document.getElementById('searchInput').addEventListener('input', this.applyFilter);
        },
        bindFilter() {
            document.getElementById('statusFilter').addEventListener('change', this.applyFilter);
        },
        applyFilter() {
            const keyword = document.getElementById('searchInput').value.toLowerCase();
            const status = document.getElementById('statusFilter').value.toLowerCase();
            let visibleCount = 0;

            document.querySelectorAll('.peminjaman-row').forEach(row => {
                const rowData = row.dataset.search ?? '';
                const rowStatus = !status || rowData.includes(status);
                const rowMatch = rowData.includes(keyword);
                const shouldShow = rowMatch && rowStatus;

                row.style.display = shouldShow ? '' : 'none';
                if (shouldShow) visibleCount++;
            });

            document.getElementById('resultCount').innerText = `Total: ${visibleCount} peminjaman`;
            document.getElementById('noResults').classList.toggle('d-none', visibleCount > 0);
        },
        clearAllFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            this.applyFilter();
        }
    };

    document.addEventListener('DOMContentLoaded', () => {
        PeminjamanManager.init();
    });

    function confirmDelete(name, url) {
        if (confirm(`Yakin ingin menghapus data ${name}?`)) {
            const form = document.getElementById('deleteForm');
            form.action = url;
            form.submit();
        }
    }

    function resetSearch() {
        document.getElementById('searchInput').value = '';
        PeminjamanManager.applyFilter();
    }
</script>
@endpush
