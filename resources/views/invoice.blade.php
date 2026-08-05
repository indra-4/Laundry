<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $pesanan->kode_booking }}</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #f8fafc;
            color: #000;
        }
        .invoice-box {
            max-width: 800px;
            margin: 30px auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            background-color: #fff;
        }
        .invoice-header {
            border-bottom: 2px dashed #000;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .invoice-table th, .invoice-table td {
            border-bottom: 1px dashed #ddd;
            padding: 10px 0;
        }
        .total-row {
            border-top: 2px dashed #000;
            font-weight: bold;
            font-size: 1.2rem;
        }
        
        @media print {
            body { background-color: #fff; }
            .invoice-box {
                box-shadow: none;
                border: none;
                margin: 0;
                padding: 0;
                width: 100%;
                max-width: 100%;
            }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="text-end mt-4 mb-2 no-print">
            <button onclick="window.print()" class="btn btn-primary"><i class="bi bi-printer"></i> Cetak PDF</button>
            @php
                $backUrl = url()->previous();
                if(auth()->check()) {
                    $role = auth()->user()->role;
                    if($role === 'pelanggan') $backUrl = route('pelanggan.pesanan.show', $pesanan->pesanan_id);
                    elseif($role === 'karyawan') $backUrl = route('karyawan.pesanan.show', $pesanan->pesanan_id);
                    elseif($role === 'pemilik') $backUrl = route('pemilik.pesanan.index');
                }
            @endphp
            <a href="{{ $backUrl }}" class="btn btn-secondary">Kembali</a>
        </div>

        <div class="invoice-box">
            <div class="invoice-header d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-0">AWAN LAUNDRY</h2>
                    <p class="mb-0 text-muted">Jl. Bersih Selalu No. 123, Kota Anda</p>
                    <p class="mb-0 text-muted">Telp: 0812-3456-7890</p>
                </div>
                <div class="text-end">
                    <h4 class="fw-bold">INVOICE</h4>
                    <p class="mb-0">#{{ $pesanan->kode_booking }}</p>
                    <p class="mb-0">{{ $pesanan->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-sm-6">
                    <h6 class="fw-bold text-muted mb-1">Kepada:</h6>
                    <h5 class="fw-bold">{{ $pesanan->pelanggan->nama }}</h5>
                    <p class="mb-0">{{ $pesanan->pelanggan->no_hp }}</p>
                    <p class="mb-0">{{ $pesanan->pelanggan->alamat }}</p>
                </div>
                <div class="col-sm-6 text-end">
                    <h6 class="fw-bold text-muted mb-1">Status Pembayaran:</h6>
                    @if($pesanan->pembayaran && $pesanan->pembayaran->status === 'berhasil')
                        <h4 class="text-success fw-bold border border-success d-inline-block px-3 py-1 rounded">SUDAH DIBAYAR / LUNAS</h4>
                    @elseif($pesanan->pembayaran && $pesanan->pembayaran->status === 'menunggu')
                        <h4 class="text-warning fw-bold border border-warning d-inline-block px-3 py-1 rounded">MENUNGGU KONFIRMASI</h4>
                    @else
                        <h4 class="text-danger fw-bold border border-danger d-inline-block px-3 py-1 rounded">BELUM DIBAYAR</h4>
                    @endif
                </div>
            </div>

            <table class="table invoice-table table-borderless">
                <thead>
                    <tr class="border-bottom border-dark">
                        <th>Layanan</th>
                        <th class="text-center">Berat (Kg)</th>
                        <th class="text-end">Harga/Kg</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>{{ $pesanan->layanan->nama_layanan }}</strong>
                            <br>
                            <small class="text-muted">{{ $pesanan->catatan ?? '-' }}</small>
                        </td>
                        <td class="text-center">{{ $pesanan->berat_aktual ?? $pesanan->estimasi_berat }}</td>
                        <td class="text-end">Rp {{ number_format($pesanan->layanan->harga, 0, ',', '.') }}</td>
                        <td class="text-end">
                            Rp {{ number_format(($pesanan->berat_aktual ?? $pesanan->estimasi_berat) * $pesanan->layanan->harga, 0, ',', '.') }}
                        </td>
                    </tr>
                    
                    @if($pesanan->metode_antar !== 'antar_sendiri')
                    <tr>
                        <td colspan="3">Biaya Antar/Jemput</td>
                        <td class="text-end">Rp 0 (Gratis)</td>
                    </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="3" class="text-end pt-3">TOTAL KESELURUHAN</td>
                        <td class="text-end pt-3 text-primary">Rp {{ number_format($pesanan->harga_final ?? $pesanan->estimasi_harga, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>

            <div class="mt-5 text-center">
                <p class="text-muted mb-1">Terima kasih telah mempercayakan cucian Anda kepada Awan Laundry!</p>
                <p class="text-muted small">Barang yang tidak diambil lebih dari 30 hari di luar tanggung jawab kami.</p>
            </div>
        </div>
    </div>
</body>
</html>
