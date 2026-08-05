<?php

// ========================================
// FILE: app/Http/Controllers/Karyawan/PesananController.php
// ========================================

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Notifikasi;
use App\Models\Proses;
use App\Models\Pengantaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $query = Pesanan::with(['layanan', 'pelanggan', 'pembayaran']);
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('kode_booking', 'like', '%' . $request->search . '%')
                  ->orWhereHas('pelanggan', function($q2) use ($request) {
                      $q2->where('nama', 'like', '%' . $request->search . '%');
                  });
            });
        }
        
        $pesanan = $query->latest()->paginate(15);
        
        return view('karyawan.pesanan.index', compact('pesanan'));
    }

    public function show($id)
    {
        $pesanan = Pesanan::with(['layanan', 'pelanggan', 'pembayaran', 'penjemputan', 'proses.karyawan'])
            ->findOrFail($id);
        
        return view('karyawan.pesanan.show', compact('pesanan'));
    }

    public function timbang(Request $request, $id)
    {
        $validated = $request->validate([
            'berat_aktual' => 'required|numeric|min:0.1',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        
        DB::beginTransaction();
        try {
            // Hitung harga final
            $layanan = $pesanan->layanan;
            $hargaFinal = $layanan->jenis === 'kiloan' 
                ? $layanan->harga_per_kg * $validated['berat_aktual']
                : $layanan->harga_satuan * $validated['berat_aktual'];

            // Update pesanan
            $pesanan->update([
                'berat_aktual' => $validated['berat_aktual'],
                'harga_final' => $hargaFinal,
                'status' => 'ditimbang',
            ]);

            // Buat checklist proses
            $tahapan = ['pencucian', 'pengeringan', 'penyetrikaan', 'pengemasan'];
            foreach ($tahapan as $tahap) {
                Proses::create([
                    'pesanan_id' => $pesanan->pesanan_id,
                    'karyawan_id' => auth()->id(),
                    'tahapan' => $tahap,
                    'status_checklist' => false,
                ]);
            }

            // Notifikasi ke pelanggan
            Notifikasi::create([
                'user_id' => $pesanan->pelanggan_id,
                'judul' => 'Cucian Ditimbang',
                'pesan' => "Cucian Anda telah ditimbang. Berat: {$validated['berat_aktual']} kg, Total: Rp " . number_format($hargaFinal, 0, ',', '.'),
                'tipe' => 'info',
            ]);

            DB::commit();

            return back()->with('success', 'Berat cucian berhasil diinput. Harga final: Rp ' . number_format($hargaFinal, 0, ',', '.'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal input berat: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:dicuci,dikeringkan,disetrika,dikemas,siap_antar,diantar,selesai,dibatalkan',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        
        DB::beginTransaction();
        try {
            $pesanan->update(['status' => $validated['status']]);

            // Jika status menjadi siap_antar, buat record pengantaran jika belum ada
            if ($validated['status'] === 'siap_antar' && !$pesanan->pengantaran) {
                $alamatAntar = $pesanan->alamat_jemput ?? $pesanan->pelanggan->alamat ?? 'Alamat tidak tersedia';
                
                Pengantaran::create([
                    'pesanan_id' => $pesanan->pesanan_id,
                    'alamat' => $alamatAntar,
                    'status' => 'dijadwalkan',
                ]);

                // Notifikasi ke kurir
                $kurirs = \App\Models\User::where('role', 'kurir')->where('is_active', true)->get();
                foreach ($kurirs as $kurir) {
                    Notifikasi::create([
                        'user_id' => $kurir->id,
                        'judul' => 'Pengantaran Baru',
                        'pesan' => "Pesanan {$pesanan->kode_booking} siap untuk diantar",
                        'tipe' => 'info',
                    ]);
                }
            }

            // Notifikasi ke pelanggan
            $statusText = str_replace('_', ' ', ucfirst($validated['status']));
            Notifikasi::create([
                'user_id' => $pesanan->pelanggan_id,
                'judul' => 'Status Pesanan Diperbarui',
                'pesan' => "Status pesanan {$pesanan->kode_booking} menjadi: {$statusText}",
                'tipe' => 'info',
            ]);

            DB::commit();

            return back()->with('success', 'Status pesanan berhasil diupdate menjadi: ' . $statusText);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal update status: ' . $e->getMessage());
        }
    }

    public function konfirmasiPembayaran(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:berhasil,gagal',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        
        DB::beginTransaction();
        try {
            if ($pesanan->pembayaran) {
                $pesanan->pembayaran->update([
                    'status' => $validated['status']
                ]);

                // Notifikasi ke pelanggan
                $statusText = $validated['status'] === 'berhasil' ? 'berhasil dikonfirmasi' : 'ditolak';
                Notifikasi::create([
                    'user_id' => $pesanan->pelanggan_id,
                    'judul' => 'Informasi Pembayaran',
                    'pesan' => "Pembayaran untuk pesanan {$pesanan->kode_booking} telah {$statusText}.",
                    'tipe' => $validated['status'] === 'berhasil' ? 'success' : 'danger',
                ]);
            }

            DB::commit();

            return back()->with('success', 'Status pembayaran berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal update status pembayaran: ' . $e->getMessage());
        }
    }
} 