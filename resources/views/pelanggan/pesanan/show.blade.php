@extends('layouts.app')
@section('page-title', 'Detail Pesanan')

@section('content')
<div class="row g-4">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-receipt"></i> Detail Pesanan</h5>
                <a href="{{ route('pesanan.invoice', $pesanan->pesanan_id) }}" class="btn btn-sm btn-light text-primary fw-bold rounded-pill shadow-sm" target="_blank">
                    <i class="bi bi-printer"></i> Cetak Struk
                </a>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-5"><strong>Kode Booking:</strong></div>
                    <div class="col-7">{{ $pesanan->kode_booking }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-5"><strong>Layanan:</strong></div>
                    <div class="col-7">{{ $pesanan->layanan->nama_layanan }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-5"><strong>Tanggal Pesanan:</strong></div>
                    <div class="col-7">{{ $pesanan->created_at->format('d M Y, H:i') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-5"><strong>Status:</strong></div>
                    <div class="col-7">
                        <span class="badge bg-{{ $pesanan->status_badge }} badge-status">
                            {{ str_replace('_', ' ', ucfirst($pesanan->status)) }}
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-5"><strong>Metode:</strong></div>
                    <div class="col-7">{{ ucfirst(str_replace('_', ' ', $pesanan->metode_antar)) }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-5"><strong>Estimasi Berat:</strong></div>
                    <div class="col-7">{{ $pesanan->estimasi_berat }} kg</div>
                </div>
                @if($pesanan->berat_aktual)
                <div class="row mb-3">
                    <div class="col-5"><strong>Berat Aktual:</strong></div>
                    <div class="col-7"><strong class="text-primary">{{ $pesanan->berat_aktual }} kg</strong></div>
                </div>
                @endif
                <div class="row mb-3">
                    <div class="col-5"><strong>Estimasi Harga:</strong></div>
                    <div class="col-7">Rp {{ number_format($pesanan->estimasi_harga, 0, ',', '.') }}</div>
                </div>
                @if($pesanan->harga_final)
                <div class="row mb-3">
                    <div class="col-5"><strong>Total Harga:</strong></div>
                    <div class="col-7"><h5 class="text-primary mb-0">Rp {{ number_format($pesanan->harga_final, 0, ',', '.') }}</h5></div>
                </div>
                @endif
                @if($pesanan->catatan)
                <div class="row">
                    <div class="col-12">
                        <strong>Catatan:</strong>
                        <p class="text-muted">{{ $pesanan->catatan }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        @if($pesanan->pembayaran)
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-credit-card"></i> Informasi Pembayaran</h5>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-5"><strong>Metode:</strong></div>
                    <div class="col-7">{{ ucfirst($pesanan->pembayaran->metode_pembayaran) }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><strong>Status:</strong></div>
                    <div class="col-7">
                        <span class="badge bg-{{ $pesanan->pembayaran->status == 'berhasil' ? 'success' : ($pesanan->pembayaran->status == 'gagal' ? 'danger' : 'warning') }}">
                            {{ ucfirst($pesanan->pembayaran->status) }}
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-5"><strong>Jumlah:</strong></div>
                    <div class="col-7">Rp {{ number_format($pesanan->pembayaran->jumlah, 0, ',', '.') }}</div>
                </div>
                @if($pesanan->pembayaran->bukti_transfer)
                    @php
                        $bukti = trim($pesanan->pembayaran->bukti_transfer);
                        $isBase64 = str_starts_with($bukti, 'data:image') || str_contains($bukti, ';base64,');
                    @endphp
                    <div class="mt-2">
                        @if($isBase64)
                            <img src="{{ $bukti }}" class="img-fluid rounded border mb-2" style="max-height: 200px; object-fit: contain;" alt="Bukti Transfer">
                        @else
                            <a href="{{ Storage::url($pesanan->pembayaran->bukti_transfer) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i> Lihat Bukti Transfer
                            </a>
                        @endif
                    </div>
                @endif
                
                @if($pesanan->pembayaran->status == 'gagal')
                    <div class="mt-3 border-top pt-3">
                        <div class="alert alert-danger py-2 mb-3">
                            <i class="bi bi-exclamation-circle"></i> Pembayaran ditolak. Silakan unggah ulang bukti yang valid.
                        </div>
                        <a href="{{ route('pelanggan.pesanan.pembayaran', $pesanan->pesanan_id) }}" class="btn btn-warning w-100 fw-bold">
                            <i class="bi bi-arrow-repeat"></i> Upload Ulang Pembayaran
                        </a>
                    </div>
                @endif
            </div>
        </div>
        @else
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-credit-card display-1 text-muted"></i>
                <h5 class="mt-3">Belum Ada Pembayaran</h5>
                <p class="text-muted">Silakan lakukan pembayaran untuk pesanan ini</p>
                <a href="{{ route('pelanggan.pesanan.pembayaran', $pesanan->pesanan_id) }}" 
                   class="btn btn-success btn-lg">
                    <i class="bi bi-wallet2"></i> Bayar Sekarang
                </a>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Timeline Status</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @php
                    $statuses = [
                        'pending' => 'Pesanan Dibuat',
                        'menunggu_penjemputan' => 'Menunggu Penjemputan',
                        'dijemput' => 'Cucian Dijemput',
                        'ditimbang' => 'Cucian Ditimbang',
                        'dicuci' => 'Sedang Dicuci',
                        'dikeringkan' => 'Sedang Dikeringkan',
                        'disetrika' => 'Sedang Disetrika',
                        'dikemas' => 'Sedang Dikemas',
                        'siap_antar' => 'Siap Diantar',
                        'diantar' => 'Sedang Diantar',
                        'selesai' => 'Selesai',
                    ];
                    $currentStatus = $pesanan->status;
                    $currentIndex = array_search($currentStatus, array_keys($statuses));
                    @endphp
                    
                    @foreach($statuses as $key => $label)
                    @php
                    $index = array_search($key, array_keys($statuses));
                    $isActive = $index <= $currentIndex;
                    @endphp
                    <div class="mb-3 {{ $isActive ? 'text-primary fw-bold' : 'text-muted' }}">
                        <i class="bi {{ $isActive ? 'bi-check-circle-fill' : 'bi-circle' }}"></i>
                        {{ $label }}
                        @if($key == $currentStatus)
                        <span class="badge bg-primary ms-2">Saat Ini</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection