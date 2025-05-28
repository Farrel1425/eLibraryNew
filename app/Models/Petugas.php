<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Petugas extends Model
{
    use HasFactory;

    /**
     * 
     * 
     */
    protected $fillable = [
    'id_user',
    'nama_petugas',
    'no_hp',
    'alamat',
    'jenis_kelamin',
    'status',
    ];

    /**
     * Nama tabel (opsional jika mengikuti konvensi Laravel)
     */
    protected $table = 'petugas';

    /**
     * Relasi ke User (1 petugas dimiliki oleh 1 user)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    /**
     * Relasi ke Peminjaman (1 petugas menangani banyak peminjaman)
     */
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_petugas');
    }

    /**
     * Accessor untuk nama petugas dengan gelar
     */
    public function getNamaFormalAttribute()
    {
        return "Petugas {$this->nama_petugas}";
    }

    /**
     * Scope untuk petugas aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif');
    }

    /**
     * Scope untuk pencarian petugas
     */
    public function scopeCari($query, string $keyword)
    {
        return $query->where('nama_petugas', 'like', "%{$keyword}%")
                    ->orWhere('no_hp', 'like', "%{$keyword}%");
    }
}
