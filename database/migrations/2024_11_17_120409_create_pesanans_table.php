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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_id')
                  ->constrained('paket_laundry') // Relasi ke tabel paket_laundry
                  ->onDelete('cascade'); // Hapus pesanan jika paket dihapus
            $table->foreignId('user_id')
                  ->constrained('users') // Relasi ke tabel users
                  ->onDelete('cascade'); // Hapus pesanan jika user dihapus
            $table->integer('jumlah'); // Jumlah barang/paket
            $table->integer('total_harga'); // Total harga pesanan
            $table->bigInteger('latitude'); // Latitude stored as integer (microdegrees)
            $table->bigInteger('longitude'); // Longitude stored as integer (microdegrees)

            // Status tahapan proses laundry (1: Cuci, 2: Kering, 3: Strika, 4: Siap, 5: Selesai)
            $table->tinyInteger('status')->default(1)->comment('1: Proses, 2: Dijemput , 3: Cuci, 4:Lipat , 5: Diantar, 6: Selesai');
            
            // Menambahkan kolom keterangan untuk mencatat pilihan "Dijemput" atau "Diambil"
            $table->enum('keterangan', ['Diantar', 'Diambil','Diambil Sendiri'])->default('Diambil'); // Pilihan default: Diambil

            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
