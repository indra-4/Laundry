<?php

namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use App\Models\Pesan;
use App\Models\Pesanan;
use App\Models\Pengantaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index()
    {
        // Ambil semua pengantaran yang terkait dengan kurir ini
        $pengantaran = Pengantaran::where('kurir_id', auth()->id())
            ->orWhere(function($q) {
                $q->whereNull('kurir_id')
                  ->whereIn('status', ['dijadwalkan']);
            })
            ->with('pesanan.pelanggan')
            ->latest()
            ->get();

        return view('kurir.chat.index', compact('pengantaran'));
    }

    public function show($pesananId)
    {
        $pesanan = Pesanan::with('pelanggan', 'pengantaran')->findOrFail($pesananId);
        
        // Pastikan kurir memiliki akses ke pesanan ini
        if ($pesanan->pengantaran && $pesanan->pengantaran->kurir_id !== auth()->id() && $pesanan->pengantaran->kurir_id !== null) {
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

        return view('kurir.chat.show', compact('pesanan', 'pesan'));
    }

    public function store(Request $request, $pesananId)
    {
        $validated = $request->validate([
            'isi_pesan' => 'required|string|max:1000',
        ]);

        $pesanan = Pesanan::findOrFail($pesananId);
        
        // Pastikan kurir memiliki akses ke pesanan ini
        if ($pesanan->pengantaran && $pesanan->pengantaran->kurir_id !== auth()->id() && $pesanan->pengantaran->kurir_id !== null) {
            abort(403, 'Anda tidak memiliki akses ke chat ini');
        }

        $pesan = Pesan::create([
            'pesanan_id' => $pesananId,
            'pengirim_id' => auth()->id(),
            'penerima_id' => $pesanan->pelanggan_id,
            'isi_pesan' => $validated['isi_pesan'],
            'dibaca' => false,
        ]);

        // Buat notifikasi untuk pelanggan
        \App\Models\Notifikasi::create([
            'user_id' => $pesanan->pelanggan_id,
            'judul' => 'Pesan Baru dari Kurir',
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
