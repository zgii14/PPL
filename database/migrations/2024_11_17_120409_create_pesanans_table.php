<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_id')
                  ->constrained('paket_laundry') // Menunjuk kolom 'id' pada tabel paket_laundries
                  ->onDelete('cascade'); // Menghapus pesanan jika paket yang terkait dihapus
            $table->integer('jumlah'); // Kolom untuk jumlah pesanan
            $table->integer('total_harga'); // Kolom untuk harga total
            $table->timestamps();
        });
    }
    

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
