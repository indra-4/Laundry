<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Awan Laundry - Solusi Laundry Bersih & Cepat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #2563eb;
            --light-blue: #eff6ff;
            --text-dark: #1e293b;
            --text-muted: #64748b;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-dark);
            background-color: #ffffff;
        }
        
        /* Navbar */
        .navbar {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #f1f5f9;
        }
        .navbar-brand {
            font-weight: 800;
            color: var(--primary-blue) !important;
        }
        .btn-primary-custom {
            background-color: var(--primary-blue);
            color: white;
            font-weight: 600;
            border-radius: 50rem;
            padding: 0.5rem 1.5rem;
            border: none;
            transition: all 0.2s;
        }
        .btn-primary-custom:hover {
            background-color: #1d4ed8;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }
        .btn-outline-custom {
            color: var(--text-dark);
            background-color: white;
            border: 1px solid #e2e8f0;
            font-weight: 600;
            border-radius: 50rem;
            padding: 0.5rem 1.5rem;
            transition: all 0.2s;
        }
        .btn-outline-custom:hover {
            background-color: #f8fafc;
            border-color: #cbd5e1;
        }

        /* Hero Section */
        .hero-section {
            padding-top: 120px;
            padding-bottom: 80px;
            background: linear-gradient(180deg, var(--light-blue) 0%, #ffffff 100%);
        }
        .hero-title {
            font-weight: 800;
            font-size: 3.5rem;
            line-height: 1.2;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
        }
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-section {
                padding-top: 100px;
                padding-bottom: 50px;
            }
        }
        .hero-title span {
            color: var(--primary-blue);
        }
        .hero-subtitle {
            font-size: 1.15rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        
        /* Mockup Card */
        .image-card {
            background: white;
            border-radius: 24px;
            padding: 1.5rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
        }
        
        .mockup-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: var(--light-blue);
            border-radius: 16px;
            margin-bottom: 1rem;
        }
        .mockup-icon {
            width: 48px;
            height: 48px;
            background: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--primary-blue);
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        }

        /* Stats */
        .stat-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: white;
            border-radius: 50rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            font-weight: 600;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                <i class="bi bi-cloud-fill fs-3"></i>
                Awan Laundry
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <!-- Nav items removed -->
                </ul>
                <div class="d-flex gap-2 mt-3 mt-lg-0">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-custom">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-primary-custom">Daftar Sekarang</a>
                    @else
                        <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="btn btn-primary-custom">
                            <i class="bi bi-grid-1x2-fill me-2"></i>Dashboard
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center gy-5">
                <div class="col-lg-6 text-center text-lg-start pe-lg-5">
                    <div class="stat-badge text-primary mb-4">
                        <i class="bi bi-star-fill text-warning"></i> Solusi Cerdas Laundry Anda
                    </div>
                    <h1 class="hero-title">
                        Cucian Bersih,<br>
                        <span>Hidup Lebih Mudah.</span>
                    </h1>
                    <p class="hero-subtitle">
                        Awan Laundry hadir untuk memberikan kemudahan. Pesan layanan, pantau proses cuci, hingga pengantaran kurir langsung dari genggaman Anda.
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-primary-custom px-5 py-3 fs-5">
                                Mulai Pesanan <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        @else
                            <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="btn btn-primary-custom px-5 py-3 fs-5">
                                Ke Dashboard <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        @endguest
                    </div>
                    
                    <div class="mt-5 d-flex gap-4 justify-content-center justify-content-lg-start text-muted fw-medium">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-check2-circle text-success fs-5"></i>
                            Antar Jemput
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-check2-circle text-success fs-5"></i>
                            Pantau Real-time
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mt-5 mt-lg-0">
                    <div class="image-card position-relative">
                        <!-- Floating element -->
                        <div class="position-absolute stat-badge text-success" style="top: -15px; right: -15px; z-index: 2;">
                            <i class="bi bi-patch-check-fill"></i> Selesai Tepat Waktu
                        </div>
                        
                        <div class="p-2">
                            <h5 class="fw-bold mb-4">Aktivitas Pesanan</h5>
                            
                            <div class="mockup-item">
                                <div class="mockup-icon text-primary">
                                    <i class="bi bi-basket2-fill"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">Cuci Setrika Reguler</div>
                                    <div class="text-muted small">Status: Sedang Dicuci</div>
                                </div>
                                <div class="ms-auto text-end">
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 rounded-3">Berjalan</span>
                                </div>
                            </div>
                            
                            <div class="mockup-item" style="background-color: #f0fdf4;">
                                <div class="mockup-icon text-success">
                                    <i class="bi bi-truck"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">Pengantaran Pakaian</div>
                                    <div class="text-muted small">Kurir: Budi Santoso</div>
                                </div>
                                <div class="ms-auto text-end">
                                    <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-3">Menuju Lokasi</span>
                                </div>
                            </div>
                            
                            <div class="mockup-item bg-white border mt-4">
                                <div class="mockup-icon bg-light text-muted">
                                    <i class="bi bi-check-lg"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">Cuci Kering Ekspres</div>
                                    <div class="text-muted small">Selesai kemarin</div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 border-top mt-5">
        <div class="container text-center text-muted">
            <p class="mb-0 small">&copy; {{ date('Y') }} Awan Laundry. Dikelola dengan sistem terintegrasi.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>