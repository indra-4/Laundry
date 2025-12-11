<?php
// ========================================
// FILE 3: app/Models/Pesanan.php
// ========================================
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pesanan';
    protected $primaryKey = 'pesanan_id';

    protected $fillable = [
        'pelanggan_id',
        'kode_booking',
        'layanan_id',
        'estimasi_berat',
        'berat_aktual',
        'metode_antar',
        'alamat_jemput',
        'catatan',
        'estimasi_harga',
        'harga_final',
        'status',
    ];

    protected $casts = [
        'estimasi_berat' => 'decimal:2',
        'berat_aktual' => 'decimal:2',
        'estimasi_harga' => 'decimal:2',
        'harga_final' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->kode_booking)) {
                $model->kode_booking = 'AWN-' . strtoupper(substr(uniqid(), -8));
            }
        });
    }

    // Relations
    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id', 'layanan_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'pesanan_id', 'pesanan_id');
    }

    public function penjemputan()
    {
        return $this->hasOne(Penjemputan::class, 'pesanan_id', 'pesanan_id');
    }

    public function pengantaran()
    {
        return $this->hasOne(Pengantaran::class, 'pesanan_id', 'pesanan_id');
    }

    public function proses()
    {
        return $this->hasMany(Proses::class, 'pesanan_id', 'pesanan_id');
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPelanggan($query, $pelangganId)
    {
        return $query->where('pelanggan_id', $pelangganId);
    }

    // Helper Methods
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'secondary',
            'menunggu_penjemputan' => 'info',
            'dijemput' => 'primary',
            'ditimbang' => 'primary',
            'dicuci' => 'warning',
            'dikeringkan' => 'warning',
            'disetrika' => 'warning',
            'dikemas' => 'warning',
            'siap_antar' => 'info',
            'diantar' => 'primary',
            'selesai' => 'success',
            'dibatalkan' => 'danger',
        ];

        return $badges[$this->status] ?? 'secondary';
    }
}
