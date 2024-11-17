<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// In terminal: php artisan make:model Order -m

// Order.php (Model)
class Pesanan extends Model
{
    protected $fillable = ['user_id', 'paket_id', 'status', 'jumlah', 'total_harga'];


    public function paket()
    {
        return $this->belongsTo(PaketLaundry::class, 'paket_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
