@extends('layouts.app')

@section('title', $course->title . ' - EduTech')

@section('content')
    <!-- BREADCRUMB -->
    <div class="bg-white border-bottom py-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('home') }}?category={{ $course->category->slug ?? '' }}#daftar-kelas" class="text-decoration-none">{{ $course->category->name ?? 'Kelas' }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $course->title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- DETAIL KELAS & FORM PENDAFTARAN -->
    <section class="py-5">
        <div class="container">
            <div class="row g-5">
                <!-- KIRI: INFORMASI KELAS -->
                <div class="col-lg-7">
                    <div class="bg-white p-4 p-md-5 rounded-4 border shadow-sm mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="badge-cat">{{ $course->category->name ?? 'Umum' }}</span>
                            <span class="badge {{ $course->is_free ? 'bg-success' : 'bg-primary' }} rounded-pill px-3 py-1">
                                {{ $course->formatted_price }}
                            </span>
                        </div>

                        <h1 class="fw-bold text-dark mb-4">{{ $course->title }}</h1>

                        <div class="rounded-4 overflow-hidden mb-4 border" style="max-height: 400px;">
                            <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="w-100 h-100 object-fit-cover">
                        </div>

                        <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 mb-4">
                            <div class="bg-primary text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                <i class="bi bi-person-badge-fill fs-5"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Instruktur Utama</div>
                                <div class="fw-bold text-dark">{{ $course->instructor_name }}</div>
                            </div>
                        </div>

                        <h4 class="fw-bold text-dark mb-3">Tentang Kelas Ini</h4>
                        <div class="text-muted leading-relaxed" style="white-space: pre-line;">
                            {{ $course->description }}
                        </div>

                        <hr class="my-4">

                        <h5 class="fw-bold text-dark mb-3">Fasilitas yang Anda Dapatkan:</h5>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>Akses Materi Seumur Hidup</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>Sertifikat Resmi Penyelesaian</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>Konsultasi Proyek & Tugas</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>Grup Diskusi & Komunitas Eksklusif</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KANAN: FORMULIR PENDAFTARAN KELAS -->
                <div class="col-lg-5">
                    <div class="sticky-top" style="top: 90px; z-index: 10;">
                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                            <div class="bg-primary text-white p-4 text-center">
                                <h4 class="fw-bold mb-1">Formulir Pendaftaran</h4>
                                <p class="text-white-50 small mb-0">Isi data diri Anda di bawah untuk mengamankan kursi kelas ini</p>
                            </div>
                            <div class="card-body p-4 bg-white">
                                @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show small">
                                        <div class="fw-bold mb-1"><i class="bi bi-exclamation-circle me-1"></i> Gagal Mengirim:</div>
                                        <ul class="mb-0 ps-3">
                                            @foreach($errors->all() as $err)
                                                <li>{{ $err }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('courses.register') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="course_id" value="{{ $course->id }}">

                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-muted">Kelas yang Dipilih</label>
                                        <input type="text" class="form-control bg-light" value="{{ $course->title }}" readonly disabled>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-muted">Biaya Pendaftaran</label>
                                        <div class="fs-4 fw-bold text-primary">{{ $course->formatted_price }}</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="form-label small fw-semibold text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-person text-muted"></i></span>
                                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Contoh: Budi Santoso" value="{{ old('name') }}" required>
                                        </div>
                                        @error('name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label small fw-semibold text-dark">Alamat Email <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-envelope text-muted"></i></span>
                                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="nama@email.com" value="{{ old('email') }}" required>
                                        </div>
                                        <small class="text-muted" style="font-size: 0.75rem;">Satu email hanya bisa mendaftar satu kali di kelas ini.</small>
                                        @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone" class="form-label small fw-semibold text-dark">Nomor WhatsApp / Telepon <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-whatsapp text-muted"></i></span>
                                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="08123456789" value="{{ old('phone') }}" required>
                                        </div>
                                        @error('phone')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="notes" class="form-label small fw-semibold text-dark">Catatan / Motivasi Belajar (Opsional)</label>
                                        <textarea name="notes" id="notes" rows="2" class="form-control" placeholder="Contoh: Ingin beralih karir menjadi frontend developer">{{ old('notes') }}</textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold fs-6 shadow">
                                        <i class="bi bi-send-fill me-2"></i> Kirim Pendaftaran Sekarang
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KELAS TERKAIT -->
            @if($relatedCourses->count() > 0)
                <div class="mt-5 pt-4 border-top">
                    <h3 class="fw-bold mb-4">Kelas Terkait Lainnya</h3>
                    <div class="row g-4">
                        @foreach($relatedCourses as $rc)
                            <div class="col-md-4">
                                <div class="card card-course h-100 shadow-sm">
                                    <div class="course-img-wrapper" style="height: 160px;">
                                        <img src="{{ $rc->image_url }}" alt="{{ $rc->title }}">
                                    </div>
                                    <div class="card-body p-4 d-flex flex-column">
                                        <span class="badge-cat mb-2 align-self-start">{{ $rc->category->name }}</span>
                                        <h6 class="fw-bold mb-2">
                                            <a href="{{ route('courses.show', $rc->slug) }}" class="text-dark text-decoration-none">
                                                {{ $rc->title }}
                                            </a>
                                        </h6>
                                        <div class="mt-auto pt-2 d-flex justify-content-between align-items-center">
                                            <span class="fw-bold text-primary">{{ $rc->formatted_price }}</span>
                                            <a href="{{ route('courses.show', $rc->slug) }}" class="btn btn-outline-primary btn-sm">Lihat</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
