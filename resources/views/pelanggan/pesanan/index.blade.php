@extends('layouts.app')
@section('page-title', 'Riwayat Pesanan')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Riwayat Pesanan Saya</h5>
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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanan as $p)
                    <tr>
                        <td><strong>{{ $p->kode_booking }}</strong></td>
                        <td>{{ $p->layanan->nama_layanan }}</td>
                        <td>{{ $p->created_at->format('d M Y, H:i') }}</td>
                        <td><span class="badge bg-{{ $p->status_badge }}">{{ str_replace('_', ' ', ucfirst($p->status)) }}</span></td>
                        <td>Rp {{ number_format($p->harga_final ?? $p->estimasi_harga, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('pelanggan.pesanan.show', $p->pesanan_id) }}" 
                               class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada pesanan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $pesanan->links() }}
    </div>
</div>
@endsection