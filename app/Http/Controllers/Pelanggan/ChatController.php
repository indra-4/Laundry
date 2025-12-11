<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pesan;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        // Ambil semua pesanan pelanggan yang memiliki pengantaran
        $pesanan = Pesanan::where('pelanggan_id', auth()->id())
            ->whereHas('pengantaran')
            ->with('pengantaran.kurir', 'layanan')
            ->latest()
            ->get();

        return view('pelanggan.chat.index', compact('pesanan'));
    }

    public function show($pesananId)
    {
        $pesanan = Pesanan::with('pengantaran.kurir')->findOrFail($pesananId);
        
        // Pastikan pesanan milik pelanggan ini
        if ($pesanan->pelanggan_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke chat ini');
        }

        // Ambil semua pesan untuk pesanan ini
        $pesan = Pesan::where('pesanan_id', $pesananId)
            ->where(function($q) {
                $q->where('pengirim_id', auth()->id())
                  ->orWhere('penerima_id', auth()->id());
            })
            ->with('pengirim', 'penerima')
            ->orderBy('created_at', 'asc')
            ->get();

        // Tandai pesan sebagai dibaca
        Pesan::where('pesanan_id', $pesananId)
            ->where('penerima_id', auth()->id())
            ->where('dibaca', false)
            ->update(['dibaca' => true]);

        return view('pelanggan.chat.show', compact('pesanan', 'pesan'));
    }

    public function store(Request $request, $pesananId)
    {
        $validated = $request->validate([
            'isi_pesan' => 'required|string|max:1000',
        ]);

        $pesanan = Pesanan::findOrFail($pesananId);
        
        // Pastikan pesanan milik pelanggan ini
        if ($pesanan->pelanggan_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke chat ini');
        }

        // Tentukan penerima (kurir yang menangani pengantaran)
        $penerimaId = $pesanan->pengantaran->kurir_id ?? null;
        
        if (!$penerimaId) {
            return back()->with('error', 'Belum ada kurir yang ditugaskan untuk pesanan ini');
        }

        $pesan = Pesan::create([
            'pesanan_id' => $pesananId,
            'pengirim_id' => auth()->id(),
            'penerima_id' => $penerimaId,
            'isi_pesan' => $validated['isi_pesan'],
            'dibaca' => false,
        ]);

        // Buat notifikasi untuk kurir
        \App\Models\Notifikasi::create([
            'user_id' => $penerimaId,
            'judul' => 'Pesan Baru dari Pelanggan',
            'pesan' => "Anda mendapat pesan baru untuk pesanan {$pesanan->kode_booking}",
            'tipe' => 'info',
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'pesan' => $pesan->load('pengirim')
            ]);
        }

        return back()->with('success', 'Pesan berhasil dikirim');
    }
}
