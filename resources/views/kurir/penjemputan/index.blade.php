@extends('layouts.app')
@section('title', 'Penjemputan')
@section('page-title', 'Daftar Penjemputan')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-box-arrow-in-down"></i> Daftar Penjemputan</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="dijadwalkan" {{ request('status') == 'dijadwalkan' ? 'selected' : '' }}>Dijadwalkan</option>
                        <option value="dalam_perjalanan" {{ request('status') == 'dalam_perjalanan' ? 'selected' : '' }}>Dalam Perjalanan</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="gagal" {{ request('status') == 'gagal' ? 'selected' : '' }}>Gagal</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Filter
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
                        <th>Alamat</th>
                        <th>Status</th>
                        <th>Tanggal Jemput</th>
                        <th>Kurir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penjemputan as $p)
                    <tr>
                        <td><strong>{{ $p->pesanan->kode_booking }}</strong></td>
                        <td>{{ $p->pesanan->pelanggan->nama }}</td>
                        <td>{{ Str::limit($p->alamat, 50) }}</td>
                        <td>
                            @php
                                $badgeColor = match($p->status) {
                                    'dijadwalkan' => 'warning',
                                    'dalam_perjalanan' => 'info',
                                    'selesai' => 'success',
                                    'gagal' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $badgeColor }}">{{ ucfirst(str_replace('_', ' ', $p->status)) }}</span>
                        </td>
                        <td>
                            @if($p->tanggal_jemput)
                                {{ $p->tanggal_jemput->format('d/m/Y H:i') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($p->kurir)
                                {{ $p->kurir->nama }}
                            @else
                                <span class="text-muted">Belum diambil</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('kurir.penjemputan.show', $p->penjemputan_id) }}" 
                               class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-inbox"></i> Tidak ada penjemputan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $penjemputan->links() }}
    </div>
</div>
@endsection

