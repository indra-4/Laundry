<?php
// ========================================
// FILE 8: app/Models/Laporan.php
// ========================================
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'laporan';
    protected $primaryKey = 'laporan_id';

    protected $fillable = [
        'jenis_laporan',
        'periode_awal',
        'periode_akhir',
        'total_pesanan',
        'total_pendapatan',
        'tanggal_generate',
    ];

    protected $casts = [
        'periode_awal' => 'date',
        'periode_akhir' => 'date',
        'total_pendapatan' => 'decimal:2',
        'tanggal_generate' => 'datetime',
    ];
}