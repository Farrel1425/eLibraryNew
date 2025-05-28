<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Denda extends Model
{
    use HasFactory;

    /**
     * Kolom yang TIDAK bisa diisi massal
     * 
     */
    protected $table = 'denda';
    protected $guarded = ['id']; // Hanya proteksi ID

    /**
     * Casting tipe data
     */
    protected $casts = [
        'tanggal_pembayaran' => 'datetime',
        'jumlah' => 'decimal:2'
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
     * Accessor untuk status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status_denda) {
            'Lunas' => '<span class="badge bg-success">Lunas</span>',
            'Belum Lunas' => '<span class="badge bg-warning">Belum Lunas</span>',
            'Dibebaskan' => '<span class="badge bg-info">Dibebaskan</span>',
            default => '<span class="badge bg-secondary">-</span>'
        };
    }

    /**
     * Hitung denda per hari (contoh: Rp5.000/hari)
     */
    public static function hitungDenda(int $hari_keterlambatan): float
    {
        return $hari_keterlambatan * 5000;
    }

    /**
     * Scope untuk denda belum lunas
     */
    public function scopeBelumLunas($query)
    {
        return $query->where('status_denda', 'Belum Lunas');
    }

    /**
     * Scope untuk denda belum dibayar dan sudah lebih dari 7 hari
     */
    public function scopeTerlambatBayar($query)
    {
        return $query
            ->where('status_denda', 'Belum Lunas')
            ->whereDate('created_at', '<', now()->subDays(7));
    }
}

