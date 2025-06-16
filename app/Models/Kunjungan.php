<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kunjungan extends Model
{
   use HasFactory;

    /**
     * Kolom yang TIDAK bisa diisi massal
     * Kosongkan array untuk mengizinkan semua field diisi
     */
    protected $table = 'kunjungan'; 
    protected $guarded = [];

    /**
     * Casting tipe data otomatis
     */
    protected $casts = [
        'waktu_kunjungan' => 'datetime'
    ];

    /**
     * Relasi ke Anggota
     */
    public function anggota(): BelongsTo
    {
        return $this->belongsTo(Anggota::class, 'id_anggota');
    }

    /**
     * Scope untuk kunjungan hari ini
     */
    public function scopeHariIni($query)
    {
        return $query->whereDate('waktu_kunjungan', today());
    }

    /**
     * Scope untuk kunjungan oleh anggota tertentu
     */
    public function scopeDariAnggota($query, $anggotaId)
    {
        return $query->where('id_anggota', $anggotaId);
    }

    /**
     * Accessor untuk format waktu custom
     */
    public function getWaktuKunjunganFormattedAttribute(): string
    {
        return $this->waktu_kunjungan->translatedFormat('l, d F Y H:i');
    }

}
