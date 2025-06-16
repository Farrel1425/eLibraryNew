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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_anggota');
            $table->unsignedBigInteger('id_petugas');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_harus_kembali');
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_anggota')->references('id')->on('anggota')->onDelete('cascade');
            $table->foreign('id_petugas')->references('id')->on('users')->onDelete('restrict');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
