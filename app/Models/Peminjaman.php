<?php

namespace App\Models;

use App\Models\Buku;
use App\Models\Denda;
use App\Models\Anggota;
use App\Models\Petugas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    /* ==================== RELASI ==================== */
    
    /**
     * Relasi ke Anggota
     */
    public function anggota(): BelongsTo
    {
        return $this->belongsTo(Anggota::class, 'id_anggota');
    }

    /**
     * Relasi ke Buku
     */
    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'id_buku');
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
}
