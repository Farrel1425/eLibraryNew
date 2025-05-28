<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name', 'username', 'email', 'email_verified_at', 'password', 'level_user'
    ];

    public $timestamps = true;

    public function anggota()
    {
        return $this->hasOne(Anggota::class, 'id_user', 'id');
    }

    public function petugas()
    {
        return $this->hasOne(Petugas::class, 'id_user', 'id');
    }
}
