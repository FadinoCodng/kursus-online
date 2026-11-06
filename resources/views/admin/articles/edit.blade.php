@extends('layouts.admin')

@section('title', 'Edit Artikel')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.articles.index') }}" class="text-decoration-none small text-muted">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Artikel
    </a>
    <h3 class="fw-bold text-dark mt-1">Edit Artikel</h3>
</div>

<div class="card card-custom p-4">
    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="mb-3">
                    <label for="title" class="form-label fw-semibold">Judul Artikel <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $article->title) }}" required>
                </div>

                <div class="mb-3">
                    <label for="summary" class="form-label fw-semibold">Ringkasan Singkat <span class="text-danger">*</span></label>
                    <textarea name="summary" id="summary" rows="2" class="form-control @error('summary') is-invalid @enderror" required>{{ old('summary', $article->summary) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label fw-semibold">Isi Artikel <span class="text-danger">*</span></label>
                    <textarea name="content" id="content" rows="10" class="form-control @error('content') is-invalid @enderror" required>{{ old('content', $article->content) }}</textarea>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mb-3">
                    <label for="author" class="form-label fw-semibold">Nama Penulis <span class="text-danger">*</span></label>
                    <input type="text" name="author" id="author" class="form-control @error('author') is-invalid @enderror" value="{{ old('author', $article->author) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Gambar Utama</label>
                    @if($article->image)
                        <img src="{{ $article->image_url }}" alt="" class="img-fluid rounded-3 mb-2 border" style="max-height: 120px; width: 100%; object-fit: cover;">
                    @endif
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                </div>

                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_published" name="is_published" value="1" {{ old('is_published', $article->is_published) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="is_published">Publikasikan</label>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary py-2 fw-semibold">Perbarui Artikel</button>
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-light border py-2">Batal</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
