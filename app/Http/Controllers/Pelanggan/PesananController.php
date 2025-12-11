<?php
// ========================================
// FILE: app/Http/Controllers/Pelanggan/PesananController.php
// ========================================

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use App\Models\Penjemputan;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::byPelanggan(auth()->id())
            ->with(['layanan', 'pembayaran'])
            ->latest()
            ->paginate(10);
        
        return view('pelanggan.pesanan.index', compact('pesanan'));
    }

    public function create()
    {
        $layanan = Layanan::aktif()->get();
        return view('pelanggan.pesanan.create', compact('layanan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'layanan_id' => 'required|exists:layanan,layanan_id',
            'estimasi_berat' => 'required|numeric|min:1',
            'metode_antar' => 'required|in:antar_sendiri,dijemput',
            'alamat_jemput' => 'required_if:metode_antar,dijemput',
            'catatan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $layanan = Layanan::findOrFail($validated['layanan_id']);
            
            // Hitung estimasi harga
            $estimasiHarga = $layanan->jenis === 'kiloan' 
                ? $layanan->harga_per_kg * $validated['estimasi_berat']
                : $layanan->harga_satuan * $validated['estimasi_berat'];

            // Buat pesanan
            $pesanan = Pesanan::create([
                'pelanggan_id' => auth()->id(),
                'layanan_id' => $validated['layanan_id'],
                'estimasi_berat' => $validated['estimasi_berat'],
                'metode_antar' => $validated['metode_antar'],
                'alamat_jemput' => $validated['alamat_jemput'] ?? auth()->user()->alamat,
                'catatan' => $validated['catatan'],
                'estimasi_harga' => $estimasiHarga,
                'status' => $validated['metode_antar'] === 'dijemput' ? 'menunggu_penjemputan' : 'pending',
            ]);

            // Jika dijemput, buat jadwal penjemputan
            if ($validated['metode_antar'] === 'dijemput') {
                Penjemputan::create([
                    'pesanan_id' => $pesanan->pesanan_id,
                    'alamat' => $validated['alamat_jemput'],
                    'status' => 'dijadwalkan',
                ]);
            }

            // Buat notifikasi untuk pemilik/karyawan
            $users = \App\Models\User::whereIn('role', ['pemilik', 'karyawan'])->get();
            foreach ($users as $user) {
                Notifikasi::create([
                    'user_id' => $user->id,
                    'judul' => 'Pesanan Baru',
                    'pesan' => "Pesanan baru dari {$pesanan->pelanggan->nama} dengan kode {$pesanan->kode_booking}",
                    'tipe' => 'info',
                ]);
            }

            DB::commit();

            return redirect()->route('pelanggan.pesanan.show', $pesanan->pesanan_id)
                ->with('success', 'Pesanan berhasil dibuat! Kode booking: ' . $pesanan->kode_booking);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $pesanan = Pesanan::with(['layanan', 'pembayaran', 'penjemputan', 'pengantaran', 'proses'])
            ->where('pesanan_id', $id)
            ->where('pelanggan_id', auth()->id())
            ->firstOrFail();
        
        return view('pelanggan.pesanan.show', compact('pesanan'));
    }

    public function pembayaran($id)
    {
        $pesanan = Pesanan::with('pembayaran')
            ->where('pesanan_id', $id)
            ->where('pelanggan_id', auth()->id())
            ->firstOrFail();
        
        // Cek jika sudah ada pembayaran
        if ($pesanan->pembayaran && $pesanan->pembayaran->status !== 'gagal') {
            return redirect()->route('pelanggan.pesanan.show', $id)
                ->with('info', 'Pesanan ini sudah memiliki pembayaran.');
        }
        
        return view('pelanggan.pesanan.pembayaran', compact('pesanan'));
    }

    public function uploadBukti(Request $request, $id)
    {
        $validated = $request->validate([
            'metode_pembayaran' => 'required|in:transfer,tunai,ewallet,qris',
            'bukti_transfer' => 'required_unless:metode_pembayaran,tunai|image|max:2048',
        ]);

        $pesanan = Pesanan::where('pesanan_id', $id)
            ->where('pelanggan_id', auth()->id())
            ->firstOrFail();

        DB::beginTransaction();
        try {
            $buktiPath = null;
            
            if ($request->hasFile('bukti_transfer')) {
                $buktiPath = $request->file('bukti_transfer')->store('bukti-pembayaran', 'public');
            }

            Pembayaran::updateOrCreate(
                ['pesanan_id' => $id],
                [
                    'metode_pembayaran' => $validated['metode_pembayaran'],
                    'jumlah' => $pesanan->harga_final ?? $pesanan->estimasi_harga,
                    'status' => $validated['metode_pembayaran'] === 'tunai' ? 'menunggu' : 'menunggu',
                    'bukti_transfer' => $buktiPath,
                    'tanggal_bayar' => now(),
                ]
            );

            // Notifikasi ke pemilik/karyawan
            $users = \App\Models\User::whereIn('role', ['pemilik', 'karyawan'])->get();
            foreach ($users as $user) {
                Notifikasi::create([
                    'user_id' => $user->id,
                    'judul' => 'Pembayaran Baru',
                    'pesan' => "Pembayaran untuk pesanan {$pesanan->kode_booking} perlu dikonfirmasi",
                    'tipe' => 'info',
                ]);
            }

            DB::commit();

            return redirect()->route('pelanggan.pesanan.show', $id)
                ->with('success', 'Bukti pembayaran berhasil diupload. Menunggu konfirmasi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal upload bukti: ' . $e->getMessage());
        }
    }
} 