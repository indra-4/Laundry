@extends('layouts.app')

@section('title', 'Login - Awan Laundry')

@extends('layouts.app')

@section('title', 'Login - Awan Laundry')

@push('styles')
<style>
    body {
        background-color: #ffffff !important;
    }
    /* Sembunyikan navbar dan sidebar dari layout utama saat di halaman login */
    .sidebar, .navbar-top {
        display: none !important;
    }
    .col-md-9.col-lg-10 {
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    .login-container {
        min-height: 100vh;
        display: flex;
    }
    .login-left {
        flex: 1;
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 3rem;
        position: relative;
        overflow: hidden;
    }
    @media (min-width: 992px) {
        .login-left {
            display: flex;
        }
    }
    .login-right {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        max-width: 100%;
        background-color: #ffffff;
    }
    @media (min-width: 992px) {
        .login-right {
            max-width: 50%;
        }
    }
    .login-form-wrapper {
        width: 100%;
        max-width: 420px;
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
        background: rgba(255, 255, 255, 0.4);
        border-radius: 50%;
        backdrop-filter: blur(5px);
    }
</style>
@endpush

@section('content')
<!-- Kita paksa agar container fluid bawaan app.blade.php tidak membatasi layout split kita -->
<div style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 1050; background: white;">
    <div class="login-container">
        <!-- Kiri: Ilustrasi -->
        <div class="login-left">
            <div class="floating-shape" style="width: 300px; height: 300px; top: -100px; left: -100px;"></div>
            <div class="floating-shape" style="width: 400px; height: 400px; bottom: -150px; right: -100px;"></div>
            
            <div class="text-center position-relative z-1" data-aos="fade-up">
                <div class="bg-white p-4 rounded-circle shadow-sm d-inline-block mb-4">
                    <i class="bi bi-cloud-fill text-primary" style="font-size: 4rem; line-height: 1;"></i>
                </div>
                <h1 class="display-5 fw-bold text-dark mb-3">Selamat Datang di<br>Awan Laundry</h1>
                <p class="lead text-secondary mb-0">Platform manajemen laundry cerdas Anda.<br>Pantau pesanan, kurir, dan pendapatan secara real-time.</p>
            </div>
        </div>

        <!-- Kanan: Form Login -->
        <div class="login-right">
            <div class="login-form-wrapper" data-aos="fade-left">
                <!-- Tampilan Mobile -->
                <div class="text-center d-lg-none mb-4 mt-5 mt-lg-0">
                    <i class="bi bi-cloud-fill text-primary" style="font-size: 3rem;"></i>
                    <h2 class="fw-bold mt-2">Awan Laundry</h2>
                </div>

                <div class="mb-4">
                    <h3 class="fw-bold text-dark">Masuk ke Akun</h3>
                    <p class="text-muted">Masukkan email dan password Anda untuk melanjutkan.</p>
                </div>
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="email" class="form-label fw-medium">Email</label>
                        <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="password" class="form-label fw-medium mb-0">Password</label>
                            
                            <!-- WA Reset Link -->
                            @php
                                $waAdmin = "6281234567890";
                                $pesanWA = "Halo Admin Awan Laundry, saya lupa password akun saya dan ingin meminta reset password. Email saya: ";
                            @endphp
                            <a class="text-decoration-none small text-primary fw-medium" 
                               href="https://wa.me/{{ $waAdmin }}?text={{ urlencode($pesanWA) }}" 
                               target="_blank" title="Hubungi CS via WhatsApp">Lupa password?</a>
                        </div>
                        <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" 
                               id="password" name="password" required placeholder="••••••••">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label text-muted" for="remember">Ingat Saya</label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg w-100 mb-3 fw-medium rounded-pill">
                        Masuk Sekarang
                    </button>
                    
                    <div class="position-relative mb-4 mt-4">
                        <hr class="text-muted">
                        <div class="position-absolute top-50 start-50 translate-middle px-3 bg-white text-muted small">
                            Atau masuk dengan
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-google btn-lg w-100 rounded-pill mb-4 d-flex align-items-center justify-content-center gap-2" onclick="alert('Fitur Login Google sedang dalam pengembangan.')">
                        <i class="bi bi-google text-danger"></i> Google
                    </button>
                    
                    <div class="text-center mt-4 mb-4">
                        <p class="text-muted">Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none fw-bold">Daftar Sekarang</a></p>
                    </div>
                </form>
                
                <div class="text-center mt-5 mb-3">
                    <div class="bg-light p-3 rounded-3 border">
                        <small class="text-muted d-block fw-medium mb-1"><i class="bi bi-info-circle me-1"></i> Demo Akun</small>
                        <small class="text-secondary">pelanggan@example.com / password123</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection