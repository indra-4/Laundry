@extends('layouts.app')
@section('title', 'Laporan')
@section('page-title', 'Laporan')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <form class="row g-2" method="GET">
            <div class="col-md-3">
                <label class="form-label">Tanggal Awal</label>
                <input type="date" class="form-control" name="tanggal_awal" value="{{ $tanggalAwal }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Akhir</label>
                <input type="date" class="form-control" name="tanggal_akhir" value="{{ $tanggalAkhir }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-primary w-100">Terapkan</button>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <a href="{{ route('pemilik.laporan.export', 'csv') }}?tanggal_awal={{ $tanggalAwal }}&tanggal_akhir={{ $tanggalAkhir }}" class="btn btn-success w-100">Export CSV</a>
            </div>
        </form>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="text-muted">Total Pesanan</div>
                <h3 class="mb-0">{{ $totalPesanan }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="text-muted">Total Pendapatan</div>
                <h4 class="mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="text-muted">Selesai</div>
                <h3 class="mb-0">{{ $pesananSelesai }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="text-muted">Dibatalkan</div>
                <h3 class="mb-0">{{ $pesananDibatalkan }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card">
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
                    @forelse($pesanan as $p)
                    <tr>
                        <td>{{ $p->kode_booking }}</td>
                        <td>{{ $p->pelanggan->nama ?? '-' }}</td>
                        <td>{{ $p->layanan->nama_layanan ?? '-' }}</td>
                        <td>{{ $p->status }}</td>
                        <td>Rp {{ number_format($p->harga_final ?? $p->estimasi_harga, 0, ',', '.') }}</td>
                        <td>{{ optional($p->created_at)->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Tidak ada data pada rentang tanggal ini</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


