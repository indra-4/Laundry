<!-- ========================================
FILE: resources/views/pelanggan/dashboard.blade.php
======================================== -->
@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h6 class="card-title">Total Pesanan</h6>
                <h2 class="mb-0">{{ $totalPesanan }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h6 class="card-title">Pesanan Aktif</h6>
                <h2 class="mb-0">{{ $pesananAktif->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h6 class="card-title">Pesanan Selesai</h6>
                <h2 class="mb-0">{{ $riwayatPesanan->where('status', 'selesai')->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h6 class="card-title">Notifikasi Baru</h6>
                <h2 class="mb-0">{{ $notifikasi->count() }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-hourglass-split"></i> Pesanan Aktif</h5>
                <a href="{{ route('pelanggan.pesanan.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Buat Pesanan Baru
                </a>
            </div>
            <div class="card-body">
                @forelse($pesananAktif as $pesanan)
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">{{ $pesanan->kode_booking }}</h6>
                                <p class="text-muted mb-1">{{ $pesanan->layanan->nama_layanan }}</p>
                                <small class="text-muted">{{ $pesanan->created_at->format('d M Y, H:i') }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $pesanan->status_badge }}">
                                    {{ str_replace('_', ' ', ucfirst($pesanan->status)) }}
                                </span>
                                <div class="mt-2">
                                    <a href="{{ route('pelanggan.pesanan.show', $pesanan->pesanan_id) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted py-4">Tidak ada pesanan aktif</p>
                @endforelse
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-bell"></i> Notifikasi Terbaru</h5>
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
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Riwayat Pesanan Terbaru</h5>
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