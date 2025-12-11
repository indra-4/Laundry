<!-- ========================================
FILE: resources/views/pelanggan/pesanan/create.blade.php
======================================== -->
@extends('layouts.app')

@section('title', 'Buat Pesanan Baru')
@section('page-title', 'Buat Pesanan Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form Pemesanan Laundry</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('pelanggan.pesanan.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Pilih Layanan <span class="text-danger">*</span></label>
                        <select name="layanan_id" class="form-select @error('layanan_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Layanan --</option>
                            @foreach($layanan as $item)
                                <option value="{{ $item->layanan_id }}" 
                                        data-jenis="{{ $item->jenis }}"
                                        data-harga="{{ $item->jenis === 'kiloan' ? $item->harga_per_kg : $item->harga_satuan }}"
                                        {{ old('layanan_id') == $item->layanan_id ? 'selected' : '' }}>
                                    {{ $item->nama_layanan }} - 
                                    Rp {{ number_format($item->jenis === 'kiloan' ? $item->harga_per_kg : $item->harga_satuan, 0, ',', '.') }}
                                    /{{ $item->jenis === 'kiloan' ? 'kg' : 'item' }}
                                    ({{ $item->durasi_pengerjaan }} hari)
                                </option>
                            @endforeach
                        </select>
                        @error('layanan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Estimasi Berat/Jumlah <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" step="0.1" name="estimasi_berat" 
                                   class="form-control @error('estimasi_berat') is-invalid @enderror" 
                                   value="{{ old('estimasi_berat') }}" required id="estimasi_berat">
                            <span class="input-group-text" id="satuan-label">kg</span>
                        </div>
                        @error('estimasi_berat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Masukkan perkiraan berat cucian dalam kilogram</small>
                    </div>
                    
                    <div class="mb-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6>Estimasi Harga:</h6>
                                <h3 class="text-primary mb-0" id="estimasi-harga">Rp 0</h3>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Metode Pengambilan <span class="text-danger">*</span></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="metode_antar" 
                                   value="antar_sendiri" id="antar_sendiri" required
                                   {{ old('metode_antar', 'antar_sendiri') == 'antar_sendiri' ? 'checked' : '' }}>
                            <label class="form-check-label" for="antar_sendiri">
                                <strong>Antar Sendiri</strong> ke Toko
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="metode_antar" 
                                   value="dijemput" id="dijemput"
                                   {{ old('metode_antar') == 'dijemput' ? 'checked' : '' }}>
                            <label class="form-check-label" for="dijemput">
                                <strong>Dijemput</strong> Kurir (Gratis)
                            </label>
                        </div>
                        @error('metode_antar')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3" id="alamat-jemput-section" style="display: none;">
                        <label class="form-label">Alamat Penjemputan</label>
                        <textarea name="alamat_jemput" class="form-control @error('alamat_jemput') is-invalid @enderror" 
                                  rows="3">{{ old('alamat_jemput', auth()->user()->alamat) }}</textarea>
                        @error('alamat_jemput')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Catatan Tambahan</label>
                        <textarea name="catatan" class="form-control" rows="3" 
                                  placeholder="Contoh: Pisahkan baju putih dan berwarna">{{ old('catatan') }}</textarea>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-check-circle"></i> Buat Pesanan
                        </button>
                        <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-outline-secondary">
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
document.addEventListener('DOMContentLoaded', function() {
    const layananSelect = document.querySelector('[name="layanan_id"]');
    const estimasiInput = document.getElementById('estimasi_berat');
    const estimasiHarga = document.getElementById('estimasi-harga');
    const satuanLabel = document.getElementById('satuan-label');
    const metodeAntar = document.querySelectorAll('[name="metode_antar"]');
    const alamatSection = document.getElementById('alamat-jemput-section');
    
    function hitungEstimasi() {
        const selectedOption = layananSelect.options[layananSelect.selectedIndex];
        const harga = selectedOption.dataset.harga || 0;
        const jenis = selectedOption.dataset.jenis || 'kiloan';
        const berat = parseFloat(estimasiInput.value) || 0;
        
        satuanLabel.textContent = jenis === 'kiloan' ? 'kg' : 'item';
        
        const total = harga * berat;
        estimasiHarga.textContent = 'Rp ' + total.toLocaleString('id-ID');
    }
    
    layananSelect.addEventListener('change', hitungEstimasi);
    estimasiInput.addEventListener('input', hitungEstimasi);
    
    metodeAntar.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'dijemput') {
                alamatSection.style.display = 'block';
            } else {
                alamatSection.style.display = 'none';
            }
        });
        
        if (radio.checked && radio.value === 'dijemput') {
            alamatSection.style.display = 'block';
        }
    });
});
</script>
@endpush
@endsection