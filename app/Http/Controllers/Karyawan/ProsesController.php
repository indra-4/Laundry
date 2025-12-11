<?php
// ========================================
// FILE: app/Http/Controllers/Karyawan/ProsesController.php
// ========================================

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Proses;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProsesController extends Controller
{
    public function index()
    {
        $proses = Proses::with(['pesanan.pelanggan', 'karyawan'])
            ->whereHas('pesanan', function($q) {
                $q->whereIn('status', ['ditimbang', 'dicuci', 'dikeringkan', 'disetrika', 'dikemas']);
            })
            ->where('status_checklist', false)
            ->latest()
            ->paginate(20);
        
        return view('karyawan.proses.index', compact('proses'));
    }

    public function updateChecklist(Request $request, $id)
    {
        $proses = Proses::findOrFail($id);
        
        DB::beginTransaction();
        try {
            $proses->update([
                'status_checklist' => true,
                'waktu_selesai' => now(),
            ]);

            // Update status pesanan sesuai tahapan
            $statusMap = [
                'pencucian' => 'dicuci',
                'pengeringan' => 'dikeringkan',
                'penyetrikaan' => 'disetrika',
                'pengemasan' => 'dikemas',
            ];

            if (isset($statusMap[$proses->tahapan])) {
                $proses->pesanan->update(['status' => $statusMap[$proses->tahapan]]);
            }

            DB::commit();

            return back()->with('success', 'Checklist proses berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal update checklist: ' . $e->getMessage());
        }
    }
}