@extends('layouts.app')
@section('title', 'Dashboard Karyawan')
@section('page-title', 'Dashboard Karyawan')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h6>Pending</h6>
                <h2>{{ $statistik['pending'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h6>Diproses</h6>
                <h2>{{ $statistik['diproses'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h6>Siap Antar</h6>
                <h2>{{ $statistik['siap_antar'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h6>Selesai Hari Ini</h6>
                <h2>{{ $statistik['selesai_hari_ini'] }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-inbox"></i> Pesanan Baru</h5>
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
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-arrow-repeat"></i> Sedang Diproses</h5>
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
