@extends('layouts.admin')

@section('title', 'Kelola Kategori Kelas')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Kelola Kategori Kelas</h3>
        <p class="text-muted small mb-0">Kelompokkan kelas berdasarkan spesialisasi teknologi yang relevan</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
    </a>
</div>

<div class="card card-custom">
    <div class="card-header bg-white py-3 border-bottom">
        <form action="{{ route('admin.categories.index') }}" method="GET" class="row g-2">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama atau deskripsi kategori...">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Cari</button>
            </div>
            @if(request('q'))
                <div class="col-md-2">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-light border text-danger w-100">Reset</a>
                </div>
            @endif
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr class="small text-muted text-uppercase">
                    <th>#</th>
                    <th>Nama Kategori</th>
                    <th>Slug URL</th>
                    <th>Deskripsi Singkat</th>
                    <th>Jumlah Kelas</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $index => $cat)
                    <tr>
                        <td>{{ $categories->firstItem() + $index }}</td>
                        <td class="fw-semibold text-dark">{{ $cat->name }}</td>
                        <td><code>{{ $cat->slug }}</code></td>
                        <td class="text-muted small" style="max-width: 300px;">{{ $cat->description ?: '-' }}</td>
                        <td>
                            <span class="badge bg-primary-subtle text-primary px-3 py-1">
                                {{ $cat->courses_count }} Kelas
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.categories.edit', $cat->id) }}" class="btn btn-sm btn-outline-warning" title="Edit Kategori">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Semua kelas di dalamnya juga akan terpengaruh.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Kategori">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Data kategori belum tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->hasPages())
        <div class="card-footer bg-white py-3 d-flex justify-content-center">
            {{ $categories->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
