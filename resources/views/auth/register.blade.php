@extends('layouts.app')

@section('title', 'Registrasi - Awan Laundry')

@extends('layouts.app')

@section('title', 'Daftar - Awan Laundry')

@push('styles')
<style>
    body {
        background-color: #ffffff !important;
    }
    /* Sembunyikan navbar dan sidebar dari layout utama saat di halaman register */
    .sidebar, .navbar-top {
        display: none !important;
    }
    .col-md-9.col-lg-10 {
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    .register-container {
        min-height: 100vh;
        display: flex;
    }
    .register-left {
        flex: 1;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 3rem;
        position: relative;
        overflow: hidden;
    }
    @media (min-width: 992px) {
        .register-left {
            display: flex;
        }
    }
    .register-right {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        max-width: 100%;
        background-color: #ffffff;
    }
    @media (min-width: 992px) {
        .register-right {
            max-width: 50%;
        }
    }
    .register-form-wrapper {
        width: 100%;
        max-width: 500px;
        margin-top: 2rem;
        margin-bottom: 2rem;
    }
    .btn-google {
        background-color: #ffffff;
        color: #334155;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }
    .btn-google:hover {
        background-color: #f8fafc;
        border-color: #cbd5e1;
    }
    .floating-shape {
        position: absolute;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        backdrop-filter: blur(5px);
    }
</style>
@endpush

@section('content')
<div style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 1050; background: white; overflow-y: auto;">
    <div class="register-container">
        <!-- Kiri: Ilustrasi -->
        <div class="register-left" style="position: fixed; left: 0; top: 0; bottom: 0; width: 50%;">
            <div class="floating-shape" style="width: 300px; height: 300px; top: -50px; left: -100px;"></div>
            <div class="floating-shape" style="width: 450px; height: 450px; bottom: -150px; right: -150px;"></div>
            
            <div class="text-center position-relative z-1" data-aos="fade-up">
                <div class="bg-white p-4 rounded-circle shadow-sm d-inline-block mb-4">
                    <i class="bi bi-person-hearts text-success" style="font-size: 4rem; line-height: 1;"></i>
                </div>
                <h1 class="display-5 fw-bold text-dark mb-3">Bergabung Bersama<br>Awan Laundry</h1>
                <p class="lead text-secondary mb-0">Rasakan pengalaman laundry yang lebih praktis<br>bersih, dan terpercaya mulai hari ini.</p>
            </div>
        </div>

        <!-- Spacer for fixed left layout -->
        <div class="d-none d-lg-block" style="width: 50%;"></div>

        <!-- Kanan: Form Register -->
        <div class="register-right">
            <div class="register-form-wrapper" data-aos="fade-left">
                <!-- Tampilan Mobile -->
                <div class="text-center d-lg-none mb-4">
                    <i class="bi bi-person-hearts text-success" style="font-size: 3rem;"></i>
                    <h2 class="fw-bold mt-2">Daftar Akun Baru</h2>
                </div>

                <div class="mb-4 d-none d-lg-block">
                    <h3 class="fw-bold text-dark">Daftar Akun Baru</h3>
                    <p class="text-muted">Isi form di bawah untuk mulai menggunakan Awan Laundry.</p>
                </div>
                
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label fw-medium">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                   id="nama" name="nama" value="{{ old('nama') }}" required autofocus placeholder="Budi Santoso">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_hp" class="form-label fw-medium">No. WhatsApp</label>
                            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" 
                                   id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required placeholder="0812...">
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label fw-medium">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="alamat" class="form-label fw-medium">Alamat Lengkap</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat" name="alamat" rows="2" required placeholder="Jl. Contoh No. 123...">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="role" class="form-label fw-medium">Daftar Sebagai</label>
                        <select class="form-select @error('role') is-invalid @enderror" 
                                id="role" name="role" required>
                            <option value="">Pilih Role...</option>
                            <option value="pelanggan" {{ old('role') == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                            <option value="karyawan" {{ old('role') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                            <option value="kurir" {{ old('role') == 'kurir' ? 'selected' : '' }}>Kurir</option>
                            <option value="pemilik" {{ old('role') == 'pemilik' ? 'selected' : '' }}>Pemilik (Admin)</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label fw-medium">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required placeholder="••••••••">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="password_confirmation" class="form-label fw-medium">Ulangi Password</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required placeholder="••••••••">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success btn-lg w-100 mb-3 fw-medium rounded-pill">
                        Buat Akun Sekarang
                    </button>
                    
                    <div class="position-relative mb-4 mt-4">
                        <hr class="text-muted">
                        <div class="position-absolute top-50 start-50 translate-middle px-3 bg-white text-muted small">
                            Atau daftar dengan
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-google btn-lg w-100 rounded-pill mb-4 d-flex align-items-center justify-content-center gap-2" onclick="alert('Fitur Daftar Google sedang dalam pengembangan.')">
                        <i class="bi bi-google text-danger"></i> Google
                    </button>
                    
                    <div class="text-center mt-4 mb-4">
                        <p class="text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-success">Masuk di sini</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection