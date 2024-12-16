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
            'phone' => '08123453789',
            'role' => 'staff',
        ]);

        // Seeder for courier user
        User::create([
            'name' => 'Kurir',
            'email' => 'kurir@example.com',
            'password' => Hash::make('kurir123'),
            'phone' => '08123456789',
            'role' => 'kurir',
        ]);

        // Seeder for customer user
        User::create([
            'name' => 'Diodo Arrahman',
            'email' => 'diodo@example.com',
            'password' => Hash::make('diodo123'),
            'phone' => '089624712374',
            'role' => 'pelanggan',
        ]);
        User::create([
            'name' => 'Ferdy Fitriansyah Rowi',
            'email' => 'ferdy@example.com',
            'password' => Hash::make('ferdy123'),
            'phone' => '089541322233',
            'role' => 'pelanggan',
        ]);
        User::create([
            'name' => 'Hanif Abdullah',
            'email' => 'hanif@example.com',
            'password' => Hash::make('hanif123'),
            'phone' => '089518065971',
            'role' => 'pelanggan',
        ]);
        User::create([
            'name' => 'Ulfa stevi juliana',
            'email' => 'ulfa@example.com',
            'password' => Hash::make('ulfa123'),
            'phone' => '082216395299',
            'role' => 'pelanggan',
        ]);
        User::create([
            'name' => 'Fiter ramadansyah',
            'email' => 'fiter@example.com',
            'password' => Hash::make('fiter123'),
            'phone' => '081532538031',
            'role' => 'pelanggan',
        ]);
        User::create([
            'name' => 'Revan averuz',
            'email' => 'revan@example.com',
            'password' => Hash::make('pelanggan123'),
            'phone' => '08985682000',
            'role' => 'pelanggan',
        ]);
        User::create([
            'name' => 'Reyvano Pulunggono',
            'email' => 'reyvano@example.com',
            'password' => Hash::make('reyvano123'),
            'phone' => '08123426789',
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
