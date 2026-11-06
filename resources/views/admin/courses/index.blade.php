@extends('layouts.admin')

@section('title', 'Kelola Kelas Online')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Kelola Kelas Online</h3>
        <p class="text-muted small mb-0">Manajemen materi, harga, status publikasi, dan instruktur kelas</p>
    </div>
    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Kelas Baru
    </a>
</div>

<div class="card card-custom">
    <!-- FILTER BAR -->
    <div class="card-header bg-white py-3 border-bottom">
        <form action="{{ route('admin.courses.index') }}" method="GET" class="row g-2">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari judul atau instruktur...">
                </div>
            </div>
            <div class="col-md-3">
                <select name="category_id" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
                @if(request()->anyFilled(['q', 'category_id', 'status']))
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-light border text-danger" title="Reset">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr class="small text-muted text-uppercase">
                    <th>#</th>
                    <th>Gambar & Judul Kelas</th>
                    <th>Kategori</th>
                    <th>Instruktur</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Pendaftar</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $index => $c)
                    <tr>
                        <td>{{ $courses->firstItem() + $index }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $c->image_url }}" alt="" class="rounded-3 object-fit-cover border" style="width: 50px; height: 50px;">
                                <div>
                                    <div class="fw-bold text-dark">{{ $c->title }}</div>
                                    <small class="text-muted"><a href="{{ route('courses.show', $c->slug) }}" target="_blank" class="text-decoration-none">Lihat di web &rarr;</a></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $c->category->name ?? '-' }}</span>
                        </td>
                        <td class="small fw-semibold text-secondary">
                            {{ $c->instructor_name }}
                        </td>
                        <td>
                            @if($c->is_free)
                                <span class="badge bg-success-subtle text-success">GRATIS</span>
                            @else
                                <span class="fw-semibold text-primary">{{ $c->formatted_price }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $c->status->badgeClass() }}">
                                {{ $c->status->label() }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.registrations.index', ['course_id' => $c->id]) }}" class="badge bg-secondary-subtle text-secondary text-decoration-none px-2 py-1">
                                <i class="bi bi-people me-1"></i> {{ $c->registrations_count }} orang
                            </a>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.courses.edit', $c->id) }}" class="btn btn-sm btn-outline-warning" title="Edit Kelas">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('admin.courses.destroy', $c->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">Belum ada data kelas yang sesuai filter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($courses->hasPages())
        <div class="card-footer bg-white py-3 d-flex justify-content-center">
            {{ $courses->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
