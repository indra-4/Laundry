@extends('layouts.app')
@section('title', 'Detail Penjemputan')
@section('page-title', 'Detail Penjemputan')

@section('content')
<div class="row g-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-box-arrow-in-down"></i> Detail Penjemputan</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-4"><strong>Kode Booking:</strong></div>
                    <div class="col-8"><strong>{{ $penjemputan->pesanan->kode_booking }}</strong></div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Pelanggan:</strong></div>
                    <div class="col-8">{{ $penjemputan->pesanan->pelanggan->nama }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Telepon:</strong></div>
                    <div class="col-8">{{ $penjemputan->pesanan->pelanggan->telepon ?? '-' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Alamat Penjemputan:</strong></div>
                    <div class="col-8">{{ $penjemputan->alamat }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Status:</strong></div>
                    <div class="col-8">
                        @php
                            $badgeColor = match($penjemputan->status) {
                                'dijadwalkan' => 'warning',
                                'dalam_perjalanan' => 'info',
                                'selesai' => 'success',
                                'gagal' => 'danger',
                                default => 'secondary'
                            };
                        @endphp
                        <span class="badge bg-{{ $badgeColor }}">{{ ucfirst(str_replace('_', ' ', $penjemputan->status)) }}</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Tanggal Jemput:</strong></div>
                    <div class="col-8">
                        @if($penjemputan->tanggal_jemput)
                            {{ $penjemputan->tanggal_jemput->format('d/m/Y H:i') }}
                        @else
                            <span class="text-muted">Belum ditentukan</span>
                        @endif
                    </div>
                </div>
                @if($penjemputan->kurir)
                <div class="row mb-3">
                    <div class="col-4"><strong>Kurir:</strong></div>
                    <div class="col-8">{{ $penjemputan->kurir->nama }}</div>
                </div>
                @endif
                @if($penjemputan->catatan)
                <div class="row mb-3">
                    <div class="col-4"><strong>Catatan:</strong></div>
                    <div class="col-8">{{ $penjemputan->catatan }}</div>
                </div>
                @endif
                @if($penjemputan->latitude && $penjemputan->longitude)
                <div class="row mb-3">
                    <div class="col-4"><strong>Lokasi:</strong></div>
                    <div class="col-8">
                        <a href="https://www.google.com/maps?q={{ $penjemputan->latitude }},{{ $penjemputan->longitude }}" 
                           target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-geo-alt"></i> Lihat di Google Maps
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6><i class="bi bi-map"></i> Peta Lokasi Penjemputan</h6>
            </div>
            <div class="card-body">
                <div id="map" style="height: 400px; width: 100%; border-radius: 8px;"></div>
                <p class="text-muted mt-2 small">
                    <i class="bi bi-info-circle"></i> Klik pada peta untuk melihat rute ke lokasi penjemputan
                </p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6><i class="bi bi-info-circle"></i> Informasi Pesanan</h6>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-4"><strong>Layanan:</strong></div>
                    <div class="col-8">{{ $penjemputan->pesanan->layanan->nama_layanan ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4"><strong>Estimasi Berat:</strong></div>
                    <div class="col-8">{{ $penjemputan->pesanan->estimasi_berat ?? '-' }} kg</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4"><strong>Status Pesanan:</strong></div>
                    <div class="col-8">
                        <span class="badge bg-{{ $penjemputan->pesanan->status_badge ?? 'secondary' }}">
                            {{ ucfirst(str_replace('_', ' ', $penjemputan->pesanan->status)) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        @if($penjemputan->status == 'dijadwalkan' && !$penjemputan->kurir_id)
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="bi bi-play-circle"></i> Ambil Tugas</h6>
            </div>
            <div class="card-body">
                <p class="text-muted">Ambil tugas penjemputan ini dan mulai perjalanan.</p>
                <form method="POST" action="{{ route('kurir.penjemputan.mulai', $penjemputan->penjemputan_id) }}">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-play-fill"></i> Mulai Penjemputan
                    </button>
                </form>
            </div>
        </div>
        @endif

        @if($penjemputan->status == 'dalam_perjalanan' && $penjemputan->kurir_id == auth()->id())
        <div class="card">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="bi bi-check-circle"></i> Selesaikan Penjemputan</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('kurir.penjemputan.selesai', $penjemputan->penjemputan_id) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Latitude (Opsional)</label>
                        <input type="number" step="0.00000001" name="latitude" class="form-control" 
                               placeholder="Contoh: -6.200000">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Longitude (Opsional)</label>
                        <input type="number" step="0.00000001" name="longitude" class="form-control" 
                               placeholder="Contoh: 106.816666">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan (Opsional)</label>
                        <textarea name="catatan" class="form-control" rows="3" 
                                  placeholder="Catatan penjemputan..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-check-circle-fill"></i> Selesaikan Penjemputan
                    </button>
                </form>
            </div>
        </div>
        @endif

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-arrow-left"></i> Kembali</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('kurir.penjemputan.index') }}" class="btn btn-secondary w-100">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map { z-index: 1; }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const address = @json($penjemputan->alamat);
        
        // Initialize map dengan default location (Jakarta)
        const map = L.map('map').setView([-6.200000, 106.816666], 13);
        
        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19
        }).addTo(map);

        // Geocode address menggunakan Nominatim (OpenStreetMap geocoding service)
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}&limit=1`)
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    const lat = parseFloat(data[0].lat);
                    const lon = parseFloat(data[0].lon);
                    
                    // Set map view ke lokasi yang ditemukan
                    map.setView([lat, lon], 15);
                    
                    // Add marker
                    const marker = L.marker([lat, lon]).addTo(map);
                    
                    // Add popup dengan informasi
                    marker.bindPopup(`
                        <div style="min-width: 200px;">
                            <strong>Alamat Penjemputan</strong><br>
                            ${address}<br>
                            <a href="https://www.openstreetmap.org/directions?to=${lat},${lon}" 
                               target="_blank" class="btn btn-sm btn-primary mt-2" style="text-decoration: none; display: inline-block;">
                                <i class="bi bi-navigation"></i> Buka Navigasi
                            </a>
                        </div>
                    `).openPopup();
                } else {
                    // Jika geocoding gagal, tampilkan pesan
                    document.getElementById("map").innerHTML = `
                        <div class="p-4 text-center">
                            <i class="bi bi-exclamation-triangle text-warning" style="font-size: 2rem;"></i>
                            <p class="mt-2">Tidak dapat menemukan lokasi untuk alamat ini.</p>
                            <p class="text-muted small">${address}</p>
                            <a href="https://www.openstreetmap.org/search?q=${encodeURIComponent(address)}" 
                               target="_blank" class="btn btn-primary mt-2">
                                <i class="bi bi-geo-alt"></i> Cari di OpenStreetMap
                            </a>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error geocoding:', error);
                // Fallback: tampilkan peta default dengan marker di tengah
                const marker = L.marker([-6.200000, 106.816666]).addTo(map);
                marker.bindPopup(`
                    <div>
                        <strong>Alamat Penjemputan</strong><br>
                        ${address}<br>
                        <small class="text-muted">Lokasi tidak dapat ditentukan secara otomatis</small>
                    </div>
                `).openPopup();
            });
    });
</script>
@endpush
@endsection
