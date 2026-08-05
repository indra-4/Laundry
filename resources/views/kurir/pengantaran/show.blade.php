@extends('layouts.app')
@section('title', 'Detail Pengantaran')
@section('page-title', 'Detail Pengantaran')

@section('content')
<div class="row g-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-box-arrow-up"></i> Detail Pengantaran</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-4"><strong>Kode Booking:</strong></div>
                    <div class="col-8"><strong>{{ $pengantaran->pesanan->kode_booking }}</strong></div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Pelanggan:</strong></div>
                    <div class="col-8">{{ $pengantaran->pesanan->pelanggan->nama }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Telepon:</strong></div>
                    <div class="col-8">{{ $pengantaran->pesanan->pelanggan->telepon ?? '-' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Alamat Pengantaran:</strong></div>
                    <div class="col-8">
                        {{ $pengantaran->alamat }}
                        <br>
                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($pengantaran->alamat) }}" 
                           target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="bi bi-geo-alt"></i> Buka di Google Maps
                        </a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Status:</strong></div>
                    <div class="col-8">
                        @php
                            $badgeColor = match($pengantaran->status) {
                                'dijadwalkan' => 'warning',
                                'dalam_perjalanan' => 'info',
                                'selesai' => 'success',
                                'gagal' => 'danger',
                                default => 'secondary'
                            };
                        @endphp
                        <span class="badge bg-{{ $badgeColor }}">{{ ucfirst(str_replace('_', ' ', $pengantaran->status)) }}</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Tanggal Antar:</strong></div>
                    <div class="col-8">
                        @if($pengantaran->tanggal_antar)
                            {{ $pengantaran->tanggal_antar->format('d/m/Y H:i') }}
                        @else
                            <span class="text-muted">Belum ditentukan</span>
                        @endif
                    </div>
                </div>
                @if($pengantaran->kurir)
                <div class="row mb-3">
                    <div class="col-4"><strong>Kurir:</strong></div>
                    <div class="col-8">{{ $pengantaran->kurir->nama }}</div>
                </div>
                @endif
                @if($pengantaran->catatan)
                <div class="row mb-3">
                    <div class="col-4"><strong>Catatan:</strong></div>
                    <div class="col-8">{{ $pengantaran->catatan }}</div>
                </div>
                @endif
                @if($pengantaran->latitude && $pengantaran->longitude)
                <div class="row mb-3">
                    <div class="col-4"><strong>Lokasi:</strong></div>
                    <div class="col-8">
                        <a href="https://www.openstreetmap.org/?mlat={{ $pengantaran->latitude }}&mlon={{ $pengantaran->longitude }}&zoom=15" 
                           target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-geo-alt"></i> Lihat di Peta
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6><i class="bi bi-map"></i> Peta Lokasi</h6>
            </div>
            <div class="card-body">
                <div id="map" style="height: 400px; width: 100%; border-radius: 8px;"></div>
                <p class="text-muted mt-2 small">
                    <i class="bi bi-info-circle"></i> Klik pada peta untuk melihat rute ke lokasi pengantaran
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
                    <div class="col-8">{{ $pengantaran->pesanan->layanan->nama_layanan ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4"><strong>Estimasi Berat:</strong></div>
                    <div class="col-8">{{ $pengantaran->pesanan->estimasi_berat ?? '-' }} kg</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4"><strong>Status Pesanan:</strong></div>
                    <div class="col-8">
                        <span class="badge bg-{{ $pengantaran->pesanan->status_badge ?? 'secondary' }}">
                            {{ ucfirst(str_replace('_', ' ', $pengantaran->pesanan->status)) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        @if($pengantaran->status == 'dijadwalkan' && !$pengantaran->kurir_id)
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="bi bi-play-circle"></i> Ambil Tugas</h6>
            </div>
            <div class="card-body">
                <p class="text-muted">Ambil tugas pengantaran ini dan mulai perjalanan.</p>
                <form method="POST" action="{{ route('kurir.pengantaran.mulai', $pengantaran->pengantaran_id) }}">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-play-fill"></i> Mulai Pengantaran
                    </button>
                </form>
            </div>
        </div>
        @endif

        @if($pengantaran->status == 'dalam_perjalanan' && $pengantaran->kurir_id == auth()->id())
        <div class="card">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="bi bi-check-circle"></i> Selesaikan Pengantaran</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('kurir.pengantaran.selesai', $pengantaran->pengantaran_id) }}">
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
                                  placeholder="Catatan pengantaran..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-check-circle-fill"></i> Selesaikan Pengantaran
                    </button>
                </form>
            </div>
        </div>
        @endif

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-chat-dots"></i> Chat</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('kurir.chat.show', $pengantaran->pesanan_id) }}" class="btn btn-info w-100 mb-2">
                    <i class="bi bi-chat"></i> Chat dengan Pelanggan
                </a>
                <a href="{{ route('kurir.pengantaran.index') }}" class="btn btn-secondary w-100">
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
        const address = @json($pengantaran->alamat);
        
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
                            <strong>Alamat Pengantaran</strong><br>
                            ${address}<br>
                            <a href="https://www.openstreetmap.org/directions?to=${lat},${lon}" 
                               target="_blank" class="btn btn-sm btn-primary mt-2" style="text-decoration: none; display: inline-block;">
                                <i class="bi bi-navigation"></i> Buka Navigasi
                            </a>
                        </div>
                    `).openPopup();
                } else {
                    // Jika geocoding gagal, tetap tampilkan map default
                    const fallbackLat = -6.200000;
                    const fallbackLon = 106.816666;
                    map.setView([fallbackLat, fallbackLon], 10);
                    
                    const marker = L.marker([fallbackLat, fallbackLon]).addTo(map);
                    marker.bindPopup(`
                        <div style="min-width: 200px;" class="text-center">
                            <i class="bi bi-exclamation-triangle text-warning fs-4"></i><br>
                            <strong>Lokasi tidak ditemukan akurat di Peta Leaflet</strong><br>
                            <small class="text-muted">${address}</small><br>
                            <a href="https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(address)}" 
                               target="_blank" class="btn btn-sm btn-primary mt-2 d-inline-block" style="text-decoration: none;">
                                <i class="bi bi-geo-alt"></i> Buka Google Maps
                            </a>
                        </div>
                    `).openPopup();
                }
            })
            .catch(error => {
                console.error('Error geocoding:', error);
                // Fallback: tampilkan peta default dengan marker di tengah
                const fallbackLat = -6.200000;
                const fallbackLon = 106.816666;
                map.setView([fallbackLat, fallbackLon], 10);
                
                const marker = L.marker([fallbackLat, fallbackLon]).addTo(map);
                marker.bindPopup(`
                    <div style="min-width: 200px;" class="text-center">
                        <i class="bi bi-exclamation-triangle text-warning fs-4"></i><br>
                        <strong>Gagal memuat koordinat Peta</strong><br>
                        <small class="text-muted">${address}</small><br>
                        <a href="https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(address)}" 
                           target="_blank" class="btn btn-sm btn-primary mt-2 d-inline-block" style="text-decoration: none;">
                            <i class="bi bi-geo-alt"></i> Buka Google Maps
                        </a>
                    </div>
                `).openPopup();
            });
    });
</script>
@endpush
@endsection

