@extends('layouts.app')

@section('title', $article->title . ' - EduTech Blog')

@section('content')
<div class="bg-white border-bottom py-3">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('articles.index') }}" class="text-decoration-none">Blog</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($article->title, 40) }}</li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <article class="bg-white p-4 p-md-5 rounded-4 border shadow-sm">
                    <h1 class="fw-bold text-dark mb-3">{{ $article->title }}</h1>
                    <div class="d-flex align-items-center gap-3 text-muted small mb-4 pb-3 border-bottom">
                        <div><i class="bi bi-person-fill text-primary"></i> {{ $article->author }}</div>
                        <div><i class="bi bi-calendar3 text-primary"></i> {{ $article->created_at->format('d F Y') }}</div>
                    </div>

                    <div class="rounded-4 overflow-hidden mb-4 border" style="max-height: 420px;">
                        <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="w-100 h-100 object-fit-cover">
                    </div>

                    <div class="lead text-secondary mb-4 fst-italic">
                        {{ $article->summary }}
                    </div>

                    <div class="text-dark leading-relaxed fs-6">
                        {!! $article->content !!}
                    </div>
                </article>
            </div>

            <div class="col-lg-4">
                <div class="bg-white p-4 rounded-4 border shadow-sm mb-4">
                    <h5 class="fw-bold mb-3">Artikel Terkait</h5>
                    <div class="d-flex flex-column gap-3">
                        @foreach($recentArticles as $ra)
                            <div class="d-flex gap-3 align-items-center">
                                <img src="{{ $ra->image_url }}" alt="{{ $ra->title }}" class="rounded-3 object-fit-cover" style="width: 70px; height: 70px;">
                                <div>
                                    <h6 class="mb-1" style="font-size: 0.9rem;">
                                        <a href="{{ route('articles.show', $ra->slug) }}" class="text-dark text-decoration-none hover-primary">
                                            {{ Str::limit($ra->title, 50) }}
                                        </a>
                                    </h6>
                                    <small class="text-muted" style="font-size: 0.75rem;">{{ $ra->created_at->format('d M Y') }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="p-4 rounded-4 bg-primary text-white shadow-sm text-center">
                    <h5 class="fw-bold mb-2">Ingin Tingkatkan Karir?</h5>
                    <p class="small text-white-50 mb-3">Daftar sekarang di program kelas online kami dan bangun portfolio terbaik Anda.</p>
                    <a href="{{ route('home') }}#daftar-kelas" class="btn btn-warning w-100 fw-bold">Pilih Kelas Sekarang</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
