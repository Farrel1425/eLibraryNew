<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buku extends Model
{
     use HasFactory;

    /**
     * Kolom yang tidak bisa diisi massal (jika ada)
     * Kosongkan array untuk mengizinkan semua field
     */
    protected $guarded = [];

    /**
     * Nama tabel (opsional jika mengikuti konvensi)
     */
    protected $table = 'buku';

    /**
     * Relasi ke Kategori
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori_buku::class, 'id_kategori');
    }

    /**
     * Relasi ke Peminjaman
     */
    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'id_buku');
    }

    /**
     * Accessor untuk status buku
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'Tersedia' => '<span class="badge bg-success">Tersedia</span>',
            'Dipinjam' => '<span class="badge bg-warning">Dipinjam</span>',
            'Rusak'    => '<span class="badge bg-danger">Rusak</span>',
            'Hilang'   => '<span class="badge bg-secondary">Hilang</span>',
            default    => '<span class="badge bg-info">Unknown</span>'
        };
    }

    /**
     * Scope untuk buku tersedia
     */
    public function scopeTersedia($query)
    {
        return $query->where('status', 'Tersedia');
    }

    /**
     * Scope untuk pencarian buku
     */
    public function scopeCari($query, string $keyword)
    {
        return $query->where('judul', 'like', "%{$keyword}%")
                    ->orWhere('penulis', 'like', "%{$keyword}%")
                    ->orWhere('penerbit', 'like', "%{$keyword}%")
                    ->orWhereHas('kategori', function($q) use ($keyword) {
                        $q->where('nama_kategori', 'like', "%{$keyword}%");
                    });
    }

    /**
     * Mutator untuk judul buku
     */
    public function setJudulAttribute($value)
    {
        $this->attributes['judul'] = ucwords(strtolower($value));
    }
}
