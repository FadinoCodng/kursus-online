@extends('layouts.admin')

@section('title', 'Dashboard Ringkasan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Dashboard Pengelola</h3>
        <p class="text-muted small mb-0">Pantau performa program kelas dan registrasi calon peserta secara real-time</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Kelas Baru
        </a>
    </div>
</div>

<!-- STATS CARDS (RINGKASAN SESUAI FITUR WAJIB 3) -->
<div class="row g-3 mb-4">
    <!-- Total Kelas -->
    <div class="col-xl-3 col-md-6">
        <div class="card card-custom p-3 border-start border-4 border-primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Total Kelas</span>
                    <h2 class="fw-bold mb-0 mt-1 text-dark">{{ $totalCourses }}</h2>
                    <small class="text-muted">{{ $publishedCourses }} Published &bull; {{ $draftCourses }} Draft</small>
                </div>
                <div class="bg-primary-subtle text-primary p-3 rounded-3">
                    <i class="bi bi-journal-bookmark-fill fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Pendaftar -->
    <div class="col-xl-3 col-md-6">
        <div class="card card-custom p-3 border-start border-4 border-success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Total Pendaftar</span>
                    <h2 class="fw-bold mb-0 mt-1 text-dark">{{ $totalRegistrations }}</h2>
                    <small class="text-success fw-semibold">{{ $acceptedRegistrations }} Diterima</small>
                </div>
                <div class="bg-success-subtle text-success p-3 rounded-3">
                    <i class="bi bi-people-fill fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Pendaftar Pending -->
    <div class="col-xl-3 col-md-6">
        <div class="card card-custom p-3 border-start border-4 border-warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Menunggu Konfirmasi</span>
                    <h2 class="fw-bold mb-0 mt-1 text-dark">{{ $pendingRegistrations }}</h2>
                    <small class="text-warning fw-semibold">Perlu Ditinjau</small>
                </div>
                <div class="bg-warning-subtle text-warning p-3 rounded-3">
                    <i class="bi bi-clock-history fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Kategori -->
    <div class="col-xl-3 col-md-6">
        <div class="card card-custom p-3 border-start border-4 border-info">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Kategori Kelas</span>
                    <h2 class="fw-bold mb-0 mt-1 text-dark">{{ $totalCategories }}</h2>
                    <small class="text-muted">{{ $rejectedRegistrations }} Pendaftar Ditolak</small>
                </div>
                <div class="bg-info-subtle text-info p-3 rounded-3">
                    <i class="bi bi-tags-fill fs-3"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 5 PENDAFTAR TERBARU (FITUR WAJIB 3) -->
<div class="card card-custom mb-4">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold text-dark mb-0">5 Pendaftar Terbaru</h5>
            <small class="text-muted">Daftar calon peserta yang baru saja mendaftar kelas</small>
        </div>
        <a href="{{ route('admin.registrations.index') }}" class="btn btn-outline-primary btn-sm">
            Lihat Semua Pendaftar &rarr;
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr class="small text-muted text-uppercase">
                    <th>Nama Pendaftar</th>
                    <th>Email & WhatsApp</th>
                    <th>Kelas yang Diminati</th>
                    <th>Status</th>
                    <th>Tanggal Masuk</th>
                    <th class="text-end">Aksi Cepat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestRegistrations as $item)
                    <tr>
                        <td>
                            <div class="fw-semibold text-dark">{{ $item->name }}</div>
                            <small class="text-muted">{{ Str::limit($item->notes, 30) ?: 'Tidak ada catatan' }}</small>
                        </td>
                        <td>
                            <div><i class="bi bi-envelope me-1 text-muted"></i> {{ $item->email }}</div>
                            <small class="text-muted"><i class="bi bi-whatsapp me-1 text-success"></i> {{ $item->phone }}</small>
                        </td>
                        <td>
                            <span class="fw-semibold text-primary">{{ $item->course->title ?? '-' }}</span>
                            <div class="small text-muted">{{ $item->course->formatted_price ?? '' }}</div>
                        </td>
                        <td>
                            <span class="badge {{ $item->status->badgeClass() }} px-3 py-1">
                                {{ $item->status->label() }}
                            </span>
                        </td>
                        <td class="small text-muted">
                            {{ $item->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="text-end">
                            <form action="{{ route('admin.registrations.update-status', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="diterima">
                                <button type="submit" class="btn btn-sm btn-outline-success" title="Terima Pendaftar" {{ $item->status->value === 'diterima' ? 'disabled' : '' }}>
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.registrations.update-status', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="ditolak">
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Tolak Pendaftar" {{ $item->status->value === 'ditolak' ? 'disabled' : '' }}>
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada data pendaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
