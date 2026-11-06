@extends('layouts.admin')

@section('title', 'Tambah Kelas Baru')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.courses.index') }}" class="text-decoration-none small text-muted">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Kelas
    </a>
    <h3 class="fw-bold text-dark mt-1">Tambah Kelas Baru</h3>
</div>

<div class="card card-custom p-4">
    <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            <!-- Kolom Kiri -->
            <div class="col-lg-8">
                <div class="mb-3">
                    <label for="title" class="form-label fw-semibold">Judul Kelas <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Contoh: Belajar Laravel 13 dari Dasar Sampai Mahir" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Deskripsi Kelas <span class="text-danger">*</span></label>
                    <textarea name="description" id="description" rows="7" class="form-control @error('description') is-invalid @enderror" placeholder="Tuliskan silabus, materi yang akan dipelajari, dan prasyarat kelas..." required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="instructor_name" class="form-label fw-semibold">Nama Instruktur <span class="text-danger">*</span></label>
                        <input type="text" name="instructor_name" id="instructor_name" class="form-control @error('instructor_name') is-invalid @enderror" value="{{ old('instructor_name') }}" placeholder="Contoh: Budi Pratama, S.Kom" required>
                        @error('instructor_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="category_id" class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Pengaturan Tambahan & Gambar -->
            <div class="col-lg-4">
                <div class="bg-light p-3 rounded-3 mb-3 border">
                    <label class="form-label fw-semibold">Biaya Kelas</label>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_free" name="is_free" value="1" {{ old('is_free') ? 'checked' : '' }} onchange="togglePrice(this)">
                        <label class="form-check-label fw-semibold" for="is_free">Kelas Gratis</label>
                    </div>

                    <div id="price_wrapper" style="{{ old('is_free') ? 'display: none;' : '' }}">
                        <label for="price" class="form-label small text-muted">Nominal Harga (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', 150000) }}" min="0" step="1000">
                        </div>
                        @error('price')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label fw-semibold">Status Publikasi <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        @foreach($statuses as $st)
                            <option value="{{ $st->value }}" {{ old('status', 'draft') === $st->value ? 'selected' : '' }}>
                                {{ $st->label() }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted" style="font-size: 0.75rem;">Hanya kelas berstatus 'Published' yang tampil di Landing Page pengunjung.</small>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="image" class="form-label fw-semibold">Upload Gambar Thumbnail</label>
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">Format: JPG, PNG, WEBP (Maksimal 2MB).</small>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary py-2 fw-semibold">
                        <i class="bi bi-cloud-arrow-up me-1"></i> Simpan Kelas
                    </button>
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-light border py-2">Batal</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function togglePrice(elem) {
        const priceWrapper = document.getElementById('price_wrapper');
        const priceInput = document.getElementById('price');
        if (elem.checked) {
            priceWrapper.style.display = 'none';
            priceInput.value = 0;
        } else {
            priceWrapper.style.display = 'block';
            if (priceInput.value == 0) {
                priceInput.value = 150000;
            }
        }
    }
</script>
@endpush
