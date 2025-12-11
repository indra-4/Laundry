<?php
// ========================================
// FILE: app/Http/Controllers/Kurir/PengantaranController.php
// ========================================

namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use App\Models\Pengantaran;
use App\Models\Pesanan;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengantaranController extends Controller
{
    public function index(Request $request)
    {
        // Ambil pesanan dengan status siap_antar yang belum punya pengantaran record
        $pesananSiapAntar = Pesanan::where('status', 'siap_antar')
            ->whereDoesntHave('pengantaran')
            ->with('pelanggan')
            ->get();

        // Buat pengantaran record untuk pesanan yang belum punya
        foreach ($pesananSiapAntar as $pesanan) {
            $alamatAntar = $pesanan->alamat_jemput ?? $pesanan->pelanggan->alamat ?? 'Alamat tidak tersedia';
            
            Pengantaran::create([
                'pesanan_id' => $pesanan->pesanan_id,
                'alamat' => $alamatAntar,
                'status' => 'dijadwalkan',
            ]);
        }

        $query = Pengantaran::with('pesanan.pelanggan');
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->whereIn('status', ['dijadwalkan', 'dalam_perjalanan']);
        }
        
        $query->where(function($q) {
            $q->where('kurir_id', auth()->id())
              ->orWhereNull('kurir_id');
        });
        
        $pengantaran = $query->latest()->paginate(15);
        
        return view('kurir.pengantaran.index', compact('pengantaran'));
    }

    public function show($id)
    {
        $pengantaran = Pengantaran::with('pesanan.pelanggan')
            ->where(function($q) {
                $q->where('kurir_id', auth()->id())
                  ->orWhereNull('kurir_id');
            })
            ->findOrFail($id);
        
        return view('kurir.pengantaran.show', compact('pengantaran'));
    }

    public function mulai(Request $request, $id)
    {
        $pengantaran = Pengantaran::findOrFail($id);
        
        DB::beginTransaction();
        try {
            $pengantaran->update([
                'kurir_id' => auth()->id(),
                'status' => 'dalam_perjalanan',
                'tanggal_antar' => now(),
            ]);

            $pengantaran->pesanan->update(['status' => 'diantar']);

            Notifikasi::create([
                'user_id' => $pengantaran->pesanan->pelanggan_id,
                'judul' => 'Cucian Sedang Diantar',
                'pesan' => "Kurir sedang mengantar cucian Anda. Pesanan: {$pengantaran->pesanan->kode_booking}",
                'tipe' => 'info',
            ]);

            DB::commit();

            return back()->with('success', 'Pengantaran dimulai!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memulai pengantaran: ' . $e->getMessage());
        }
    }

    public function selesai(Request $request, $id)
    {
        $validated = $request->validate([
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'catatan' => 'nullable|string',
        ]);

        $pengantaran = Pengantaran::where('kurir_id', auth()->id())->findOrFail($id);
        
        DB::beginTransaction();
        try {
            $pengantaran->update([
                'status' => 'selesai',
                'latitude' => $validated['latitude'] ?? null,
                'longitude' => $validated['longitude'] ?? null,
                'catatan' => $validated['catatan'] ?? null,
            ]);

            $pengantaran->pesanan->update(['status' => 'selesai']);

            Notifikasi::create([
                'user_id' => $pengantaran->pesanan->pelanggan_id,
                'judul' => 'Pesanan Selesai',
                'pesan' => "Cucian Anda telah diantar. Terima kasih telah menggunakan layanan Awan Laundry!",
                'tipe' => 'success',
            ]);

            DB::commit();

            return redirect()->route('kurir.pengantaran.index')->with('success', 'Pengantaran selesai!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyelesaikan pengantaran: ' . $e->getMessage());
        }
    }
}