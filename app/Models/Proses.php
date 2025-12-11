<?php
// ========================================
// FILE 7: app/Models/Proses.php
// ========================================
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proses extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'proses';
    protected $primaryKey = 'proses_id';

    protected $fillable = [
        'pesanan_id',
        'karyawan_id',
        'tahapan',
        'status_checklist',
        'waktu_mulai',
        'waktu_selesai',
        'catatan',
    ];

    protected $casts = [
        'status_checklist' => 'boolean',
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id', 'pesanan_id');
    }

    public function karyawan()
    {
        return $this->belongsTo(User::class, 'karyawan_id');
    }
}