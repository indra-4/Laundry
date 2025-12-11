@extends('layouts.app')
@section('title', 'Dashboard Kurir')
@section('page-title', 'Dashboard Kurir')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h6>Penjemputan Pending</h6>
                <h2>{{ $statistik['penjemputan_pending'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h6>Penjemputan Selesai Hari Ini</h6>
                <h2>{{ $statistik['penjemputan_selesai_hari_ini'] }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h6>Pengantaran Pending</h6>
                <h2>{{ $statistik['pengantaran_pending'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h6>Pengantaran Selesai Hari Ini</h6>
                <h2>{{ $statistik['pengantaran_selesai_hari_ini'] }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-box-arrow-in-down"></i> Penjemputan Hari Ini</h5>
            </div>
            <div class="card-body">
                @forelse($penjemputanHariIni as $p)
                <div class="border-bottom pb-2 mb-2">
                    <strong>{{ $p->pesanan->kode_booking }}</strong><br>
                    <small>{{ $p->pesanan->pelanggan->nama }}</small><br>
                    <small class="text-muted">{{ $p->alamat }}</small><br>
                    <a href="{{ route('kurir.penjemputan.show', $p->penjemputan_id) }}" 
                       class="btn btn-sm btn-primary mt-2">Lihat Detail</a>
                </div>
                @empty
                <p class="text-muted text-center">Tidak ada penjemputan hari ini</p>
                @endforelse
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-box-arrow-up"></i> Pengantaran Hari Ini</h5>
            </div>
            <div class="card-body">
                @forelse($pengantaranHariIni as $p)
                <div class="border-bottom pb-2 mb-2">
                    <strong>{{ $p->pesanan->kode_booking }}</strong><br>
                    <small>{{ $p->pesanan->pelanggan->nama }}</small><br>
                    <small class="text-muted">{{ $p->alamat }}</small><br>
                    <a href="{{ route('kurir.pengantaran.show', $p->pengantaran_id) }}" 
                       class="btn btn-sm btn-success mt-2">Lihat Detail</a>
                </div>
                @empty
                <p class="text-muted text-center">Tidak ada pengantaran hari ini</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection