@extends('layouts.petugas')

@section('title', 'Tambah Peminjaman')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Tambah Peminjaman</h3>
        <a href="{{ route('petugas.peminjaman.index') }}" class="btn btn-outline-secondary">← Kembali</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('petugas.peminjaman.store') }}" method="POST">
                @csrf

                {{-- Anggota --}}
                <div class="mb-3">
                    <label for="id_anggota" class="form-label">Nama Anggota</label>
                    <select name="id_anggota" id="id_anggota" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Anggota --</option>
                        @foreach($anggotas as $anggota)
                            <option value="{{ $anggota->id }}" {{ old('id_anggota') == $anggota->id ? 'selected' : '' }}>
                                {{ $anggota->nama }} ({{ $anggota->nis }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Buku - Select2 Multiple --}}
                <div class="mb-3">
                    <label for="id_buku" class="form-label">Pilih Buku (boleh lebih dari satu)</label>
                    <select name="id_buku[]" id="id_buku" class="form-select" multiple required></select>

                    @error('id_buku')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tanggal --}}
                <div class="mb-3">
                    <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control"
                           value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
                </div>

                <div class="mb-3">
                    <label for="tanggal_harus_kembali" class="form-label">Tanggal Harus Kembali</label>
                    <input type="date" name="tanggal_harus_kembali" id="tanggal_harus_kembali" class="form-control"
                           value="{{ old('tanggal_harus_kembali', date('Y-m-d', strtotime('+7 days'))) }}" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">💾 Simpan Peminjaman</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
    {{-- Load CSS Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    {{-- Pastikan jQuery dimuat terlebih dahulu --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Load JS Select2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#id_buku').select2({
            placeholder: 'Cari dan pilih buku...',
            ajax: {
                url: '{{ route('api.buku.search') }}', // ✅ pastikan route ini ada dan mengembalikan JSON
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term // keyword pencarian
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.map(item => ({
                            id: item.id,
                            text: item.judul // pastikan kolom 'judul' ada di tabel buku
                        }))
                    };
                },
                cache: true
            }
        });
    });
    </script>
@endpush
