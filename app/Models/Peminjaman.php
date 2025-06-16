<?php

namespace App\Models;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Denda;
use App\Models\PeminjamanDetail;
use App\Models\Petugas;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Peminjaman extends Model
{
    use HasFactory;

    /**
     * Kolom yang TIDAK bisa diisi massal
     */

    protected $table = 'peminjaman'; // <--- Tambahkan ini
    protected $guarded = ['id']; // Hanya 'id' yang diproteksi

    /**
     * Casting tipe data
     */
    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_kembali' => 'datetime',
        'tanggal_harus_kembali' => 'datetime'
    ];



    public function getDendaAttribute()
    {
        // Hitung hanya jika status masih 'dipinjam' dan tanggal harus kembali sudah lewat
        if ($this->status === 'dipinjam' && $this->tanggal_harus_kembali) {
            $hariIni = Carbon::today();
            $tanggalHarusKembali = Carbon::parse($this->tanggal_harus_kembali);

            if ($tanggalHarusKembali->lessThan($hariIni)) {
                $jumlahHariTerlambat = $tanggalHarusKembali->diffInDays($hariIni);
                return $jumlahHariTerlambat * 1000; // tarif denda per hari
            }
        }

        return 0;
    }


    /* ==================== RELASI ==================== */

    /**
     * Relasi ke Anggota
     */
    public function anggota(): BelongsTo
    {
        return $this->belongsTo(Anggota::class, 'id_anggota');
    }


    /**
     * Relasi ke Petugas
     */
    public function petugas(): BelongsTo
    {
        return $this->belongsTo(Petugas::class, 'id_petugas');
    }

    /**
     * Relasi ke Denda (One-to-One)
     */
    public function denda(): HasOne
    {
        return $this->hasOne(Denda::class, 'id_peminjaman');
    }
    /**
     * Relasi ke PeminjamanDetail (One-to-Many)
     */
    public function details(): HasMany
    {
        return $this->hasMany(PeminjamanDetail::class, 'id_peminjaman');
    }

    /* ==================== METHOD CUSTOM ==================== */

    /**
     * Cek apakah peminjaman sudah lewat jatuh tempo
     */
    public function isTerlambat(): bool
    {
        return now()->gt($this->tanggal_harus_kembali) &&
               $this->status === 'Dipinjam';
    }

    /**
     * Hitung hari keterlambatan
     */
    public function hariKeterlambatan(): int
    {
        return $this->isTerlambat()
            ? now()->diffInDays($this->tanggal_harus_kembali)
            : 0;
    }

    /**
     * Scope untuk peminjaman aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'Dipinjam');
    }

    /**
     * Scope untuk pencarian
     */
    public function scopeCari($query, string $keyword)
    {
        return $query->whereHas('anggota', fn($q) => $q->where('nama_anggota', 'like', "%$keyword%"))
                   ->orWhereHas('buku', fn($q) => $q->where('judul', 'like', "%$keyword%"));
    }

    public function getFormattedTanggalPinjamAttribute()
    {
        return optional($this->tanggal_pinjam)->format('d-m-Y');
    }

    public function getFormattedTanggalKembaliAttribute()
    {
        return optional($this->tanggal_kembali)->format('d-m-Y');
    }

    public function getFormattedDendaAttribute()
    {
        return $this->denda > 0
            ? 'Rp ' . number_format($this->denda, 0, ',', '.')
            : null;
    }

}
