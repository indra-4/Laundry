@extends('layouts.app')
@section('title', 'Dashboard Karyawan')
@section('page-title', 'Dashboard Karyawan')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card h-100 border-0 shadow-sm" style="border-left: 4px solid #f59e0b !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted fw-medium mb-1">Pending</h6>
                        <h2 class="fw-bold mb-0 text-dark">{{ $statistik['pending'] }}</h2>
                    </div>
                    <div class="fs-1 text-warning opacity-25" style="color: #f59e0b !important;"><i class="bi bi-clock-history"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100 border-0 shadow-sm" style="border-left: 4px solid #0ea5e9 !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted fw-medium mb-1">Diproses</h6>
                        <h2 class="fw-bold mb-0 text-dark">{{ $statistik['diproses'] }}</h2>
                    </div>
                    <div class="fs-1 text-info opacity-25" style="color: #0ea5e9 !important;"><i class="bi bi-gear-fill"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100 border-0 shadow-sm" style="border-left: 4px solid #2563eb !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted fw-medium mb-1">Siap Antar</h6>
                        <h2 class="fw-bold mb-0 text-dark">{{ $statistik['siap_antar'] }}</h2>
                    </div>
                    <div class="fs-1 text-primary opacity-25"><i class="bi bi-box-seam-fill"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100 border-0 shadow-sm" style="border-left: 4px solid #10b981 !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted fw-medium mb-1">Selesai Hari Ini</h6>
                        <h2 class="fw-bold mb-0 text-dark">{{ $statistik['selesai_hari_ini'] }}</h2>
                    </div>
                    <div class="fs-1 text-success opacity-25" style="color: #10b981 !important;"><i class="bi bi-check-circle-fill"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-inbox text-primary me-2"></i> Pesanan Baru</h5>
            </div>
            <div class="card-body">
                @foreach($pesananBaru as $p)
                <div class="border-bottom pb-2 mb-2">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>{{ $p->kode_booking }}</strong><br>
                            <small>{{ $p->pelanggan->nama }} - {{ $p->layanan->nama_layanan }}</small>
                        </div>
                        <div>
                            <a href="{{ route('karyawan.pesanan.show', $p->pesanan_id) }}" 
                               class="btn btn-sm btn-primary">Proses</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-arrow-repeat text-primary me-2"></i> Sedang Diproses</h5>
            </div>
            <div class="card-body">
                @foreach($pesananDiproses as $p)
                <div class="border-bottom pb-2 mb-2">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>{{ $p->kode_booking }}</strong><br>
                            <small>{{ $p->pelanggan->nama }}</small><br>
                            <span class="badge bg-{{ $p->status_badge }}">{{ $p->status }}</span>
                        </div>
                        <div>
                            <a href="{{ route('karyawan.pesanan.show', $p->pesanan_id) }}" 
                               class="btn btn-sm btn-info">Detail</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
