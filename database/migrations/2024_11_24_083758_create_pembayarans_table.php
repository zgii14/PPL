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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')
                  ->constrained('pesanan') // Relasi ke tabel pesanan
                  ->onDelete('cascade'); // Hapus pesanan jika pembayaran dihapus
            $table->integer('nominal');
            $table->enum('metode_pembayaran', ['transfer', 'cash']);
            $table->string('bukti_bayar')->nullable();
            $table->enum('status', ['proses', 'berhasil', 'gagal'])->default('proses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
