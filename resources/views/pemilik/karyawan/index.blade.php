@extends('layouts.app')
@section('title', 'Kelola Karyawan')
@section('page-title', 'Kelola Karyawan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Daftar Karyawan & Kurir</h5>
    <a href="{{ route('pemilik.karyawan.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus"></i> Tambah
    </a>
    
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyawan as $u)
                    <tr>
                        <td>{{ $u->nama }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->no_hp }}</td>
                        <td>{{ ucfirst($u->role) }}</td>
                        <td>
                            <span class="badge bg-{{ $u->is_active ? 'success' : 'secondary' }}">{{ $u->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                        </td>
                        <td>
                            <a href="{{ route('pemilik.karyawan.edit', $u->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('pemilik.karyawan.destroy', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
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
            {{ $karyawan->links() }}
        </div>
    </div>
</div>
@endsection


