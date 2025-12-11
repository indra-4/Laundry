<?php
// ========================================
// FILE 5: app/Models/Penjemputan.php
// ========================================
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjemputan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'penjemputan';
    protected $primaryKey = 'penjemputan_id';

    protected $fillable = [
        'pesanan_id',
        'kurir_id',
        'alamat',
        'tanggal_jemput',
        'status',
        'latitude',
        'longitude',
        'catatan',
    ];

    protected $casts = [
        'tanggal_jemput' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id', 'pesanan_id');
    }

    public function kurir()
    {
        return $this->belongsTo(User::class, 'kurir_id');
    }
}