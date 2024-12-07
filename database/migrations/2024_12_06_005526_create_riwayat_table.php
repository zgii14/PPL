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
        Schema::create('riwayats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('paket_id');
            $table->float('jumlah');
            $table->decimal('total_harga', 15, 2);
            $table->string('status');
            $table->string('pembayaran_status');
            $table->timestamps();

            // Definisi foreign key
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('paket_id')->references('id')->on('paket_laundry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayats');
    }
};
