@extends('layouts.admin')

@section('title', 'Data Pendaftar Kelas')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Data Pendaftar Kelas</h3>
        <p class="text-muted small mb-0">Kelola dan tinjau status registrasi calon peserta per kelas</p>
    </div>
    <div class="d-flex gap-2">
        <!-- Fitur Bonus: Ekspor CSV / Excel -->
        <a href="{{ route('admin.registrations.export', request()->query()) }}" class="btn btn-outline-success">
            <i class="bi bi-file-earmark-spreadsheet me-1"></i> Ekspor ke CSV / Excel
        </a>
    </div>
</div>

<div class="card card-custom">
    <!-- FILTER BAR -->
    <div class="card-header bg-white py-3 border-bottom">
        <form action="{{ route('admin.registrations.index') }}" method="GET" class="row g-2">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama, email, atau no telp...">
                </div>
            </div>
            <div class="col-md-3">
                <select name="course_id" class="form-select">
                    <option value="">Semua Kelas</option>
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>
                            {{ Str::limit($c->title, 35) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    @foreach($statuses as $st)
                        <option value="{{ $st->value }}" {{ request('status') === $st->value ? 'selected' : '' }}>
                            {{ $st->label() }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
                @if(request()->anyFilled(['q', 'course_id', 'status']))
                    <a href="{{ route('admin.registrations.index') }}" class="btn btn-light border text-danger" title="Reset">
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
                    <th>Nama Calon Peserta</th>
                    <th>Kontak (Email / Telp)</th>
                    <th>Kelas yang Diambil</th>
                    <th>Status Saat Ini</th>
                    <th>Catatan Peserta</th>
                    <th>Ubah Status</th>
                    <th class="text-end">Hapus</th>
                </tr>
            </thead>
            <tbody>
                @forelse($registrations as $index => $item)
                    <tr>
                        <td>{{ $registrations->firstItem() + $index }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $item->name }}</div>
                            <small class="text-muted">Tgl: {{ $item->created_at->format('d/m/Y H:i') }}</small>
                        </td>
                        <td>
                            <div class="small"><i class="bi bi-envelope text-muted me-1"></i> {{ $item->email }}</div>
                            <div class="small"><i class="bi bi-whatsapp text-success me-1"></i> {{ $item->phone }}</div>
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
                        <td>
                            <small class="text-secondary" style="max-width: 180px; display: inline-block;">
                                {{ $item->notes ?: '-' }}
                            </small>
                        </td>
                        <td>
                            <!-- FORM UBAH STATUS (FITUR WAJIB 6) -->
                            <form action="{{ route('admin.registrations.update-status', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <div class="input-group input-group-sm" style="min-width: 140px;">
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        @foreach($statuses as $st)
                                            <option value="{{ $st->value }}" {{ $item->status->value === $st->value ? 'selected' : '' }}>
                                                {{ $st->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </td>
                        <td class="text-end">
                            <form action="{{ route('admin.registrations.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pendaftar ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Data">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">Belum ada data pendaftar yang cocok.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($registrations->hasPages())
        <div class="card-footer bg-white py-3 d-flex justify-content-center">
            {{ $registrations->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
