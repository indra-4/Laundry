@extends('layouts.app')

@section('title', 'Login - Awan Laundry')

@section('content')
<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-5" data-aos="zoom-in" data-aos-duration="600">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center mb-4" data-aos="fade-down" data-aos-delay="100">
                        <h1 class="display-4">☁️</h1>
                        <h3 class="mb-3">Awan Laundry</h3>
                        <p class="text-muted">Silakan login untuk melanjutkan</p>
                    </div>
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="mb-3" data-aos="fade-up" data-aos-delay="200">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3" data-aos="fade-up" data-aos-delay="300">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3 form-check" data-aos="fade-up" data-aos-delay="400">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ingat Saya</label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 py-2 mb-3" data-aos="fade-up" data-aos-delay="500">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </button>
                        
                        <div class="text-center mb-3">
                            <a class="btn btn-link p-0" href="{{ route('password.request') }}">Lupa password?</a>
                        </div>
                        
                        <div class="text-center">
                            <p class="mb-0">Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="text-center mt-3 text-muted">
                <small>Demo Login: pelanggan@example.com / password123</small>
            </div>
        </div>
    </div>
</div>
@endsection