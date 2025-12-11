<?php
// ========================================
// FILE: app/Http/Controllers/Kurir/DashboardController.php
// ========================================

namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use App\Models\Penjemputan;
use App\Models\Pengantaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $penjemputanHariIni = Penjemputan::where('kurir_id', auth()->id())
            ->orWhere(function($q) {
                $q->whereNull('kurir_id')
                  ->whereIn('status', ['dijadwalkan']);
            })
            ->whereDate('created_at', today())
            ->with('pesanan.pelanggan')
            ->latest()
            ->take(10)
            ->get();
        
        $pengantaranHariIni = Pengantaran::where('kurir_id', auth()->id())
            ->orWhere(function($q) {
                $q->whereNull('kurir_id')
                  ->whereIn('status', ['dijadwalkan']);
            })
            ->whereDate('created_at', today())
            ->with('pesanan.pelanggan')
            ->latest()
            ->take(10)
            ->get();
        
        $statistik = [
            'penjemputan_pending' => Penjemputan::where('status', 'dijadwalkan')->count(),
            'penjemputan_selesai_hari_ini' => Penjemputan::where('kurir_id', auth()->id())
                ->where('status', 'selesai')
                ->whereDate('updated_at', today())
                ->count(),
            'pengantaran_pending' => Pengantaran::where('status', 'dijadwalkan')->count(),
            'pengantaran_selesai_hari_ini' => Pengantaran::where('kurir_id', auth()->id())
                ->where('status', 'selesai')
                ->whereDate('updated_at', today())
                ->count(),
        ];
        
        return view('kurir.dashboard', compact('penjemputanHariIni', 'pengantaranHariIni', 'statistik'));
    }
}
