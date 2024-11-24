<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketLaundry extends Model
{
    use HasFactory;

    protected $table = 'paket_laundry';

    protected $fillable = [
        'nama_paket',
        'deskripsi',  // Pastikan deskripsi ada di sini
        'harga',
        'jenis',
        'waktu',  // Tambahkan kolom waktu agar bisa disimpan
    ];
}
