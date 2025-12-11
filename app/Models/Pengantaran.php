<?php
// ========================================
// FILE 6: app/Models/Pengantaran.php
// ========================================
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengantaran extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pengantaran';
    protected $primaryKey = 'pengantaran_id';

    protected $fillable = [
        'pesanan_id',
        'kurir_id',
        'alamat',
        'tanggal_antar',
        'status',
        'latitude',
        'longitude',
        'catatan',
    ];

    protected $casts = [
        'tanggal_antar' => 'datetime',
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
