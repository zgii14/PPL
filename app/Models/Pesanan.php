<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan'; // Nama tabel di database
    protected $fillable = ['user_id', 'paket_id', 'jumlah', 'total_harga', 'status']; // Kolom yang dapat diisi

    // Relasi ke model PaketLaundry
    public function paket()
    {
        return $this->belongsTo(PaketLaundry::class, 'paket_id');
    }

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getStatusLabelAttribute()
{
    $statuses = [
        1 => 'Penjemputan',
        2 => 'Cuci',
        3 => 'Kering',
        4 => 'Lipat',
        5 => 'Selesai',
        6 => 'Pengantaran',

    ];

    return $statuses[$this->status] ?? 'Unknown';
}

}
