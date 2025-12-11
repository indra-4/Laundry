<?php
// ========================================
// FILE: app/Http/Controllers/Pelanggan/DashboardController.php
// ========================================

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $pesananAktif = Pesanan::byPelanggan($user->id)
            ->whereNotIn('status', ['selesai', 'dibatalkan'])
            ->with('layanan')
            ->latest()
            ->take(5)
            ->get();
        
        $riwayatPesanan = Pesanan::byPelanggan($user->id)
            ->whereIn('status', ['selesai', 'dibatalkan'])
            ->with('layanan')
            ->latest()
            ->take(5)
            ->get();
        
        $totalPesanan = Pesanan::byPelanggan($user->id)->count();
        
        $notifikasi = $user->notifikasi()->unread()->latest()->take(5)->get();
        
        return view('pelanggan.dashboard', compact('pesananAktif', 'riwayatPesanan', 'totalPesanan', 'notifikasi'));
    }
}