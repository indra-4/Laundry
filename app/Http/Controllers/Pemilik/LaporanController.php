<?php
// ========================================
// FILE: app/Http/Controllers/Pemilik/LaporanController.php
// ========================================

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $jenis = $request->get('jenis', 'harian');
        $tanggalAwal = $request->get('tanggal_awal', now()->startOfMonth()->format('Y-m-d'));
        $tanggalAkhir = $request->get('tanggal_akhir', now()->format('Y-m-d'));

        // Data Laporan
        $pesanan = Pesanan::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
            ->with(['pelanggan', 'layanan'])
            ->get();

        $totalPesanan = $pesanan->count();
        $totalPendapatan = $pesanan->where('status', 'selesai')->sum('harga_final');
        $pesananSelesai = $pesanan->where('status', 'selesai')->count();
        $pesananDibatalkan = $pesanan->where('status', 'dibatalkan')->count();

        // Grafik per Layanan
        $perLayanan = $pesanan->groupBy('layanan_id')->map(function($items) {
            return [
                'layanan' => $items->first()->layanan->nama_layanan,
                'total' => $items->count(),
                'pendapatan' => $items->where('status', 'selesai')->sum('harga_final'),
            ];
        });

        // Grafik Harian
        $perHari = $pesanan->groupBy(function($item) {
            return $item->created_at->format('Y-m-d');
        })->map(function($items, $date) {
            return [
                'tanggal' => $date,
                'total' => $items->count(),
                'pendapatan' => $items->where('status', 'selesai')->sum('harga_final'),
            ];
        });

        return view('pemilik.laporan.index', compact(
            'jenis',
            'tanggalAwal',
            'tanggalAkhir',
            'totalPesanan',
            'totalPendapatan',
            'pesananSelesai',
            'pesananDibatalkan',
            'perLayanan',
            'perHari',
            'pesanan'
        ));
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'jenis_laporan' => 'required|in:harian,mingguan,bulanan,tahunan',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
        ]);

        $pesanan = Pesanan::whereBetween('created_at', [
            $validated['periode_awal'],
            $validated['periode_akhir']
        ])->get();

        $laporan = Laporan::create([
            'jenis_laporan' => $validated['jenis_laporan'],
            'periode_awal' => $validated['periode_awal'],
            'periode_akhir' => $validated['periode_akhir'],
            'total_pesanan' => $pesanan->count(),
            'total_pendapatan' => $pesanan->where('status', 'selesai')->sum('harga_final'),
            'tanggal_generate' => now(),
        ]);

        return back()->with('success', 'Laporan berhasil digenerate!');
    }

    public function export(Request $request, $jenis)
    {
        $tanggalAwal = $request->get('tanggal_awal', now()->startOfMonth()->format('Y-m-d'));
        $tanggalAkhir = $request->get('tanggal_akhir', now()->format('Y-m-d'));

        $pesanan = Pesanan::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
            ->with(['pelanggan', 'layanan'])
            ->get();

        if ($jenis === 'pdf') {
            // Untuk sederhananya, kita redirect ke print view
            return view('pemilik.laporan.print', compact('pesanan', 'tanggalAwal', 'tanggalAkhir'));
        }

        // Export CSV
        $filename = "laporan_" . now()->format('YmdHis') . ".csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($pesanan) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Kode Booking', 'Pelanggan', 'Layanan', 'Status', 'Harga', 'Tanggal']);
            
            foreach ($pesanan as $p) {
                fputcsv($file, [
                    $p->kode_booking,
                    $p->pelanggan->nama,
                    $p->layanan->nama_layanan,
                    $p->status,
                    $p->harga_final ?? $p->estimasi_harga,
                    $p->created_at->format('d/m/Y'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}