<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Awan Laundry - Solusi Laundry Modern</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            color: white;
        }
        .feature-icon {
            font-size: 3rem;
            color: #667eea;
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-3 fw-bold mb-4">☁️ Awan Laundry</h1>
                    <p class="lead mb-4">Layanan laundry modern dengan sistem digital. Praktis, cepat, dan terpercaya!</p>
                    <div class="d-flex gap-3">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-light btn-lg px-5">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-5">
                                <i class="bi bi-person-plus"></i> Daftar
                            </a>
                        @else
                            <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="btn btn-light btn-lg px-5">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        @endguest
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="https://via.placeholder.com/500x400/667eea/ffffff?text=Laundry+Service" 
                         class="img-fluid rounded shadow-lg" alt="Laundry">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Keunggulan Kami</h2>
            <div class="row g-4">
                <div class="col-md-4 text-center">
                    <i class="bi bi-truck feature-icon"></i>
                    <h4 class="mt-3">Antar Jemput</h4>
                    <p>Layanan antar jemput gratis untuk kenyamanan Anda</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="bi bi-clock-history feature-icon"></i>
                    <h4 class="mt-3">Cepat & Tepat</h4>
                    <p>Proses pengerjaan cepat dengan hasil maksimal</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="bi bi-shield-check feature-icon"></i>
                    <h4 class="mt-3">Terpercaya</h4>
                    <p>Cucian aman dan terjamin kebersihannya</p>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>