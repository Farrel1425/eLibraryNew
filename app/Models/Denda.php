<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Denda extends Model
{
    use HasFactory;

    protected $table = 'denda';

    /**
     * Kolom yang tidak bisa diisi massal
     */
    protected $guarded = ['id'];

    /**
     * Casts tipe data otomatis
     */
    protected $casts = [
        'tanggal_pembayaran' => 'datetime',
        'jumlah' => 'float', // gunakan float agar tetap presisi meskipun tidak tampil 2 angka
    ];

    /**
     * Relasi ke Peminjaman
     */
    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }

    /**
     * Relasi ke Petugas (yang mencatat denda)
     */
    public function petugas(): BelongsTo
    {
        return $this->belongsTo(Petugas::class, 'id_petugas');
    }

    /**
     * Accessor untuk badge status_denda
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status_denda) {
            'Lunas' => '<span class="badge bg-success">Lunas</span>',
            'Belum Lunas' => '<span class="badge bg-warning text-dark">Belum Lunas</span>',
            'Dibebaskan' => '<span class="badge bg-info text-dark">Dibebaskan</span>',
            default => '<span class="badge bg-secondary">-</span>',
        };
    }

    /**
     * Hitung jumlah denda berdasarkan hari keterlambatan
     */
    public static function hitungDenda(int $hari_keterlambatan): float
    {
        return $hari_keterlambatan * 5000; // bisa ubah ke config jika ingin dinamis
    }

    /**
     * Scope denda yang belum lunas
     */
    public function scopeBelumLunas($query)
    {
        return $query->where('status_denda', 'Belum Lunas');
    }

    /**
     * Scope denda yang belum dibayar dan sudah lebih dari 7 hari
     */
    public function scopeTerlambatBayar($query)
    {
        return $query
            ->where('status_denda', 'Belum Lunas')
            ->where('created_at', '<', now()->subDays(7));
    }
}
