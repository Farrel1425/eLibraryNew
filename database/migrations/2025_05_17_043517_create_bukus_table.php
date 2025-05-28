<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kategori');
            $table->string('judul');
            $table->string('penulis', 50);
            $table->string('penerbit', 50);
            $table->integer('tahun_terbit');
            $table->integer('stok')->default(1);
            $table->enum('status_buku', ['Tersedia', 'Tidak Tersedia'])->default('Tersedia');
            $table->timestamps();

            // Foreign key
            $table->foreign('id_kategori')->references('id')->on('kategori')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
