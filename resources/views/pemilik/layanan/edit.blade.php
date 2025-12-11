@extends('layouts.app')
@section('title', 'Edit Layanan')
@section('page-title', 'Edit Layanan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('pemilik.layanan.update', $layanan->layanan_id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Layanan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_layanan" class="form-control @error('nama_layanan') is-invalid @enderror" 
                               value="{{ old('nama_layanan', $layanan->nama_layanan) }}" required>
                        @error('nama_layanan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Jenis Layanan <span class="text-danger">*</span></label>
                        <select name="jenis" class="form-select @error('jenis') is-invalid @enderror" 
                                id="jenis" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="kiloan" {{ old('jenis', $layanan->jenis) == 'kiloan' ? 'selected' : '' }}>Kiloan</option>
                            <option value="satuan" {{ old('jenis', $layanan->jenis) == 'satuan' ? 'selected' : '' }}>Satuan</option>
                            <option value="express" {{ old('jenis', $layanan->jenis) == 'express' ? 'selected' : '' }}>Express</option>
                        </select>
                        @error('jenis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3" id="harga-kg-section" style="{{ old('jenis', $layanan->jenis) == 'satuan' ? 'display: none;' : '' }}">
                        <label class="form-label">Harga per Kg</label>
                        <input type="number" name="harga_per_kg" 
                               class="form-control @error('harga_per_kg') is-invalid @enderror" 
                               value="{{ old('harga_per_kg', $layanan->harga_per_kg) }}">
                        @error('harga_per_kg')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3" id="harga-satuan-section" style="{{ old('jenis', $layanan->jenis) == 'satuan' ? '' : 'display: none;' }}">
                        <label class="form-label">Harga per Item</label>
                        <input type="number" name="harga_satuan" 
                               class="form-control @error('harga_satuan') is-invalid @enderror" 
                               value="{{ old('harga_satuan', $layanan->harga_satuan) }}">
                        @error('harga_satuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Durasi Pengerjaan (hari) <span class="text-danger">*</span></label>
                        <input type="number" name="durasi_pengerjaan" 
                               class="form-control @error('durasi_pengerjaan') is-invalid @enderror" 
                               value="{{ old('durasi_pengerjaan', $layanan->durasi_pengerjaan) }}" required>
                        @error('durasi_pengerjaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $layanan->deskripsi) }}</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="status_aktif" value="1" 
                                   class="form-check-input" id="status_aktif" 
                                   {{ old('status_aktif', $layanan->status_aktif) ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_aktif">Aktifkan layanan</label>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update Layanan
                        </button>
                        <a href="{{ route('pemilik.layanan.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('jenis').addEventListener('change', function() {
    const hargaKg = document.getElementById('harga-kg-section');
    const hargaSatuan = document.getElementById('harga-satuan-section');
    
    if (this.value === 'satuan') {
        hargaKg.style.display = 'none';
        hargaSatuan.style.display = 'block';
    } else {
        hargaKg.style.display = 'block';
        hargaSatuan.style.display = 'none';
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const jenisSelect = document.getElementById('jenis');
    if (jenisSelect) {
        jenisSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush
@endsection

