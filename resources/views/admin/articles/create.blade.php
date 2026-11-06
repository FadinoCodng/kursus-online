@extends('layouts.admin')

@section('title', 'Tulis Artikel Baru')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.articles.index') }}" class="text-decoration-none small text-muted">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Artikel
    </a>
    <h3 class="fw-bold text-dark mt-1">Tulis Artikel Baru</h3>
</div>

<div class="card card-custom p-4">
    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="mb-3">
                    <label for="title" class="form-label fw-semibold">Judul Artikel <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                </div>

                <div class="mb-3">
                    <label for="summary" class="form-label fw-semibold">Ringkasan Singkat <span class="text-danger">*</span></label>
                    <textarea name="summary" id="summary" rows="2" class="form-control @error('summary') is-invalid @enderror" required>{{ old('summary') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label fw-semibold">Isi Artikel <span class="text-danger">*</span></label>
                    <textarea name="content" id="content" rows="10" class="form-control @error('content') is-invalid @enderror" required>{{ old('content') }}</textarea>
                    <small class="text-muted">Mendukung format HTML atau teks biasa.</small>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mb-3">
                    <label for="author" class="form-label fw-semibold">Nama Penulis <span class="text-danger">*</span></label>
                    <input type="text" name="author" id="author" class="form-control @error('author') is-invalid @enderror" value="{{ old('author', auth()->user()->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label fw-semibold">Gambar Utama</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                </div>

                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_published" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="is_published">Langsung Publikasikan</label>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary py-2 fw-semibold">Simpan Artikel</button>
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-light border py-2">Batal</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
