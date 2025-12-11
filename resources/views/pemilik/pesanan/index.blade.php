@extends('layouts.app')
@section('title', 'Semua Pesanan')
@section('page-title', 'Semua Pesanan')

@section('content')
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
                        <td colspan="6" class="text-center text-muted">Belum ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $pesanan->links() }}
        </div>
    </div>
    
</div>
@endsection


