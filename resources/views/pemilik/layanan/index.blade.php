@extends('layouts.app')
@section('title', 'Kelola Layanan')
@section('page-title', 'Kelola Layanan')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Layanan</h5>
        <a href="{{ route('pemilik.layanan.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Layanan
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama Layanan</th>
                        <th>Jenis</th>
                        <th>Harga</th>
                        <th>Durasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($layanan as $item)
                    <tr>
                        <td><strong>{{ $item->nama_layanan }}</strong></td>
                        <td><span class="badge bg-secondary">{{ ucfirst($item->jenis) }}</span></td>
                        <td>
                            @if($item->jenis === 'kiloan')
                                Rp {{ number_format($item->harga_per_kg, 0, ',', '.') }}/kg
                            @else
                                Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}/item
                            @endif
                        </td>
                        <td>{{ $item->durasi_pengerjaan }} hari</td>
                        <td>
                            @if($item->status_aktif)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('pemilik.layanan.edit', $item->layanan_id) }}" 
                               class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('pemilik.layanan.destroy', $item->layanan_id) }}" 
                                  method="POST" class="d-inline" 
                                  onsubmit="return confirm('Yakin hapus layanan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $layanan->links() }}
    </div>
</div>
@endsection
