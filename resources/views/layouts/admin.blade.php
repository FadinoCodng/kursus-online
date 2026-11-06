<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - EduTech Admin</title>
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
            background-color: #f1f5f9;
            color: #334155;
            min-height: 100vh;
        }
        .sidebar {
            width: 260px;
            background-color: #0f172a;
            min-height: 100vh;
            color: #94a3b8;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            transition: all 0.3s;
        }
        .main-wrapper {
            margin-left: 260px;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .sidebar-brand {
            padding: 24px 20px;
            color: #ffffff;
            font-size: 1.25rem;
            font-weight: 700;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .sidebar-nav {
            padding: 16px 12px;
            list-style: none;
            margin: 0;
        }
        .sidebar-nav-title {
            font-size: 0.72rem;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.05em;
            color: #64748b;
            padding: 12px 12px 6px;
        }
        .nav-item-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 8px;
            color: #94a3b8;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.92rem;
            margin-bottom: 4px;
            transition: all 0.2s ease;
        }
        .nav-item-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.06);
        }
        .nav-item-link.active {
            color: #ffffff;
            background-color: #2563eb;
            font-weight: 600;
        }
        .admin-topbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card-custom {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }
        @media (max-width: 991.98px) {
            .sidebar {
                margin-left: -260px;
            }
            .sidebar.show {
                margin-left: 0;
            }
            .main-wrapper {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <span class="bg-primary text-white rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                <i class="bi bi-mortarboard-fill"></i>
            </span>
            <span>EduTech <small class="text-primary fs-6">Admin</small></span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-nav-title">Menu Utama</li>
            <li>
                <a href="{{ route('admin.dashboard') }}" class="nav-item-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 fs-5"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="sidebar-nav-title">Master Data</li>
            <li>
                <a href="{{ route('admin.categories.index') }}" class="nav-item-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="bi bi-tags fs-5"></i>
                    <span>Kelola Kategori</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.courses.index') }}" class="nav-item-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-bookmark fs-5"></i>
                    <span>Kelola Kelas</span>
                </a>
            </li>

            <li class="sidebar-nav-title">Pendaftaran</li>
            <li>
                <a href="{{ route('admin.registrations.index') }}" class="nav-item-link {{ request()->routeIs('admin.registrations.*') ? 'active' : '' }}">
                    <i class="bi bi-people fs-5"></i>
                    <span>Data Pendaftar</span>
                </a>
            </li>

            <li class="sidebar-nav-title">Konten & Bonus</li>
            <li>
                <a href="{{ route('admin.articles.index') }}" class="nav-item-link {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                    <i class="bi bi-newspaper fs-5"></i>
                    <span>Artikel / Blog</span>
                </a>
            </li>
            <li>
                <a href="{{ route('home') }}" target="_blank" class="nav-item-link text-info">
                    <i class="bi bi-box-arrow-up-right fs-5"></i>
                    <span>Lihat Landing Page</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- MAIN CONTENT WRAPPER -->
    <div class="main-wrapper">
        <!-- TOPBAR -->
        <header class="admin-topbar">
            <button class="btn btn-light d-lg-none border" type="button" onclick="document.getElementById('sidebar').classList.toggle('show')">
                <i class="bi bi-list fs-5"></i>
            </button>

            <div class="d-none d-md-block text-muted small">
                <i class="bi bi-calendar3 me-1"></i> {{ now()->translatedFormat('l, d F Y') }}
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px;">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="d-none d-sm-block text-end">
                        <div class="fw-semibold small leading-tight">{{ auth()->user()->name ?? 'Admin' }}</div>
                        <div class="text-muted" style="font-size: 0.75rem;">{{ auth()->user()->email }}</div>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm px-3" title="Keluar">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <main class="p-4 flex-grow-1">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-check-circle-fill fs-5 me-2 text-success"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-5 me-2 text-danger"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4">
                    <div class="fw-bold mb-1"><i class="bi bi-exclamation-circle me-1"></i> Terjadi Kesalahan Pengisian:</div>
                    <ul class="mb-0 ps-3 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- FOOTER -->
        <footer class="bg-white border-top py-3 px-4 text-center text-muted small">
            &copy; {{ date('Y') }} <strong>EduTech Dashboard Admin</strong> &bull; Technical Test Pembuatan Website Kelas Online Sederhana
        </footer>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
