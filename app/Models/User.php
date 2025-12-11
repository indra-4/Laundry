<?php
// ========================================
// FILE 1: app/Models/User.php
// ========================================

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_hp',
        'alamat',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    // Relations
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'pelanggan_id');
    }

    public function penjemputan()
    {
        return $this->hasMany(Penjemputan::class, 'kurir_id');
    }

    public function pengantaran()
    {
        return $this->hasMany(Pengantaran::class, 'kurir_id');
    }

    public function proses()
    {
        return $this->hasMany(Proses::class, 'karyawan_id');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'user_id');
    }

    // Helper methods
    public function isPelanggan()
    {
        return $this->role === 'pelanggan';
    }

    public function isKaryawan()
    {
        return $this->role === 'karyawan';
    }

    public function isKurir()
    {
        return $this->role === 'kurir';
    }

    public function isPemilik()
    {
        return $this->role === 'pemilik';
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
