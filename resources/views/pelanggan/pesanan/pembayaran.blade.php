@extends('layouts.app')
@section('page-title', 'Pembayaran')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-credit-card"></i> Pembayaran Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <strong>Kode Booking:</strong> {{ $pesanan->kode_booking }}<br>
                    <strong>Total Harga:</strong> 
                    <h4 class="mb-0 mt-2">Rp {{ number_format($pesanan->harga_final ?? $pesanan->estimasi_harga, 0, ',', '.') }}</h4>
                </div>

                <form method="POST" action="{{ route('pelanggan.pesanan.upload-bukti', $pesanan->pesanan_id) }}" 
                      enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                        <select name="metode_pembayaran" class="form-select @error('metode_pembayaran') is-invalid @enderror" required>
                            <option value="">-- Pilih Metode --</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="ewallet">E-Wallet (OVO/DANA/GoPay)</option>
                            <option value="qris">QRIS</option>
                            <option value="tunai">Tunai (Bayar di Tempat)</option>
                        </select>
                        @error('metode_pembayaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" id="bukti-section">
                        <label class="form-label">Upload Bukti Transfer</label>
                        <input type="file" name="bukti_transfer" 
                               class="form-control @error('bukti_transfer') is-invalid @enderror" 
                               accept="image/*">
                        @error('bukti_transfer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format: JPG, PNG (Max 2MB)</small>
                    </div>

                    <div class="card bg-light mb-3">
                        <div class="card-body">
                            <h6>Informasi Rekening:</h6>
                            <p class="mb-1"><strong>Bank BCA</strong>: 1234567890 a.n. Awan Laundry</p>
                            <p class="mb-1"><strong>Bank BRI</strong>: 0987654321 a.n. Awan Laundry</p>
                            <p class="mb-0"><strong>OVO/DANA</strong>: 081234567890</p>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-check-circle"></i> Konfirmasi Pembayaran
                        </button>
                        <a href="{{ route('pelanggan.pesanan.show', $pesanan->pesanan_id) }}" 
                           class="btn btn-outline-secondary">
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
document.querySelector('[name="metode_pembayaran"]').addEventListener('change', function() {
    const buktiSection = document.getElementById('bukti-section');
    if (this.value === 'tunai') {
        buktiSection.style.display = 'none';
    } else {
        buktiSection.style.display = 'block';
    }
});
</script>
@endpush
@endsection