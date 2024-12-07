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
        // Seeder for admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Seeder for staff user
        User::create([
            'name' => 'Staff',
            'email' => 'staff@example.com',
            'password' => Hash::make('staff123'),
            'role' => 'staff',
        ]);

        // Seeder for courier user
        User::create([
            'name' => 'Kurir',
            'email' => 'kurir@example.com',
            'password' => Hash::make('kurir123'),
            'role' => 'kurir',
        ]);

        // Seeder for customer user
        User::create([
            'name' => 'Pelanggan',
            'email' => 'pelanggan@example.com',
            'password' => Hash::make('pelanggan123'),
            'role' => 'pelanggan',
        ]);

        // Seeder for Paket Laundry
        $paketLaundry = [
            [
                'nama_paket' => 'Paket Cuci Lipat',
                'deskripsi' => 'Cuci pakaian dan dilipat rapi.',
                'harga' => 6000,
                'jenis' => 'Regular',
                'waktu' => 24, // Store as 24 hours (1 day)
            ],
            [
                'nama_paket' => 'Paket Cuci Kering',
                'deskripsi' => 'Pakaian dicuci dan dikeringkan.',
                'harga' => 5000,
                'jenis' => 'Regular',
                'waktu' => 24, // Store as 24 hours
            ],
            [
                'nama_paket' => 'Paket Express Cuci Kering Lipat',
                'deskripsi' => 'Layanan express cuci, kering, dan lipat.',
                'harga' => 8000,
                'jenis' => 'Express',
                'waktu' => 6,  // Store as 6 hours
            ],
            [
                'nama_paket' => 'Paket Cuci Setrika',
                'deskripsi' => 'Pakaian dicuci dan disetrika.',
                'harga' => 7000,
                'jenis' => 'Regular',
                'waktu' => 24, // Store as 24 hours
            ],
            [
                'nama_paket' => 'Paket Premium',
                'deskripsi' => 'Layanan cuci, setrika, dan parfum khusus.',
                'harga' => 10000,
                'jenis' => 'Premium',
                'waktu' => 10, // Store as 48 hours (2 days)
            ],
        ];

        // Insert paket laundry into the database
        foreach ($paketLaundry as $paket) {
            PaketLaundry::create($paket);
        }
    }
}
