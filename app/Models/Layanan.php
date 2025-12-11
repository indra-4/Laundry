<?php
// ========================================
// FILE 2: app/Models/Layanan.php
// ========================================
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';
    protected $primaryKey = 'layanan_id';

    protected $fillable = [
        'nama_layanan',
        'jenis',
        'harga_per_kg',
        'harga_satuan',
        'durasi_pengerjaan',
        'deskripsi',
        'status_aktif',
    ];

    protected $casts = [
        'harga_per_kg' => 'decimal:2',
        'harga_satuan' => 'decimal:2',
        'status_aktif' => 'boolean',
    ];

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'layanan_id', 'layanan_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }

    public function getHargaAttribute()
    {
        return $this->jenis === 'kiloan' ? $this->harga_per_kg : $this->harga_satuan;
    }
}