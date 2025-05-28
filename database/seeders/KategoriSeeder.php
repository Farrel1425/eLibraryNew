<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori_buku;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [
            ['nama_kategori' => 'Fiksi', 'deskripsi' => 'Cerita rekaan'],
            ['nama_kategori' => 'Sains', 'deskripsi' => 'Buku-buku ilmiah'],
            ['nama_kategori' => 'Sejarah', 'deskripsi' => 'Buku sejarah'],
            ['nama_kategori' => 'Teknologi', 'deskripsi' => 'Buku teknologi & komputer'],
        ];

        foreach ($kategori as $kat) {
            Kategori_buku::create($kat);
        }
    }
}
