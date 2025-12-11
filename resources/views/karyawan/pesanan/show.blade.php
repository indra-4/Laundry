@extends('layouts.app')
@section('page-title', 'Detail Pesanan')

@section('content')
<div class="row g-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Detail Pesanan {{ $pesanan->kode_booking }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-4"><strong>Pelanggan:</strong></div>
                    <div class="col-8">{{ $pesanan->pelanggan->nama }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Layanan:</strong></div>
                    <div class="col-8">{{ $pesanan->layanan->nama_layanan }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Estimasi Berat:</strong></div>
                    <div class="col-8">{{ $pesanan->estimasi_berat }} kg</div>
                </div>
                @if(!$pesanan->berat_aktual && in_array($pesanan->status, ['pending', 'dijemput']))
                <div class="card bg-light mt-3">
                    <div class="card-body">
                        <h6>Input Berat Aktual:</h6>
                        <form method="POST" action="{{ route('karyawan.pesanan.timbang', $pesanan->pesanan_id) }}">
                            @csrf
                            <div class="input-group mb-2">
                                <input type="number" step="0.1" name="berat_aktual" class="form-control" 
                                       placeholder="Berat dalam kg" required>
                                <span class="input-group-text">kg</span>
                            </div>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check"></i> Simpan Berat
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6>Update Status</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('karyawan.pesanan.update-status', $pesanan->pesanan_id) }}">
                    @csrf
                    <select name="status" class="form-select mb-2">
                        <option value="dicuci">Dicuci</option>
                        <option value="dikeringkan">Dikeringkan</option>
                        <option value="disetrika">Disetrika</option>
                        <option value="dikemas">Dikemas</option>
                        <option value="siap_antar">Siap Antar</option>
                        <option value="selesai">Selesai</option>
                    </select>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-arrow-up-circle"></i> Update
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection