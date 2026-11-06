@extends('layouts.admin')

@section('title', 'Kelola Artikel / Blog')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Kelola Artikel / Blog (Fitur Bonus)</h3>
        <p class="text-muted small mb-0">Publikasikan konten wawasan dan berita teknologi untuk pengunjung</p>
    </div>
    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Buat Artikel Baru
    </a>
</div>

<div class="card card-custom">
    <div class="card-header bg-white py-3 border-bottom">
        <form action="{{ route('admin.articles.index') }}" method="GET" class="row g-2">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari judul artikel atau penulis...">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Cari</button>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr class="small text-muted text-uppercase">
                    <th>#</th>
                    <th>Judul Artikel</th>
                    <th>Penulis</th>
                    <th>Status</th>
                    <th>Tanggal Dibuat</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $index => $art)
                    <tr>
                        <td>{{ $articles->firstItem() + $index }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $art->title }}</div>
                            <small class="text-muted"><a href="{{ route('articles.show', $art->slug) }}" target="_blank">Lihat artikel &rarr;</a></small>
                        </td>
                        <td>{{ $art->author }}</td>
                        <td>
                            @if($art->is_published)
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $art->created_at->format('d M Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.articles.edit', $art->id) }}" class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('admin.articles.destroy', $art->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus artikel ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada artikel.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($articles->hasPages())
        <div class="card-footer bg-white py-3 d-flex justify-content-center">
            {{ $articles->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
