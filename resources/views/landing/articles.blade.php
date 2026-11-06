@extends('layouts.app')

@section('title', 'Blog & Artikel Edukatif - EduTech')

@section('content')
<section class="py-5 bg-white border-bottom">
    <div class="container text-center">
        <span class="badge-cat mb-2 d-inline-block">BLOG & WAWASAN</span>
        <h1 class="fw-bold text-dark">Artikel & Berita Teknologi Terkini</h1>
        <p class="text-muted">Pelajari berbagai tips pemrograman, tren teknologi, dan panduan karir digital</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if($articles->count() > 0)
            <div class="row g-4">
                @foreach($articles as $art)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border rounded-4 overflow-hidden shadow-sm bg-white">
                            <img src="{{ $art->image_url }}" alt="{{ $art->title }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="text-muted small mb-2">
                                    <i class="bi bi-calendar3 me-1"></i> {{ $art->created_at->format('d M Y') }} &bull; Oleh {{ $art->author }}
                                </div>
                                <h5 class="fw-bold mb-2">
                                    <a href="{{ route('articles.show', $art->slug) }}" class="text-dark text-decoration-none">
                                        {{ $art->title }}
                                    </a>
                                </h5>
                                <p class="text-muted small flex-grow-1">{{ Str::limit($art->summary, 120) }}</p>
                                <a href="{{ route('articles.show', $art->slug) }}" class="btn btn-outline-primary btn-sm mt-3 align-self-start">
                                    Baca Selengkapnya &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $articles->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center py-5 bg-white rounded-4 border">
                <p class="text-muted">Belum ada artikel yang dipublikasikan.</p>
            </div>
        @endif
    </div>
</section>
@endsection
