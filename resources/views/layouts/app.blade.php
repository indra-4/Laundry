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
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @stack('styles')
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #ffffff;
            border-right: 1px solid #e2e8f0;
        }
        .sidebar .nav-link {
            color: #64748b;
            padding: 12px 20px;
            margin: 5px 15px;
            border-radius: 12px;
            transition: all 0.2s ease;
            font-weight: 500;
        }
        .sidebar .nav-link:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }
        .sidebar .nav-link.active {
            background-color: #eff6ff;
            color: #2563eb;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            font-size: 1.1rem;
        }
        
        .card {
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border-radius: 16px;
            transition: all 0.2s ease;
            background-color: #ffffff;
        }
        .card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            border-color: #cbd5e1;
            transform: translateY(-3px);
        }
        .badge-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .navbar-brand {
            font-weight: 800;
            font-size: 1.2rem;
            color: #2563eb !important;
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
        
        /* Role Specific Themes */
        
        /* Pemilik (Owner) - Dark Professional */
        .role-pemilik .sidebar {
            background-color: #1e293b;
            border-right: none;
            color: #f8fafc;
        }
        .role-pemilik .sidebar .text-primary {
            color: #60a5fa !important;
        }
        .role-pemilik .sidebar .text-muted {
            color: #94a3b8 !important;
        }
        .role-pemilik .sidebar .nav-link {
            color: #cbd5e1;
        }
        .role-pemilik .sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.05);
            color: #ffffff;
        }
        .role-pemilik .sidebar .nav-link.active {
            background-color: #3b82f6;
            color: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.4);
        }

        /* Pelanggan (Customer) - Fresh Green */
        .role-pelanggan .sidebar {
            background-color: #f0fdf4;
            border-right: 1px solid #bbf7d0;
        }
        .role-pelanggan .sidebar .text-primary {
            color: #16a34a !important;
        }
        .role-pelanggan .sidebar .nav-link {
            color: #475569;
        }
        .role-pelanggan .sidebar .nav-link:hover {
            background-color: #dcfce7;
            color: #166534;
        }
        .role-pelanggan .sidebar .nav-link.active {
            background-color: #22c55e;
            color: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(34, 197, 94, 0.4);
        }
        
        /* Kurir (Driver) - Warm Yellow/Orange */
        .role-kurir .sidebar {
            background-color: #fffbeb;
            border-right: 1px solid #fde68a;
        }
        .role-kurir .sidebar .text-primary {
            color: #d97706 !important;
        }
        .role-kurir .sidebar .nav-link {
            color: #475569;
        }
        .role-kurir .sidebar .nav-link:hover {
            background-color: #fef3c7;
            color: #b45309;
        }
        .role-kurir .sidebar .nav-link.active {
            background-color: #f59e0b;
            color: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.4);
        }
        
        /* Glassmorphism Classes */
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="@auth role-{{ auth()->user()->role }} @endauth">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @auth
            <div class="col-md-3 col-lg-2 px-0 sidebar d-md-block d-none">
                <div class="text-center py-4">
                    <div class="px-3 text-start">
                        <h4 class="text-primary fw-bold mb-1"><i class="bi bi-cloud-fill"></i> Awan Laundry</h4>
                        <small class="text-muted d-block mb-2 fw-medium">{{ ucfirst(auth()->user()->role) }}</small>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
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
            
            <!-- Mobile Offcanvas Sidebar -->
            <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
                <div class="offcanvas-header border-bottom">
                    <h5 class="offcanvas-title text-primary fw-bold" id="sidebarMenuLabel"><i class="bi bi-cloud-fill"></i> Awan Laundry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body px-0">
                    <div class="px-4 mb-3">
                        <small class="text-muted d-block mb-2 fw-medium">Halo, {{ auth()->user()->nama }} ({{ ucfirst(auth()->user()->role) }})</small>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3 w-100">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </div>
                    <nav class="nav flex-column sidebar-mobile-nav">
                        @include('partials.sidebar-' . auth()->user()->role)
                    </nav>
                </div>
            </div>
            @endauth
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ms-sm-auto px-md-4 @guest col-12 @endguest">
                <!-- Topbar -->
                @auth
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom navbar-top">
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-light d-md-none border" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
                            <i class="bi bi-list fs-5"></i>
                        </button>
                        <h1 class="h2 mb-0">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <div class="dropdown">
                                <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" id="notifDropdownToggle">
                                    <i class="bi bi-bell"></i>
                                    <span class="badge bg-danger" id="notifBadge">{{ auth()->user()->notifikasi()->unread()->count() }}</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" id="notifList" style="width: 300px; max-height: 400px; overflow-y: auto;">
                                    @forelse(auth()->user()->notifikasi()->unread()->latest()->take(5)->get() as $notif)
                                        <li data-notif-id="{{ $notif->notifikasi_id }}">
                                            <div class="dropdown-item-text">
                                                <strong>{{ $notif->judul }}</strong>
                                                <p class="mb-0 small text-muted">{{ $notif->pesan }}</p>
                                                <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                                            </div>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                    @empty
                                        <li class="empty-notif"><span class="dropdown-item-text text-muted">Tidak ada notifikasi</span></li>
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

                <!-- Toast Container for Real-time Notifications -->
                <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
                    <div id="realtimeToast" class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                <strong id="toastTitle">Notifikasi Baru</strong><br>
                                <span id="toastMessage">Ada pembaruan status pesanan Anda.</span>
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
                
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
            // Hide loader immediately
            pageLoader.classList.remove('active');
            
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

    <!-- Real-time Notification Script -->
    @auth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let badgeEl = document.getElementById('notifBadge');
            let lastNotifCount = badgeEl ? (parseInt(badgeEl.innerText) || 0) : 0;
            const notifList = document.getElementById('notifList');
            const toastEl = document.getElementById('realtimeToast');
            const bsToast = toastEl ? new bootstrap.Toast(toastEl, { delay: 5000 }) : null;

            function checkNotifications() {
                fetch('{{ route("notifications.unread") }}', {
                    headers: { 'Accept': 'application/json' }
                })
                .then(response => response.json())
                .then(data => {
                    const currentCount = data.count || 0;
                    if (badgeEl) badgeEl.innerText = currentCount;
                    
                    if (currentCount !== lastNotifCount && data.notifications && data.notifications.length > 0) {
                        // Check if we need to show toast (only if it increased)
                        if (currentCount > lastNotifCount) {
                            const newest = data.notifications[0];
                            const title = newest.judul || newest.title || 'Notifikasi Baru';
                            const message = newest.pesan || newest.message || 'Ada pembaruan status pesanan.';
                            
                            if (document.getElementById('toastTitle')) {
                                document.getElementById('toastTitle').innerText = title;
                                document.getElementById('toastMessage').innerText = message;
                                if (bsToast) bsToast.show();
                            }
                        }
                        
                        // Always update the dropdown list HTML when count changes
                        if (notifList) {
                            let html = '';
                            data.notifications.forEach(notif => {
                                const nTitle = notif.judul || notif.title || 'Informasi';
                                const nMessage = notif.pesan || notif.message || 'Anda memiliki pemberitahuan baru.';
                                html += `
                                    <li data-notif-id="${notif.notifikasi_id || ''}">
                                        <div class="dropdown-item-text">
                                            <strong>${nTitle}</strong>
                                            <p class="mb-0 small text-muted">${nMessage}</p>
                                            <small class="text-muted">Baru saja</small>
                                        </div>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                `;
                            });
                            notifList.innerHTML = html;
                        }
                    } else if (currentCount === 0 && notifList) {
                        notifList.innerHTML = '<li class="empty-notif"><span class="dropdown-item-text text-muted">Tidak ada notifikasi</span></li>';
                    }
                    
                    lastNotifCount = currentCount;
                })
                .catch(error => console.error('Error fetching notifications:', error));
            }

            // Poll every 15 seconds
            setInterval(checkNotifications, 15000);
            
            // Mark as read when clicking dropdown toggle
            const dropdownToggle = document.getElementById('notifDropdownToggle');
            if (dropdownToggle) {
                dropdownToggle.addEventListener('click', function() {
                    if (lastNotifCount > 0) {
                        // Optimistically update UI
                        if (badgeEl) badgeEl.innerText = '0';
                        lastNotifCount = 0;
                        
                        // Use GET to avoid CSRF issues on ephemeral Vercel sessions
                        fetch('{{ route("notifications.read-all") }}', {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json'
                            }
                        }).then(response => {
                            if (!response.ok) {
                                console.error("Failed to mark notifications as read");
                            }
                        }).catch(err => console.error(err));
                    }
                });
            }
        });
    </script>
    @endauth
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Global SweetAlert confirmation for forms (create, update, delete, confirm)
            document.querySelectorAll('form[method="POST"] button[type="submit"]').forEach(btn => {
                const form = btn.closest('form');
                if (!form) return;
                
                const action = form.getAttribute('action') || '';
                // Skip auth and chat forms
                if (action.includes('/login') || action.includes('/register') || action.includes('/logout') || action.includes('/chat')) {
                    return;
                }
                
                btn.addEventListener('click', function(e) {
                    if (this.dataset.sweetalertHandled) return;
                    e.preventDefault();
                    
                    const buttonEl = this;
                    
                    let actionText = "menyimpan data ini";
                    let confirmButtonText = "Ya, Simpan!";
                    let confirmColor = "#0d6efd"; // Primary
                    let iconType = "question";
                    
                    const isDelete = buttonEl.classList.contains('btn-danger') || form.querySelector('input[name="_method"][value="DELETE"]');
                    const isSuccess = buttonEl.classList.contains('btn-success');
                    
                    if (isDelete) {
                        actionText = "menghapus data ini";
                        confirmButtonText = "Ya, Hapus!";
                        confirmColor = "#dc3545"; // Danger
                        iconType = "warning";
                    } else if (isSuccess) {
                        actionText = "mengonfirmasi aksi ini";
                        confirmButtonText = "Ya, Lanjutkan!";
                        confirmColor = "#198754"; // Success
                    }
                    
                    const customMsg = buttonEl.getAttribute('data-confirm') || form.getAttribute('data-confirm');
                    if (customMsg) {
                        actionText = customMsg.toLowerCase().startsWith('yakin') || customMsg.toLowerCase().startsWith('apakah') 
                                        ? customMsg 
                                        : `Apakah Anda yakin ingin ${customMsg}?`;
                        if (customMsg.includes('?')) {
                            actionText = customMsg;
                        }
                    } else {
                        actionText = `Apakah Anda yakin ingin ${actionText}?`;
                    }

                    Swal.fire({
                        title: 'Konfirmasi Aksi',
                        text: actionText,
                        icon: iconType,
                        showCancelButton: true,
                        confirmButtonColor: confirmColor,
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: confirmButtonText,
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            buttonEl.dataset.sweetalertHandled = 'true';
                            buttonEl.click();
                        }
                    });
                });
            });

            // Keep basic a-tag confirmation for any plain links with data-confirm
            document.querySelectorAll('a[data-confirm]').forEach(el => {
                el.addEventListener('click', function(e) {
                    e.preventDefault();
                    const btn = this;
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: btn.getAttribute('data-confirm'),
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Lanjutkan!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = btn.href;
                        }
                    });
                });
            });
        });
    </script>
    
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
