<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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
    public function getBuktiBayarAttribute($value)
    {
        // Check if the file exists and generate the URL
        if ($value) {
            // If using the 'public' disk, return the URL
            return Storage::url($value); // This will generate the correct URL for the file
        }

        // If no file exists, return a default image or null
        return null; // Or a default image URL
    }
}
