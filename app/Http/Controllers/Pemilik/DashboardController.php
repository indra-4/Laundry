<?php
// ========================================
// FILE: app/Http/Controllers/Pemilik/DashboardController.php
// ========================================

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Umum
        $statistik = [
            'total_pesanan_bulan_ini' => Pesanan::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'total_pendapatan_bulan_ini' => Pesanan::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->where('status', 'selesai')
                ->sum('harga_final'),
            'pesanan_hari_ini' => Pesanan::whereDate('created_at', today())->count(),
            'pelanggan_aktif' => User::where('role', 'pelanggan')
                ->where('is_active', true)
                ->count(),
        ];

        // Pesanan Terbaru
        $pesananTerbaru = Pesanan::with(['pelanggan', 'layanan'])
            ->latest()
            ->take(10)
            ->get();

        // Status Pesanan
        $statusPesanan = Pesanan::select('status', DB::raw('count(*) as total'))
            ->whereNotIn('status', ['selesai', 'dibatalkan'])
            ->groupBy('status')
            ->get();

        // Grafik Pendapatan 7 hari terakhir
        $pendapatanHarian = Pesanan::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(harga_final) as total')
            )
            ->where('status', 'selesai')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Top Layanan
        $topLayanan = Pesanan::select('layanan_id', DB::raw('count(*) as total'))
            ->whereMonth('created_at', now()->month)
            ->groupBy('layanan_id')
            ->with('layanan')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        return view('pemilik.dashboard', compact(
            'statistik',
            'pesananTerbaru',
            'statusPesanan',
            'pendapatanHarian',
            'topLayanan'
        ));
    }

    public function pesanan(Request $request)
    {
        $query = Pesanan::with(['pelanggan', 'layanan', 'pembayaran']);
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('created_at', '>=', $request->tanggal_dari);
        }
        
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_sampai);
        }
        
        $pesanan = $query->latest()->paginate(20);
        
        return view('pemilik.pesanan.index', compact('pesanan'));
    }
}