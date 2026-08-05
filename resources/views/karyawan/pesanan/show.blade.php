@extends('layouts.app')
@section('page-title', 'Detail Pesanan')

@section('content')
<div class="row g-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Detail Pesanan {{ $pesanan->kode_booking }}</h5>
                <a href="{{ route('pesanan.invoice', $pesanan->pesanan_id) }}" class="btn btn-sm btn-outline-primary rounded-pill shadow-sm" target="_blank">
                    <i class="bi bi-printer"></i> Cetak Struk
                </a>
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
        @if($pesanan->pembayaran && $pesanan->pembayaran->status === 'menunggu')
        <div class="card mb-3 border-warning">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0"><i class="bi bi-wallet2"></i> Konfirmasi Pembayaran</h6>
            </div>
            <div class="card-body">
                <p class="small text-muted mb-2">Pelanggan telah melakukan pembayaran via <strong>{{ strtoupper($pesanan->pembayaran->metode_pembayaran) }}</strong> sebesar <strong>Rp {{ number_format($pesanan->pembayaran->jumlah, 0, ',', '.') }}</strong>.</p>
                @if($pesanan->pembayaran->bukti_transfer)
                <div class="mb-3 text-center">
                    @if(str_starts_with($pesanan->pembayaran->bukti_transfer, 'data:image'))
                        <img src="{{ $pesanan->pembayaran->bukti_transfer }}" class="img-fluid rounded border mb-2" style="max-height: 200px; object-fit: contain;" alt="Bukti Transfer">
                    @else
                        <a href="{{ Storage::url($pesanan->pembayaran->bukti_transfer) }}" target="_blank" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-image"></i> Lihat Bukti Transfer (Legacy)
                        </a>
                    @endif
                </div>
                @endif
                <form method="POST" action="{{ route('karyawan.pesanan.konfirmasi-pembayaran', $pesanan->pesanan_id) }}">
                    @csrf
                    <div class="d-flex gap-2">
                        <button type="submit" name="status" value="berhasil" class="btn btn-success flex-grow-1" data-confirm="Konfirmasi bahwa dana sudah masuk?">
                            <i class="bi bi-check-circle"></i> Terima
                        </button>
                        <button type="submit" name="status" value="gagal" class="btn btn-danger flex-grow-1" data-confirm="Tolak pembayaran ini?">
                            <i class="bi bi-x-circle"></i> Tolak
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif

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