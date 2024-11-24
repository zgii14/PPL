<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    // Menentukan tabel yang digunakan oleh model ini
    protected $table = 'pembayarans';

    // Menentukan kolom yang dapat diisi
    protected $fillable = [
        'pesanan_id', 
        'nominal', 
        'metode_pembayaran', 
        'bukti_bayar', 
        'status'
    ];

    // Menentukan relasi dengan model Pesanan (one-to-one)
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    // Untuk mempermudah penanganan status pembayaran
    public function getStatusLabelAttribute()
    {
        $statusLabels = [
            'proses' => 'Proses',
            'berhasil' => 'Berhasil',
            'gagal' => 'Gagal',
        ];

        return $statusLabels[$this->status] ?? 'Status Tidak Dikenal';
    }
}
