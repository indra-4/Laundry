<!-- ========================================
FILE: resources/views/pelanggan/dashboard.blade.php
======================================== -->
@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card h-100 border-0 shadow-sm" style="border-left: 4px solid #2563eb !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted fw-medium mb-1">Total Pesanan</h6>
                        <h2 class="fw-bold mb-0 text-dark">{{ $totalPesanan }}</h2>
                    </div>
                    <div class="fs-1 text-primary opacity-25"><i class="bi bi-cart-check-fill"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100 border-0 shadow-sm" style="border-left: 4px solid #f59e0b !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted fw-medium mb-1">Pesanan Aktif</h6>
                        <h2 class="fw-bold mb-0 text-dark">{{ $pesananAktif->count() }}</h2>
                    </div>
                    <div class="fs-1 text-warning opacity-25" style="color: #f59e0b !important;"><i class="bi bi-hourglass-split"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100 border-0 shadow-sm" style="border-left: 4px solid #10b981 !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted fw-medium mb-1">Pesanan Selesai</h6>
                        <h2 class="fw-bold mb-0 text-dark">{{ $riwayatPesanan->where('status', 'selesai')->count() }}</h2>
                    </div>
                    <div class="fs-1 text-success opacity-25" style="color: #10b981 !important;"><i class="bi bi-check-circle-fill"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100 border-0 shadow-sm" style="border-left: 4px solid #0ea5e9 !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted fw-medium mb-1">Notifikasi Baru</h6>
                        <h2 class="fw-bold mb-0 text-dark">{{ $notifikasi->count() }}</h2>
                    </div>
                    <div class="fs-1 text-info opacity-25" style="color: #0ea5e9 !important;"><i class="bi bi-bell-fill"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card glass-card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-hourglass-split text-primary me-2"></i> Pantau Pesanan Aktif</h5>
                <a href="{{ route('pelanggan.pesanan.create') }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                    <i class="bi bi-plus-circle"></i> Buat Pesanan Baru
                </a>
            </div>
            <div class="card-body">
                @forelse($pesananAktif as $pesanan)
                    @php $progress = $pesanan->progress_data; @endphp
                    <div class="border-bottom pb-4 mb-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="mb-1 fw-bold fs-5">{{ $pesanan->kode_booking }}</h6>
                                <p class="text-muted mb-1"><i class="bi bi-basket me-1"></i> {{ $pesanan->layanan->nama_layanan }}</p>
                                <small class="text-muted"><i class="bi bi-calendar-event me-1"></i> {{ $pesanan->created_at->format('d M Y, H:i') }}</small>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('pelanggan.pesanan.show', $pesanan->pesanan_id) }}" 
                                   class="btn btn-sm btn-outline-primary rounded-pill px-3 mb-2">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </div>
                        </div>
                        
                        <!-- Visual Timeline / Progress Bar -->
                        <div class="mt-2">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="fw-semibold text-{{ $progress['color'] }}">{{ $progress['label'] }}</small>
                                <small class="text-muted">{{ $progress['percent'] }}%</small>
                            </div>
                            <div class="progress" style="height: 10px; border-radius: 10px; background-color: #e2e8f0;">
                                <div class="progress-bar bg-{{ $progress['color'] }} progress-bar-striped progress-bar-animated" 
                                     role="progressbar" 
                                     style="width: {{ $progress['percent'] }}%; border-radius: 10px;" 
                                     aria-valuenow="{{ $progress['percent'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-box-seam text-muted" style="font-size: 3rem; opacity: 0.5;"></i>
                        </div>
                        <h6 class="fw-bold text-dark">Tidak ada pesanan aktif saat ini</h6>
                        <p class="text-muted mb-4">Pakaian kotor menumpuk? Yuk, buat pesanan sekarang!</p>
                        <a href="{{ route('pelanggan.pesanan.create') }}" class="btn btn-primary rounded-pill px-4">
                            Pesan Laundry
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-bell text-primary me-2"></i> Notifikasi Terbaru</h5>
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                @forelse($notifikasi as $notif)
                    <div class="mb-3 pb-3 border-bottom">
                        <h6 class="mb-1">{{ $notif->judul }}</h6>
                        <p class="mb-1 small">{{ $notif->pesan }}</p>
                        <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                    </div>
                @empty
                    <p class="text-center text-muted">Tidak ada notifikasi</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-clock-history text-primary me-2"></i> Riwayat Pesanan Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Kode Booking</th>
                                <th>Layanan</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayatPesanan as $pesanan)
                                <tr>
                                    <td>{{ $pesanan->kode_booking }}</td>
                                    <td>{{ $pesanan->layanan->nama_layanan }}</td>
                                    <td>{{ $pesanan->created_at->format('d M Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $pesanan->status_badge }}">
                                            {{ str_replace('_', ' ', ucfirst($pesanan->status)) }}
                                        </span>
                                    </td>
                                    <td>Rp {{ number_format($pesanan->harga_final ?? $pesanan->estimasi_harga, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada riwayat pesanan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection