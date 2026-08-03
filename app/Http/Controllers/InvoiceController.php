<?php
// ========================================
// FILE: app/Http/Controllers/InvoiceController.php
// ========================================

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function show($id)
    {
        $pesanan = Pesanan::with(['pelanggan', 'layanan', 'pembayaran', 'proses', 'penjemputan', 'pengantaran'])->findOrFail($id);

        $user = Auth::user();

        // Cek Otorisasi: Pelanggan hanya bisa melihat invoice miliknya sendiri
        if ($user->role === 'pelanggan' && $pesanan->pelanggan_id !== $user->id) {
            abort(403, 'Unauthorized access to this invoice.');
        }

        return view('invoice', compact('pesanan'));
    }
}
