<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Utama',
            'username' => 'admin1',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), // ganti password jika perlu
            'remember_token' => Str::random(10),
            'level_user' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ========== PETUGAS ==========
        $petugasUserId = DB::table('users')->insertGetId([
            'name' => 'Farrel',
            'username' => 'Farrel',
            'email' => 'petugas1@example.com',
            'password' => Hash::make('123123'), // password default
            'level_user' => 'petugas',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('petugas')->insert([
            'id_user' => $petugasUserId,
            'nama_petugas' => 'Farrel',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Petugas Nomor 1',
            'jenis_kelamin' => 'Laki-laki',
            'status' => 'Aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ========== ANGGOTA ==========
        $anggotaUserId = DB::table('users')->insertGetId([
            'name' => 'Putra',
            'username' => 'Putra',
            'email' => 'anggota1@example.com',
            'password' => Hash::make('123123'), // password default
            'level_user' => 'anggota',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('anggota')->insert([
            'id_user' => $anggotaUserId,
            'nis' => '220030060',
            'nama_anggota' => 'Putra',
            'no_hp' => '089876543210',
            'alamat' => 'Jl. Anggota Nomor 1',
            'jenis_kelamin' => 'Perempuan',
            'status_anggota' => 'Aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
