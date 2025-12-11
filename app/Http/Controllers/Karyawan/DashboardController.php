<?php
// ========================================
// FILE: app/Http/Controllers/Karyawan/DashboardController.php
// ========================================

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $pesananBaru = Pesanan::whereIn('status', ['pending', 'dijemput', 'menunggu_penjemputan'])
            ->with('layanan', 'pelanggan')
            ->latest()
            ->take(10)
            ->get();
        
        $pesananDiproses = Pesanan::whereIn('status', ['ditimbang', 'dicuci', 'dikeringkan', 'disetrika', 'dikemas'])
            ->with('layanan', 'pelanggan')
            ->latest()
            ->take(10)
            ->get();
        
        $statistik = [
            'pending' => Pesanan::where('status', 'pending')->count(),
            'diproses' => Pesanan::whereIn('status', ['dicuci', 'dikeringkan', 'disetrika'])->count(),
            'siap_antar' => Pesanan::where('status', 'siap_antar')->count(),
            'selesai_hari_ini' => Pesanan::where('status', 'selesai')
                ->whereDate('updated_at', today())
                ->count(),
        ];
        
        return view('karyawan.dashboard', compact('pesananBaru', 'pesananDiproses', 'statistik'));
    }
}