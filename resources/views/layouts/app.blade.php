<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Awan Laundry')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <!-- AOS (Animate On Scroll) CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    @stack('styles')
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #4e73df 0%, #224abe 100%);
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 5px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.1);
            transition: left 0.3s ease;
        }
        .sidebar .nav-link:hover::before {
            left: 0;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
            transform: translateX(5px);
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }
        .sidebar .nav-link:hover i {
            transform: scale(1.2);
        }
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
        }
        .badge-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        /* Page Transition Animations */
        .page-transition {
            animation: fadeInUp 0.5s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Input Animations */
        .form-control, .form-select {
            transition: all 0.3s ease;
            border: 2px solid #e0e0e0;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
            transform: translateY(-2px);
        }
        
        .form-control:valid {
            border-color: #28a745;
        }
        
        .form-control:invalid:not(:placeholder-shown) {
            border-color: #dc3545;
        }
        
        /* Button Animations */
        .btn {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        /* Table Row Animations */
        .table tbody tr {
            transition: all 0.3s ease;
        }
        
        .table tbody tr:hover {
            background-color: #f8f9fa;
            transform: scale(1.01);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        /* Progress Bar Animation */
        .progress-bar {
            transition: width 1s ease-in-out;
        }
        
        /* Loading Spinner */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
        }
        
        .page-loader.active {
            opacity: 1;
            visibility: visible;
        }
        
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #4e73df;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Alert Animations */
        .alert {
            animation: slideInRight 0.5s ease-out;
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        /* Card Stats Animation */
        .stat-card {
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            transition: transform 0.5s ease;
        }
        
        .stat-card:hover::after {
            transform: scale(1.5);
        }
        
        /* Badge Pulse Animation */
        .badge {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
            }
        }
        
        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @auth
            <div class="col-md-3 col-lg-2 px-0 sidebar d-md-block d-none">
                <div class="text-center py-4">
                    <div class="px-3 text-start">
                        <h4 class="text-white mb-1">☁️ Awan Laundry</h4>
                        <small class="text-white-50 d-block mb-2">{{ ucfirst(auth()->user()->role) }}</small>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-light btn-sm">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
                
                <nav class="nav flex-column">
                    @include('partials.sidebar-' . auth()->user()->role)
                </nav>
                
                <!-- removed bottom logout block -->
            </div>
            @endauth
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ms-sm-auto px-md-4 @guest col-12 @endguest">
                <!-- Topbar -->
                @auth
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('page-title', 'Dashboard')</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <div class="dropdown">
                                <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-bell"></i>
                                    <span class="badge bg-danger">{{ auth()->user()->notifikasi()->unread()->count() }}</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" style="width: 300px; max-height: 400px; overflow-y: auto;">
                                    @forelse(auth()->user()->notifikasi()->unread()->latest()->take(5)->get() as $notif)
                                        <li>
                                            <div class="dropdown-item-text">
                                                <strong>{{ $notif->judul }}</strong>
                                                <p class="mb-0 small text-muted">{{ $notif->pesan }}</p>
                                                <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                                            </div>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                    @empty
                                        <li><span class="dropdown-item-text text-muted">Tidak ada notifikasi</span></li>
                                    @endforelse
                                </ul>
                            </div>
                            <button class="btn btn-light" type="button" data-bs-toggle="modal" data-bs-target="#profileModal">
                                <i class="bi bi-person-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endauth
                
                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <!-- Page Content -->
                <main class="pb-5 page-transition">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <!-- AOS (Animate On Scroll) JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Page Transition & Animation Script -->
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });
        
        // Page Loader
        const pageLoader = document.createElement('div');
        pageLoader.className = 'page-loader';
        pageLoader.innerHTML = '<div class="spinner"></div>';
        document.body.appendChild(pageLoader);
        
        // Show loader on page navigation
        document.addEventListener('DOMContentLoaded', function() {
            // Hide loader after page loads
            setTimeout(() => {
                pageLoader.classList.remove('active');
            }, 300);
            
            // Add click handlers to all links
            const links = document.querySelectorAll('a[href^="/"], a[href^="http"]');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Only show loader for internal links
                    if (this.href && !this.href.includes('#') && !this.target) {
                        const href = this.getAttribute('href');
                        if (href && (href.startsWith('/') || href.includes(window.location.hostname))) {
                            pageLoader.classList.add('active');
                        }
                    }
                });
            });
            
            // Handle form submissions
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    pageLoader.classList.add('active');
                });
            });
            
            // Animate progress bars on load
            const progressBars = document.querySelectorAll('.progress-bar');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 300);
            });
            
            // Add stagger animation to cards
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });
        
        // Handle browser back/forward
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                pageLoader.classList.remove('active');
            }
        });
    </script>
    
    @stack('scripts')
    
    <!-- Profile Modal -->
    @auth
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">
                        <i class="bi bi-person-circle"></i> Profil Pengguna
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @php
                        $user = auth()->user();
                    @endphp
                    <div class="text-center mb-4">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; font-size: 2.5rem;">
                            <i class="bi bi-person"></i>
                        </div>
                        <h4 class="mt-3 mb-1">{{ $user->nama }}</h4>
                        <span class="badge bg-info">{{ ucfirst($user->role) }}</span>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-envelope text-primary fs-5"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <label class="form-label text-muted mb-0 small">Email</label>
                                    <p class="mb-0 fw-semibold">{{ $user->email }}</p>
                                </div>
                            </div>
                        </div>
                        
                        @if($user->no_hp)
                        <div class="col-12">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-telephone text-primary fs-5"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <label class="form-label text-muted mb-0 small">No. Telepon</label>
                                    <p class="mb-0 fw-semibold">{{ $user->no_hp }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($user->alamat)
                        <div class="col-12">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-geo-alt text-primary fs-5"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <label class="form-label text-muted mb-0 small">Alamat</label>
                                    <p class="mb-0 fw-semibold">{{ $user->alamat }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <div class="col-12">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-shield-check text-primary fs-5"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <label class="form-label text-muted mb-0 small">Status</label>
                                    <p class="mb-0">
                                        @if($user->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-calendar text-primary fs-5"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <label class="form-label text-muted mb-0 small">Bergabung Sejak</label>
                                    <p class="mb-0 fw-semibold">{{ $user->created_at->format('d F Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endauth
</body>
</html>
