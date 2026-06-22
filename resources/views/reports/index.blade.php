@extends('layouts.app')

@section('title', 'Daftar Laporan')

@section('content')
<div class="detail-header">
    <h2>Laporan Proyek</h2>
    <a href="{{ route('reports.create') }}" class="btn-primary-gradient">
        <i class="bi bi-plus-circle"></i> Buat Laporan Baru
    </a>
</div>

<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Filter Laporan</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('reports.index') }}" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari judul/lokasi..." value="{{ old('search', $request->search) }}">
            </div>
            <div class="col-md-3">
                <select name="type" class="form-select">
                    <option value="">Semua Jenis</option>
                    <option value="lapangan" {{ old('type', $request->type) == 'lapangan' ? 'selected' : '' }}>Laporan Lapangan</option>
                    <option value="teknis" {{ old('type', $request->type) == 'teknis' ? 'selected' : '' }}>Laporan Teknis</option>
                    <option value="pemantauan" {{ old('type', $request->type) == 'pemantauan' ? 'selected' : '' }}>Laporan Pemantauan</option>
                    <option value="lainnya" {{ old('type', $request->type) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="project_id" class="form-select">
                    <option value="">Semua Proyek</option>
                    @foreach(\App\Models\Project::orderBy('name')->get() as $project)
                    <option value="{{ $project->id }}" {{ old('project_id', $request->project_id) == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($reports->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Judul Laporan</th>
                        <th>Proyek</th>
                        <th>Jenis</th>
                        <th>Tanggal Laporan</th>
                        <th>Lokasi</th>
                        <th>Dibuat</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $index => $report)
                    <tr>
                        <td>{{ $reports->firstItem() + $index }}</td>
                        <td>
                            <strong>
                                <a href="{{ route('reports.show', $report) }}" class="text-decoration-none">
                                    {{ $report->title }}
                                </a>
                            </strong>
                            @if($report->description)
                            <br><small class="text-muted">{{ Str::limit($report->description, 60) }}</small>
                            @endif
                        </td>
                        <td>{{ $report->project->name ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $report->type == 'lapangan' ? 'primary' : ($report->type == 'teknis' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($report->type) }}
                            </span>
                        </td>
                        <td>{{ $report->report_date ? $report->report_date->format('d/m/Y') : '-' }}</td>
                        <td>{{ $report->location ?? '-' }}</td>
                        <td>
                            <small>{{ $report->user->name ?? '-' }}</small><br>
                            <small class="text-muted">{{ $report->created_at->format('d/m/Y H:i') }}</small>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('reports.show', $report) }}" class="btn btn-sm btn-view" title="Lihat">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('reports.edit', $report) }}" class="btn btn-sm btn-edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('reports.destroy', $report) }}" class="d-inline" onsubmit="return confirm('Hapus laporan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-delete" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $reports->links() }}
        </div>
        @else
        <div class="empty-state">
            <i class="bi bi-file-earmark-text"></i>
            <p>Belum ada laporan. Klik "Buat Laporan Baru" untuk membuat laporan pertama.</p>
        </div>
        @endif
    </div>
</div>
@endsection
