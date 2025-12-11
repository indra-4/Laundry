<?php
// ========================================
// FILE: app/Http/Controllers/Kurir/PenjemputanController.php
// ========================================

namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use App\Models\Penjemputan;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjemputanController extends Controller
{
    public function index(Request $request)
    {
        $query = Penjemputan::with('pesanan.pelanggan');
        
        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->whereIn('status', ['dijadwalkan', 'dalam_perjalanan']);
        }
        
        // Tampilkan tugas kurir sendiri atau yang belum diambil
        $query->where(function($q) {
            $q->where('kurir_id', auth()->id())
              ->orWhereNull('kurir_id');
        });
        
        $penjemputan = $query->latest()->paginate(15);
        
        return view('kurir.penjemputan.index', compact('penjemputan'));
    }

    public function show($id)
    {
        $penjemputan = Penjemputan::with('pesanan.pelanggan')
            ->where(function($q) {
                $q->where('kurir_id', auth()->id())
                  ->orWhereNull('kurir_id');
            })
            ->findOrFail($id);
        
        return view('kurir.penjemputan.show', compact('penjemputan'));
    }

    public function mulai(Request $request, $id)
    {
        $penjemputan = Penjemputan::findOrFail($id);
        
        DB::beginTransaction();
        try {
            $penjemputan->update([
                'kurir_id' => auth()->id(),
                'status' => 'dalam_perjalanan',
                'tanggal_jemput' => now(),
            ]);

            // Update status pesanan
            $penjemputan->pesanan->update(['status' => 'menunggu_penjemputan']);

            // Notifikasi ke pelanggan
            Notifikasi::create([
                'user_id' => $penjemputan->pesanan->pelanggan_id,
                'judul' => 'Kurir Dalam Perjalanan',
                'pesan' => "Kurir sedang menuju lokasi Anda untuk menjemput cucian. Pesanan: {$penjemputan->pesanan->kode_booking}",
                'tipe' => 'info',
            ]);

            DB::commit();

            return back()->with('success', 'Penjemputan dimulai! Segera menuju lokasi pelanggan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memulai penjemputan: ' . $e->getMessage());
        }
    }

    public function selesai(Request $request, $id)
    {
        $validated = $request->validate([
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'catatan' => 'nullable|string',
        ]);

        $penjemputan = Penjemputan::where('kurir_id', auth()->id())->findOrFail($id);
        
        DB::beginTransaction();
        try {
            $penjemputan->update([
                'status' => 'selesai',
                'latitude' => $validated['latitude'] ?? null,
                'longitude' => $validated['longitude'] ?? null,
                'catatan' => $validated['catatan'] ?? null,
            ]);

            // Update status pesanan
            $penjemputan->pesanan->update(['status' => 'dijemput']);

            // Notifikasi ke pelanggan dan karyawan
            Notifikasi::create([
                'user_id' => $penjemputan->pesanan->pelanggan_id,
                'judul' => 'Cucian Berhasil Dijemput',
                'pesan' => "Cucian Anda telah dijemput. Pesanan: {$penjemputan->pesanan->kode_booking}",
                'tipe' => 'success',
            ]);

            $karyawan = \App\Models\User::whereIn('role', ['karyawan', 'pemilik'])->get();
            foreach ($karyawan as $user) {
                Notifikasi::create([
                    'user_id' => $user->id,
                    'judul' => 'Cucian Tiba',
                    'pesan' => "Cucian pesanan {$penjemputan->pesanan->kode_booking} telah tiba. Silakan timbang.",
                    'tipe' => 'info',
                ]);
            }

            DB::commit();

            return redirect()->route('kurir.penjemputan.index')->with('success', 'Penjemputan selesai!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyelesaikan penjemputan: ' . $e->getMessage());
        }
    }
}