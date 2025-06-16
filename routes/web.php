<?php


use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Anggota\DashboardController as AnggotaDashboardController;
use App\Http\Controllers\Anggota\KunjunganController as AnggotaKunjunganController;


use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PetugasController;


use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\KunjunganController as PetugasKunjunganController;
use App\Http\Controllers\Petugas\AnggotaController;
use App\Http\Controllers\Petugas\BukuController;
use App\Http\Controllers\Petugas\KategoriController;
use App\Http\Controllers\Petugas\PeminjamanController;
use App\Http\Controllers\Petugas\DendaController;
use App\Http\Controllers\Petugas\PengembalianController;



Route::get('/', function () {
    return redirect()->route('login');
});


//-------------------------------------------ADMIN--------------------------------------------------------

// Route khusus dashboard-admin (tanpa prefix URL, tapi tetap dalam middleware role:admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard-admin', [AdminDashboardController::class, 'index'])->name('dashboard.admin');
});

// Route admin lainnya (dengan prefix 'admin/')
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('petugas', PetugasController::class);
});

//--------------------------------------------PETUGAS-------------------------------------------------------

// Route khusus dashboard-petugas (tanpa prefix URL, tapi tetap dalam middleware role:petugas)
Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/dashboard-petugas', [PetugasDashboardController::class, 'index'])->name('dashboard.petugas');
});

Route::get('/api/buku/search', [BukuController::class, 'search'])->name('api.buku.search');

// Route petugas lainnya (dengan prefix 'petugas/')
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::resource('buku', BukuController::class);
    Route::get('/buku/kategori/{id}', [BukuController::class, 'show'])->name('buku.show');

    Route::resource('anggota', AnggotaController::class);

    Route::resource('kategori', KategoriController::class);
    Route::get('/kategori/{id}', [KategoriController::class, 'show'])->name('kategori.show');

    Route::resource('peminjaman', PeminjamanController::class);
    Route::patch('peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('petugas.peminjaman.kembalikan');
    Route::resource('denda', DendaController::class);
    Route::post('denda/{denda}/bayar', [DendaController::class, 'bayar'])->name('petugas.denda.bayar');
    Route::resource('pengembalian', PengembalianController::class);

     Route::get('/kunjungan', [PetugasKunjunganController::class, 'index'])->name('kunjungan.index');

});

//------------------------------------------------ANGGOTA---------------------------------------------------

// Route khusus dashboard-anggota (tanpa prefix URL, tapi tetap dalam middleware role:anggota)
Route::middleware(['auth', 'role:anggota'])->group(function () {
    Route::get('/dashboard-anggota', [AnggotaDashboardController::class, 'index'])->name('dashboard.anggota');
});



//-------------------------------------------------KUNJUNGAN--------------------------------------------------


// ROUTE untuk anggota input kunjungan
Route::prefix('anggota')->group(function () {
    Route::get('/input-kunjungan', [AnggotaKunjunganController::class, 'create'])->name('anggota.kunjungan.create');
    Route::post('/input-kunjungan', [AnggotaKunjunganController::class, 'store'])->name('anggota.kunjungan.store');
});



//---------------------------------------------------------------------------------------------------

require __DIR__.'/auth.php';
