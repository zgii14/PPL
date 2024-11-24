<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PaketLaundry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder untuk admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'), // Hash the admin password
            'role' => 'admin',
        ]);

        // Seeder untuk staff user
        User::create([
            'name' => 'Staff',
            'email' => 'staff@example.com',
            'password' => Hash::make('staff123'),
            'role' => 'staff',
        ]);

        // Seeder untuk kurir user
        User::create([
            'name' => 'Kurir',
            'email' => 'kurir@example.com',
            'password' => Hash::make('kurir123'),
            'role' => 'kurir',
        ]);

        // Seeder untuk pelanggan user
        User::create([
            'name' => 'Pelanggan',
            'email' => 'pelanggan@example.com',
            'password' => Hash::make('pelanggan123'),
            'role' => 'pelanggan',
        ]);

        // Seeder untuk Paket Laundry
        $paketLaundry = [
            [
                'nama_paket' => 'Paket Cuci Lipat',
                'deskripsi' => 'Cuci pakaian dan dilipat rapi.',
                'harga' => 15000,
                'jenis' => 'Regular',
                'waktu' => '1 Hari', // Diubah menjadi 1 Hari
            ],
            [
                'nama_paket' => 'Paket Cuci Kering',
                'deskripsi' => 'Pakaian dicuci dan dikeringkan.',
                'harga' => 20000,
                'jenis' => 'Regular',
                'waktu' => '1 Hari', // Diubah menjadi 1 Hari
            ],
            [
                'nama_paket' => 'Paket Express Cuci Kering Lipat',
                'deskripsi' => 'Layanan express cuci, kering, dan lipat.',
                'harga' => 30000,
                'jenis' => 'Express',
                'waktu' => '6 Jam', // Tetap menggunakan 6 Jam untuk express
            ],
            [
                'nama_paket' => 'Paket Cuci Setrika',
                'deskripsi' => 'Pakaian dicuci dan disetrika.',
                'harga' => 25000,
                'jenis' => 'Regular',
                'waktu' => '1 Hari', // Diubah menjadi 1 Hari
            ],
            [
                'nama_paket' => 'Paket Premium',
                'deskripsi' => 'Layanan cuci, setrika, dan parfum khusus.',
                'harga' => 40000,
                'jenis' => 'Premium',
                'waktu' => '2 Hari', // Tetap menggunakan 2 Hari
            ],
        ];

        // Menambahkan paket laundry ke database
        foreach ($paketLaundry as $paket) {
            PaketLaundry::create($paket);
        }
    }
}
