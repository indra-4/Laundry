@extends('layouts.app')
@section('page-title', 'Kelola Pesanan')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Daftar Pesanan</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="dijemput" {{ request('status') == 'dijemput' ? 'selected' : '' }}>Dijemput</option>
                        <option value="ditimbang" {{ request('status') == 'ditimbang' ? 'selected' : '' }}>Ditimbang</option>
                        <option value="dicuci" {{ request('status') == 'dicuci' ? 'selected' : '' }}>Dicuci</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari kode booking atau nama pelanggan..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Kode Booking</th>
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanan as $p)
                    <tr>
                        <td><strong>{{ $p->kode_booking }}</strong></td>
                        <td>{{ $p->pelanggan->nama }}</td>
                        <td>{{ $p->layanan->nama_layanan }}</td>
                        <td><span class="badge bg-{{ $p->status_badge }}">{{ $p->status }}</span></td>
                        <td>{{ $p->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('karyawan.pesanan.show', $p->pesanan_id) }}" 
                               class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Tidak ada pesanan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $pesanan->links() }}
    </div>
</div>
@endsection
