@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="app-title">
    <h1><i class="fas fa-tachometer-alt me-2"></i> Dashboard Admin</h1>
    <p>Selamat datang di halaman dashboard admin.</p>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Buku</h5>
                <p class="card-text fs-3">120</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Anggota</h5>
                <p class="card-text fs-3">75</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Peminjaman Aktif</h5>
                <p class="card-text fs-3">30</p>
            </div>
        </div>
    </div>
</div>
@endsection
