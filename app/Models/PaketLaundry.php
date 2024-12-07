<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketLaundry extends Model
{
    use HasFactory;

    protected $table = 'paket_laundry';

    protected $fillable = [
        'nama_paket', 'deskripsi', 'harga', 'jenis', 'waktu'
    ];

    /**
     * Get the formatted 'waktu' (duration).
     */
    public function getWaktuFormattedAttribute()
    {
        $waktu = $this->waktu;

        // If the waktu is greater than or equal to 24, show it as days
        if ($waktu >= 24) {
            $days = intdiv($waktu, 24); // Calculate number of full days
            $hours = $waktu % 24; // Calculate remaining hours
            if ($hours > 0) {
                return "{$days} Hari {$hours} Jam";  // Show as days and hours
            }
            return "{$days} Hari";  // Show only days if there are no remaining hours
        }

        // If the waktu is less than 24 hours, show it as hours
        return "{$waktu} Jam";  // Show as hours
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'paket_id');
    }
    public function riwayat()
    {
        return $this->hasMany(Riwayat::class, 'paket_id');
    }
}
