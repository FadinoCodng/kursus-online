@extends('layouts.app')

@section('title', 'EduTech - Tingkatkan Keahlian Digital Bersama Mentor Ahli')

@section('content')
    <!-- HERO SECTION -->
    <section class="hero-section text-center text-lg-start">
        <div class="hero-pattern"></div>
        <div class="container position-relative">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <span class="badge bg-white text-primary fw-semibold px-3 py-2 rounded-pill mb-3 shadow-sm">
                        <i class="bi bi-stars text-warning me-1"></i> Platform Pelatihan Teknologi No. 1
                    </span>
                    <h1 class="display-4 fw-extrabold text-white mb-3">
                        Kuasai Keahlian Digital Modern Bersama <span class="text-warning">Mentor Berpengalaman</span>
                    </h1>
                    <p class="lead text-white-50 mb-4 pe-lg-4">
                        Tingkatkan karier Anda di bidang Web Development, Mobile Apps, Data Science, dan UI/UX Design dengan kurikulum praktis dan bimbingan intensif langsung dari praktisi industri.
                    </p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                        <a href="#daftar-kelas" class="btn btn-warning btn-lg px-4 fw-bold shadow">
                            <i class="bi bi-compass me-2"></i> Jelajahi Kelas
                        </a>
                        <a href="#kontak" class="btn btn-outline-light btn-lg px-4">
                            Konsultasi Gratis
                        </a>
                    </div>

                    <!-- STATS ROW -->
                    <div class="row g-4 mt-4 pt-3 border-top border-white-10 text-white">
                        <div class="col-4">
                            <h3 class="fw-bold mb-0 text-white">100%</h3>
                            <small class="text-white-50">Praktik Nyata</small>
                        </div>
                        <div class="col-4">
                            <h3 class="fw-bold mb-0 text-white">500+</h3>
                            <small class="text-white-50">Alumni Sukses</small>
                        </div>
                        <div class="col-4">
                            <h3 class="fw-bold mb-0 text-white">4.9/5</h3>
                            <small class="text-white-50">Rating Kepuasan</small>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 d-none d-lg-block">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&auto=format&fit=crop&q=80" 
                             alt="Belajar Online" 
                             class="img-fluid rounded-4 shadow-lg border border-4 border-white">
                        <div class="position-absolute bottom-0 start-0 translate-middle-y bg-white p-3 rounded-3 shadow text-dark ms-n3 border">
                            <div class="d-flex align-items-center gap-3">
                                <span class="bg-success text-white p-2 rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-shield-check fs-5"></i>
                                </span>
                                <div>
                                    <div class="fw-bold small">Sertifikat Kelulusan</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">Diakui industri teknologi</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SEARCH & FILTER SECTION -->
    <section class="py-5" id="daftar-kelas">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge-cat mb-2 d-inline-block">KATALOG PROGRAM</span>
                <h2 class="fw-bold text-dark">Pilihan Kelas Online Siap Kerja</h2>
                <p class="text-muted">Pilih program yang tepat untuk mempercepat akselerasi karier digital Anda</p>
            </div>

            <!-- FILTER BOX -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <form action="{{ route('home') }}#daftar-kelas" method="GET" class="row g-3">
                    <!-- Search Input -->
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label small fw-semibold text-muted">Cari Kelas atau Instruktur</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control bg-light border-start-0" placeholder="Ketik kata kunci...">
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-semibold text-muted">Kategori</label>
                        <select name="category" class="form-select bg-light">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                                    {{ $cat->name }} ({{ $cat->courses_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Pricing Filter -->
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-semibold text-muted">Tipe Kelas</label>
                        <select name="pricing" class="form-select bg-light">
                            <option value="">Semua Tipe</option>
                            <option value="free" {{ request('pricing') === 'free' ? 'selected' : '' }}>Gratis (Free)</option>
                            <option value="paid" {{ request('pricing') === 'paid' ? 'selected' : '' }}>Berbayar</option>
                        </select>
                    </div>

                    <!-- Button Action -->
                    <div class="col-lg-2 col-md-6 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-filter"></i> Filter
                        </button>
                        @if(request()->anyFilled(['q', 'category', 'pricing']))
                            <a href="{{ route('home') }}#daftar-kelas" class="btn btn-light border text-danger" title="Reset Filter">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Category Pill Badges for quick click -->
                <div class="d-flex flex-wrap gap-2 mt-3 pt-3 border-top">
                    <span class="small text-muted align-self-center me-2">Kategori Populer:</span>
                    <a href="{{ route('home') }}#daftar-kelas" class="badge {{ !request('category') ? 'bg-primary text-white' : 'bg-light text-secondary border' }} text-decoration-none py-2 px-3 rounded-pill">
                        Semua
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('home') }}?category={{ $cat->slug }}#daftar-kelas" class="badge {{ request('category') === $cat->slug ? 'bg-primary text-white' : 'bg-light text-secondary border' }} text-decoration-none py-2 px-3 rounded-pill">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- COURSE LIST -->
            @if($courses->count() > 0)
                <div class="row g-4">
                    @foreach($courses as $course)
                        <div class="col-lg-4 col-md-6">
                            <div class="card card-course h-100 shadow-sm d-flex flex-column">
                                <div class="course-img-wrapper">
                                    <img src="{{ $course->image_url }}" alt="{{ $course->title }}">
                                    <div class="position-absolute top-0 end-0 m-3">
                                        @if($course->is_free)
                                            <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm">GRATIS</span>
                                        @else
                                            <span class="badge bg-primary px-3 py-2 rounded-pill shadow-sm">{{ $course->formatted_price }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body p-4 d-flex flex-column flex-grow-1">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="badge-cat">{{ $course->category->name ?? 'Umum' }}</span>
                                        <span class="small text-muted"><i class="bi bi-star-fill text-warning me-1"></i>4.9</span>
                                    </div>

                                    <h5 class="fw-bold text-dark mb-2 line-clamp-2">
                                        <a href="{{ route('courses.show', $course->slug) }}" class="text-dark text-decoration-none hover-primary">
                                            {{ $course->title }}
                                        </a>
                                    </h5>

                                    <p class="text-muted small mb-4 flex-grow-1">
                                        {{ Str::limit($course->description, 110) }}
                                    </p>

                                    <div class="pt-3 border-top mt-auto d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-secondary-subtle text-primary rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="bi bi-person-fill"></i>
                                            </div>
                                            <div class="small fw-semibold text-truncate" style="max-width: 140px;" title="{{ $course->instructor_name }}">
                                                {{ $course->instructor_name }}
                                            </div>
                                        </div>
                                        <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-outline-primary btn-sm">
                                            Detail Kelas <i class="bi bi-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- PAGINATION -->
                <div class="mt-5 d-flex justify-content-center">
                    {{ $courses->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="text-center py-5 bg-white rounded-4 border">
                    <i class="bi bi-search fs-1 text-muted mb-3 d-block"></i>
                    <h5 class="fw-bold text-dark">Tidak ada kelas yang ditemukan</h5>
                    <p class="text-muted mb-3">Silakan gunakan kata kunci pencarian lain atau reset filter kategori.</p>
                    <a href="{{ route('home') }}#daftar-kelas" class="btn btn-outline-primary">Reset Pencarian</a>
                </div>
            @endif
        </div>
    </section>

    <!-- HIGHLIGHT SECTION / KEUNGGULAN -->
    <section class="py-5 bg-white border-top border-bottom">
        <div class="container py-4">
            <div class="text-center mb-5">
                <span class="badge-cat mb-2 d-inline-block">KENAPA MEMILIH KAMI?</span>
                <h2 class="fw-bold text-dark">Fasilitas Belajar Standar Industri</h2>
            </div>
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <div class="p-4 rounded-4 bg-light h-100">
                        <div class="bg-primary text-white rounded-3 mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                            <i class="bi bi-laptop fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Kurikulum Terkini</h5>
                        <p class="text-muted small mb-0">Materi selalu diperbarui sesuai kebutuhan nyata perusahaan teknologi saat ini.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 rounded-4 bg-light h-100">
                        <div class="bg-success text-white rounded-3 mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                            <i class="bi bi-person-video3 fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Mentor Profesional</h5>
                        <p class="text-muted small mb-0">Belajar langsung dari praktisi yang berpengalaman di startup dan enterprise.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 rounded-4 bg-light h-100">
                        <div class="bg-warning text-white rounded-3 mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                            <i class="bi bi-patch-check-fill fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Portfolio Riil</h5>
                        <p class="text-muted small mb-0">Setiap kelulusan menghasilkan proyek nyata yang siap dipamerkan di CV dan LinkedIn Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BLOG SECTION (FITUR BONUS) -->
    @if($articles->count() > 0)
        <section class="py-5">
            <div class="container">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <div>
                        <span class="badge-cat mb-2 d-inline-block">ARTIKEL TERBARU</span>
                        <h2 class="fw-bold text-dark mb-0">Wawasan & Tips Teknologi</h2>
                    </div>
                    <a href="{{ route('articles.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua Artikel &rarr;</a>
                </div>
                <div class="row g-4">
                    @foreach($articles as $art)
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 border rounded-4 overflow-hidden shadow-sm bg-white">
                                <img src="{{ $art->image_url }}" alt="{{ $art->title }}" style="height: 180px; object-fit: cover;">
                                <div class="card-body p-4 d-flex flex-column">
                                    <div class="text-muted small mb-2"><i class="bi bi-calendar3 me-1"></i> {{ $art->created_at->format('d M Y') }} &bull; Oleh {{ $art->author }}</div>
                                    <h5 class="fw-bold mb-2">
                                        <a href="{{ route('articles.show', $art->slug) }}" class="text-dark text-decoration-none">
                                            {{ $art->title }}
                                        </a>
                                    </h5>
                                    <p class="text-muted small flex-grow-1">{{ Str::limit($art->summary, 100) }}</p>
                                    <a href="{{ route('articles.show', $art->slug) }}" class="text-primary fw-semibold small text-decoration-none mt-2">
                                        Baca Selengkapnya &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
