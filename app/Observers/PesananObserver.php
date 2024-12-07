<?php

namespace App\Observers;

use App\Models\Pesanan;
use App\Models\Riwayat;

class PesananObserver
{
    public function updated(Pesanan $pesanan)
    {
        // Cek apakah pesanan sudah selesai dan pembayaran berhasil
        if ($pesanan->status == 6 && $pesanan->pembayaran && $pesanan->pembayaran->status == 'berhasil') {
            Riwayat::create([
                'user_id' => $pesanan->user_id,
                'paket_id' => $pesanan->paket_id,
                'jumlah' => $pesanan->jumlah,
                'total_harga' => $pesanan->total_harga,
                'status' => 'Selesai',
                'pembayaran_status' => $pesanan->pembayaran->status,
            ]);
        }
        
    }
}
