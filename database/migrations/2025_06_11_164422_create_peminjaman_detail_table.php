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
        Schema::create('peminjaman_detail', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_peminjaman');
            $table->unsignedBigInteger('id_buku');
            $table->date('tanggal_kembali')->nullable();
            $table->enum('status', ['Dipinjam', 'Dikembalikan', 'Terlambat'])->default('Dipinjam');
            $table->integer('denda')->default(0);
            $table->enum('denda_status', ['Belum Lunas', 'Lunas'])->default('Belum Lunas');
            $table->unsignedBigInteger('id_petugas_pengembalian')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('id_peminjaman')->references('id')->on('peminjaman')->onDelete('cascade');
            $table->foreign('id_buku')->references('id')->on('buku')->onDelete('cascade');

            /**
             * ✅ Foreign key untuk petugas pengembalian
             * onDelete('set null') = jika petugas dihapus, data pengembalian tetap ada
             */
            $table->foreign('id_petugas_pengembalian')->references('id')->on('petugas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_detail');
    }
};
