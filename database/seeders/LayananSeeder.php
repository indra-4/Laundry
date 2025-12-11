<?php
// ========================================
// FILE 3: database/seeders/LayananSeeder.php
// ========================================

namespace Database\Seeders;

use App\Models\Layanan;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        $layanan = [
            [
                'nama_layanan' => 'Cuci Kering Kiloan',
                'jenis' => 'kiloan',
                'harga_per_kg' => 5000,
                'harga_satuan' => null,
                'durasi_pengerjaan' => 3,
                'deskripsi' => 'Layanan cuci dan kering pakaian per kilogram',
                'status_aktif' => true,
            ],
            [
                'nama_layanan' => 'Cuci Kering Setrika Kiloan',
                'jenis' => 'kiloan',
                'harga_per_kg' => 7000,
                'harga_satuan' => null,
                'durasi_pengerjaan' => 3,
                'deskripsi' => 'Layanan cuci, kering, dan setrika per kilogram',
                'status_aktif' => true,
            ],
            [
                'nama_layanan' => 'Cuci Setrika Express',
                'jenis' => 'express',
                'harga_per_kg' => 10000,
                'harga_satuan' => null,
                'durasi_pengerjaan' => 1,
                'deskripsi' => 'Layanan express selesai dalam 1 hari',
                'status_aktif' => true,
            ],
            [
                'nama_layanan' => 'Setrika Saja',
                'jenis' => 'kiloan',
                'harga_per_kg' => 3000,
                'harga_satuan' => null,
                'durasi_pengerjaan' => 2,
                'deskripsi' => 'Layanan setrika saja per kilogram',
                'status_aktif' => true,
            ],
            [
                'nama_layanan' => 'Cuci Sepatu',
                'jenis' => 'satuan',
                'harga_per_kg' => null,
                'harga_satuan' => 25000,
                'durasi_pengerjaan' => 3,
                'deskripsi' => 'Layanan cuci sepatu per pasang',
                'status_aktif' => true,
            ],
            [
                'nama_layanan' => 'Cuci Bed Cover',
                'jenis' => 'satuan',
                'harga_per_kg' => null,
                'harga_satuan' => 35000,
                'durasi_pengerjaan' => 2,
                'deskripsi' => 'Layanan cuci bed cover per item',
                'status_aktif' => true,
            ],
        ];

        foreach ($layanan as $item) {
            Layanan::create($item);
        }
    }
}