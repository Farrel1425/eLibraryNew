<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Buku;
use App\Models\Kategori_buku;

class BukuSeeder extends Seeder
{
   public function run(): void
    {
        $kategoriList = Kategori_buku::all();

        foreach ($kategoriList as $kategori) {
            for ($i = 1; $i <= 5; $i++) {
                Buku::create([
                    'judul'         => $kategori->nama_kategori . ' Book ' . $i,
                    'penulis'       => 'Penulis ' . $i,
                    'penerbit'      => 'Penerbit ' . $i,
                    'tahun_terbit'  => rand(2000, 2023),
                    'stok'          => rand(1, 10),
                    'id_kategori'   => $kategori->id,
                    'status_buku'   => 'Tersedia',
                ]);
            }

            // Setelah menambah buku, update jumlah_buku di kategori
            $kategori->update(['jumlah_buku' => $kategori->buku()->count()]);
        }
    }
}
