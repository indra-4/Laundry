@extends('layouts.app')
@section('title', 'Dashboard Pemilik')
@section('page-title', 'Dashboard Pemilik')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3" data-aos="fade-up" data-aos-delay="0">
        <div class="card stat-card h-100 border-0 shadow-sm" style="border-left: 4px solid #2563eb !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted fw-medium mb-1">Pesanan Bulan Ini</h6>
                        <h2 class="fw-bold mb-0 text-dark">{{ $statistik['total_pesanan_bulan_ini'] }}</h2>
                    </div>
                    <div class="fs-1 text-primary opacity-25"><i class="bi bi-cart-check-fill"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
        <div class="card stat-card h-100 border-0 shadow-sm" style="border-left: 4px solid #10b981 !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted fw-medium mb-1">Pendapatan Bulan Ini</h6>
                        <h3 class="fw-bold mb-0 text-dark">Rp {{ number_format($statistik['total_pendapatan_bulan_ini'], 0, ',', '.') }}</h3>
                    </div>
                    <div class="fs-1 text-success opacity-25" style="color: #10b981 !important;"><i class="bi bi-wallet2"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
        <div class="card stat-card h-100 border-0 shadow-sm" style="border-left: 4px solid #f59e0b !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted fw-medium mb-1">Pesanan Hari Ini</h6>
                        <h2 class="fw-bold mb-0 text-dark">{{ $statistik['pesanan_hari_ini'] }}</h2>
                    </div>
                    <div class="fs-1 text-warning opacity-25" style="color: #f59e0b !important;"><i class="bi bi-basket-fill"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
        <div class="card stat-card h-100 border-0 shadow-sm" style="border-left: 4px solid #0ea5e9 !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted fw-medium mb-1">Pelanggan Aktif</h6>
                        <h2 class="fw-bold mb-0 text-dark">{{ $statistik['pelanggan_aktif'] }}</h2>
                    </div>
                    <div class="fs-1 text-info opacity-25" style="color: #0ea5e9 !important;"><i class="bi bi-people-fill"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-12" data-aos="fade-up" data-aos-delay="400">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-pie-chart text-primary me-2"></i>Status Pesanan</h5>
            </div>
            <div class="card-body">
                @php
                    $statusLabels = [
                        'pending' => 'Menunggu Konfirmasi',
                        'menunggu_penjemputan' => 'Menunggu Penjemputan',
                        'dijemput' => 'Sedang Dijemput',
                        'ditimbang' => 'Ditimbang',
                        'dicuci' => 'Dicuci',
                        'dikeringkan' => 'Dikeringkan',
                        'disetrika' => 'Disetrika',
                        'dikemas' => 'Dikemas',
                        'siap_antar' => 'Siap Antar',
                        'diantar' => 'Sedang Diantar',
                    ];
                    $statusColors = [
                        'pending' => 'secondary',
                        'menunggu_penjemputan' => 'info',
                        'dijemput' => 'primary',
                        'ditimbang' => 'primary',
                        'dicuci' => 'warning',
                        'dikeringkan' => 'warning',
                        'disetrika' => 'warning',
                        'dikemas' => 'warning',
                        'siap_antar' => 'info',
                        'diantar' => 'primary',
                    ];
                    $statusIcons = [
                        'pending' => 'clock',
                        'menunggu_penjemputan' => 'truck',
                        'dijemput' => 'arrow-down-circle',
                        'ditimbang' => 'scale',
                        'dicuci' => 'droplet',
                        'dikeringkan' => 'sun',
                        'disetrika' => 'fire',
                        'dikemas' => 'box',
                        'siap_antar' => 'check-circle',
                        'diantar' => 'arrow-up-circle',
                    ];
                    $totalAktif = $statusPesanan->sum('total');
                @endphp
                
                @if($statusPesanan->count() > 0)
                    <div class="row g-3">
                        @foreach($statusPesanan as $status)
                        @php
                            $label = $statusLabels[$status->status] ?? ucfirst(str_replace('_', ' ', $status->status));
                            $color = $statusColors[$status->status] ?? 'secondary';
                            $icon = $statusIcons[$status->status] ?? 'circle';
                            $percentage = $totalAktif > 0 ? ($status->total / $totalAktif * 100) : 0;
                        @endphp
                        <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="card border-{{ $color }} h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-{{ $icon }} text-{{ $color }} fs-4 me-2"></i>
                                        <h6 class="mb-0">{{ $label }}</h6>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fs-3 fw-bold text-{{ $color }}">{{ $status->total }}</span>
                                        <small class="text-muted">{{ number_format($percentage, 1) }}%</small>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-{{ $color }}" 
                                             role="progressbar" 
                                             style="width: {{ $percentage }}%"
                                             aria-valuenow="{{ $percentage }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox fs-1 text-muted"></i>
                        <p class="text-muted mt-3 mb-0">Tidak ada pesanan aktif saat ini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-12" data-aos="fade-up" data-aos-delay="500">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-clock-history text-primary me-2"></i>Pesanan Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Pelanggan</th>
                                <th>Layanan</th>
                                <th>Status</th>
                                <th>Harga</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesananTerbaru as $p)
                            <tr data-aos="fade-right" data-aos-delay="{{ $loop->index * 50 }}">
                                <td>{{ $p->kode_booking }}</td>
                                <td>{{ $p->pelanggan->nama }}</td>
                                <td>{{ $p->layanan->nama_layanan }}</td>
                                <td><span class="badge bg-{{ $p->status_badge }}">{{ $p->status }}</span></td>
                                <td>Rp {{ number_format($p->harga_final ?? $p->estimasi_harga, 0, ',', '.') }}</td>
                                <td>{{ $p->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
@endpush
@endsection