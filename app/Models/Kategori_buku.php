<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori_buku extends Model
{
    use HasFactory;

    /**
     * Kolom yang TIDAK bisa diisi (mass assignment)
     */
    protected $guarded = [];

    /**
     * Nama tabel (opsional jika mengikuti konvensi plural Laravel)
     */
    protected $table = 'kategori';

    /**
     * Relasi one-to-many ke Buku
     */
    public function buku(): HasMany
    {
        return $this->hasMany(Buku::class, 'id_kategori');
    }

    /**
     * Accessor untuk label kategori
     */
    public function getLabelAttribute(): string
    {
        return "{$this->kode_kategori} - {$this->nama_kategori}";
    }

    /**
     * Scope untuk kategori dengan buku tersedia
     */
    public function scopeMemilikiBuku($query)
    {
        return $query->whereHas('buku', function($q) {
            $q->where('status', 'Tersedia');
        });
    }

    /**
     * Scope untuk pencarian
     */
    public function scopeCari($query, string $keyword)
    {
        return $query->where('nama_kategori', 'like', "%{$keyword}%")
                    ->orWhere('kode_kategori', 'like', "%{$keyword}%");
    }
}
