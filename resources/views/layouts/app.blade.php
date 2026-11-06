<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EduTech - Platform Kelas Online Teknologi Terdepan')</title>
    <!-- Meta SEO -->
    <meta name="description" content="Tingkatkan keahlian teknologi Anda bersama praktisi industri berpengalaman di EduTech.">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #334155;
            background-color: #f8fafc;
        }
        .navbar {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95);
        }
        .nav-link {
            font-weight: 500;
            color: #475569;
            transition: color 0.2s ease;
        }
        .nav-link:hover, .nav-link.active {
            color: #2563eb;
        }
        .hero-section {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #3b82f6 100%);
            color: white;
            padding: 80px 0 100px;
            position: relative;
            overflow: hidden;
        }
        .hero-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.15) 1px, transparent 1px);
            background-size: 24px 24px;
            opacity: 0.7;
        }
        .card-course {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: #ffffff;
        }
        .card-course:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
            border-color: #cbd5e1;
        }
        .course-img-wrapper {
            position: relative;
            height: 200px;
            overflow: hidden;
            background-color: #e2e8f0;
        }
        .course-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .card-course:hover .course-img-wrapper img {
            transform: scale(1.05);
        }
        .badge-cat {
            background-color: rgba(37, 99, 235, 0.1);
            color: #2563eb;
            font-weight: 600;
            font-size: 0.75rem;
            padding: 6px 12px;
            border-radius: 20px;
        }
        .btn-primary {
            background-color: #2563eb;
            border-color: #2563eb;
            font-weight: 600;
            padding: 10px 22px;
            border-radius: 10px;
        }
        .btn-primary:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
        }
        .btn-outline-primary {
            color: #2563eb;
            border-color: #2563eb;
            font-weight: 600;
            border-radius: 10px;
        }
        .btn-outline-primary:hover {
            background-color: #2563eb;
            color: #ffffff;
        }
        .footer {
            background-color: #0f172a;
            color: #94a3b8;
        }
        .footer h5 {
            color: #ffffff;
        }
        .footer a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .footer a:hover {
            color: #ffffff;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg sticky-top border-bottom py-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                <span class="bg-primary text-white rounded-3 p-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px;">
                    <i class="bi bi-mortarboard-fill fs-5"></i>
                </span>
                <span class="fw-bold fs-4 text-dark tracking-tight">Edu<span class="text-primary">Tech</span></span>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <i class="bi bi-list fs-2"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#daftar-kelas">Daftar Kelas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('articles.*') ? 'active' : '' }}" href="{{ route('articles.index') }}">Blog / Artikel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#kontak">Kontak</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary btn-sm px-3">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard Admin
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-light btn-sm text-danger border">
                                <i class="bi bi-box-arrow-right"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm px-4">
                            <i class="bi bi-lock-fill me-1"></i> Login Admin
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <main>
        @if(session('success'))
            <div class="container mt-4">
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill fs-4 me-3 text-success"></i>
                    <div>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container mt-4">
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-danger"></i>
                    <div>
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="footer pt-5 pb-4 mt-5">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="bg-primary text-white rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="bi bi-mortarboard-fill"></i>
                        </span>
                        <h4 class="fw-bold text-white mb-0">EduTech</h4>
                    </div>
                    <p class="small">Lembaga pelatihan teknologi online terpercaya yang membimbing talenta digital Indonesia meraih karir impian di industri teknologi modern.</p>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-bold text-white mb-3">Navigasi</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('home') }}#daftar-kelas">Daftar Kelas</a></li>
                        <li><a href="{{ route('articles.index') }}">Blog & Artikel</a></li>
                        <li><a href="{{ route('login') }}">Portal Pengelola</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold text-white mb-3">Kategori Populer</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2">
                        <li><a href="{{ route('home') }}?category=web-development#daftar-kelas">Web Development</a></li>
                        <li><a href="{{ route('home') }}?category=mobile-app-development#daftar-kelas">Mobile App Development</a></li>
                        <li><a href="{{ route('home') }}?category=data-science-ai#daftar-kelas">Data Science & AI</a></li>
                        <li><a href="{{ route('home') }}?category=ui-ux-design#daftar-kelas">UI/UX Design</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6" id="kontak">
                    <h6 class="fw-bold text-white mb-3">Hubungi Kami</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2">
                        <li class="d-flex align-items-start gap-2">
                            <i class="bi bi-geo-alt-fill text-primary mt-1"></i>
                            <span>Jl. Teknologi Raya No. 42, Jakarta Selatan, Indonesia</span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-whatsapp text-success"></i>
                            <span>+62 812-8023-5585</span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-envelope-fill text-primary"></i>
                            <span>info@edutech.ac.id</span>
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="border-secondary my-4">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small text-muted">
                <p class="mb-0">&copy; {{ date('Y') }} EduTech. Technical Test Magang - All Rights Reserved.</p>
                <div class="d-flex gap-3 mt-2 mt-md-0">
                    <span>Dibuat dengan Laravel 13 & Bootstrap 5</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
