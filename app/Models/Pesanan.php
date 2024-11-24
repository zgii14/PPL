<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan'; // Nama tabel di database
    protected $fillable = [
        'user_id',
        'paket_id',
        'jumlah',
        'total_harga',
        'status',
        'latitude',   // Added latitude
        'longitude'   // Added longitude
    ]; // Kolom yang dapat diisi

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

    // Relasi ke model Pembayaran
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    // Status Label Accessor
    public function getStatusLabelAttribute()
    {
        $statuses = [
            1 => 'Penjemputan',
            2 => 'Cuci',
            3 => 'Kering',
            4 => 'Lipat',
            5 => 'Pengantaran',
            6 => 'Selesai',
        ];

        return $statuses[$this->status] ?? 'Unknown';
    }

    // Accessor to get latitude as a float
    public function getLatitudeAttribute($value)
    {
        return $value / 1000000; // Convert microdegrees back to float
    }

    // Accessor to get longitude as a float
    public function getLongitudeAttribute($value)
    {
        return $value / 1000000; // Convert microdegrees back to float
    }

    // Mutator to set latitude as an integer (microdegrees)
    public function setLatitudeAttribute($value)
    {
        $this->attributes['latitude'] = (int) ($value * 1000000); // Store as integer (microdegrees)
    }

    // Mutator to set longitude as an integer (microdegrees)
    public function setLongitudeAttribute($value)
    {
        $this->attributes['longitude'] = (int) ($value * 1000000); // Store as integer (microdegrees)
    }
}
