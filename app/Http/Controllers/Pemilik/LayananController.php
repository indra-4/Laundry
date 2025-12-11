<?php
// ========================================
// FILE: app/Http/Controllers/Pemilik/LayananController.php
// ========================================

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index()
    {
        $layanan = Layanan::latest()->paginate(10);
        return view('pemilik.layanan.index', compact('layanan'));
    }

    public function create()
    {
        return view('pemilik.layanan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'jenis' => 'required|in:kiloan,satuan,express',
            'harga_per_kg' => 'required_if:jenis,kiloan,express|nullable|numeric|min:0',
            'harga_satuan' => 'required_if:jenis,satuan|nullable|numeric|min:0',
            'durasi_pengerjaan' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'status_aktif' => 'boolean',
        ]);

        Layanan::create($validated);

        return redirect()->route('pemilik.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $layanan = Layanan::findOrFail($id);
        return view('pemilik.layanan.edit', compact('layanan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'jenis' => 'required|in:kiloan,satuan,express',
            'harga_per_kg' => 'required_if:jenis,kiloan,express|nullable|numeric|min:0',
            'harga_satuan' => 'required_if:jenis,satuan|nullable|numeric|min:0',
            'durasi_pengerjaan' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'status_aktif' => 'boolean',
        ]);

        $layanan = Layanan::findOrFail($id);
        $layanan->update($validated);

        return redirect()->route('pemilik.layanan.index')
            ->with('success', 'Layanan berhasil diupdate!');
    }

    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);
        
        if ($layanan->pesanan()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus layanan yang sudah memiliki pesanan!');
        }
        
        $layanan->delete();

        return redirect()->route('pemilik.layanan.index')
            ->with('success', 'Layanan berhasil dihapus!');
    }
}
