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
         Schema::create('denda', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_peminjaman');
            $table->decimal('jumlah', 10, 2); // Format: total digits 10, decimal 2
            $table->date('tanggal_pembayaran')->nullable();
            $table->enum('status_denda', ['Belum Lunas', 'Lunas'])->default('Belum Lunas');
            $table->unsignedBigInteger('id_petugas')->nullable(); // Petugas yang mencatat
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_peminjaman')->references('id')->on('peminjaman')->onDelete('cascade');

            $table->foreign('id_petugas')->references('id')->on('petugas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denda');
    }
};
