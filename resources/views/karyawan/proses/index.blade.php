@extends('layouts.app')
@section('page-title', 'Checklist Proses Laundry')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Daftar Proses yang Perlu Checklist</h5>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Kode Booking</th>
                        <th>Pelanggan</th>
                        <th>Tahapan</th>
                        <th>Karyawan</th>
                        <th>Waktu Mulai</th>
                        <th>Status Pesanan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proses as $p)
                    <tr>
                        <td><strong>{{ $p->pesanan->kode_booking }}</strong></td>
                        <td>{{ $p->pesanan->pelanggan->nama }}</td>
                        <td>
                            @php
                                $tahapanLabels = [
                                    'pencucian' => 'Pencucian',
                                    'pengeringan' => 'Pengeringan',
                                    'penyetrikaan' => 'Penyetrikaan',
                                    'pengemasan' => 'Pengemasan'
                                ];
                                $tahapanBadges = [
                                    'pencucian' => 'primary',
                                    'pengeringan' => 'info',
                                    'penyetrikaan' => 'warning',
                                    'pengemasan' => 'success'
                                ];
                            @endphp
                            <span class="badge bg-{{ $tahapanBadges[$p->tahapan] ?? 'secondary' }}">
                                {{ $tahapanLabels[$p->tahapan] ?? $p->tahapan }}
                            </span>
                        </td>
                        <td>{{ $p->karyawan ? $p->karyawan->name : 'Belum ditugaskan' }}</td>
                        <td>{{ $p->waktu_mulai ? $p->waktu_mulai->format('d/m/Y H:i') : '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $p->pesanan->status_badge }}">
                                {{ ucfirst(str_replace('_', ' ', $p->pesanan->status)) }}
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('karyawan.proses.checklist', $p->proses_id) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm w-100" 
                                        data-confirm="Yakin proses {{ $tahapanLabels[$p->tahapan] ?? $p->tahapan }} sudah selesai?">
                                    <i class="bi bi-check-circle"></i> Selesai
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-inbox"></i> Tidak ada proses yang perlu checklist
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $proses->links() }}
    </div>
</div>
@endsection

