<?php
// ========================================
// FILE 2: database/seeders/UserSeeder.php
// ========================================

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Pemilik
        User::create([
            'nama' => 'Pemilik Awan Laundry',
            'email' => 'pemilik@awanlaundry.com',
            'password' => Hash::make('password123'),
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Raya Lohbener, Indramayu',
            'role' => 'pemilik',
            'is_active' => true,
        ]);

        // Karyawan
        User::create([
            'nama' => 'Budi Santoso',
            'email' => 'karyawan@awanlaundry.com',
            'password' => Hash::make('password123'),
            'no_hp' => '081234567891',
            'alamat' => 'Indramayu',
            'role' => 'karyawan',
            'is_active' => true,
        ]);

        // Kurir
        User::create([
            'nama' => 'Andi Kurniawan',
            'email' => 'kurir@awanlaundry.com',
            'password' => Hash::make('password123'),
            'no_hp' => '081234567892',
            'alamat' => 'Indramayu',
            'role' => 'kurir',
            'is_active' => true,
        ]);

        // Pelanggan Demo
        User::create([
            'nama' => 'Siti Nurhaliza',
            'email' => 'pelanggan@example.com',
            'password' => Hash::make('password123'),
            'no_hp' => '081234567893',
            'alamat' => 'Jl. Merdeka No. 123, Indramayu',
            'role' => 'pelanggan',
            'is_active' => true,
        ]);
    }
}