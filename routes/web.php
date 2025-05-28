<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Anggota\DashboardController as AnggotaDashboardController;


use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PetugasController;


use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\AnggotaController;
use App\Http\Controllers\Petugas\BukuController;
use App\Http\Controllers\Petugas\KategoriController;
use App\Http\Controllers\Petugas\PeminjamanController;
use App\Http\Controllers\Petugas\DendaController;
use App\Http\Controllers\Petugas\PengembalianController;


Route::get('/', function () {
    return redirect()->route('login');
});


//---------------------------------------------------------------------------------------------------

// Route khusus dashboard-admin (tanpa prefix URL, tapi tetap dalam middleware role:admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard-admin', [AdminDashboardController::class, 'index'])->name('dashboard.admin');
});

// Route admin lainnya (dengan prefix 'admin/')
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('petugas', PetugasController::class);
});

//---------------------------------------------------------------------------------------------------

// Route khusus dashboard-petugas (tanpa prefix URL, tapi tetap dalam middleware role:petugas)
Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/dashboard-petugas', [PetugasDashboardController::class, 'index'])->name('dashboard.petugas');
});

// Route petugas lainnya (dengan prefix 'petugas/')
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::resource('buku', BukuController::class);
    Route::get('/buku/kategori/{id}', [BukuController::class, 'show'])->name('buku.show');

    Route::resource('anggota', AnggotaController::class);

    Route::resource('kategori', KategoriController::class);
    Route::get('/kategori/{id}', [KategoriController::class, 'show'])->name('kategori.show');

    Route::resource('peminjaman', PeminjamanController::class);
    Route::resource('denda', DendaController::class);
    Route::resource('pengembalian', PengembalianController::class);
    
});

//---------------------------------------------------------------------------------------------------

// Route khusus dashboard-anggota (tanpa prefix URL, tapi tetap dalam middleware role:anggota)
Route::middleware(['auth', 'role:anggota'])->group(function () {
    Route::get('/dashboard-anggota', [AnggotaDashboardController::class, 'index'])->name('dashboard.anggota');
});



require __DIR__.'/auth.php';