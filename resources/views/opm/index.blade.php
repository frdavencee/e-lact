@extends('layouts.app')

@section('title', 'OPM - ' . $project->nama_proyek)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>OPM - {{ $project->nama_proyek }}</h3>
    <a href="{{ route('projects.show', $project) }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-white"><h6 class="mb-0">Tambah Data OPM</h6></div>
            <div class="card-body">
                <form method="POST" action="{{ route('opm.store', $project) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama ODP</label>
                        <input type="text" name="nama_odp" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Port</label>
                        <input type="text" name="port" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nilai dBm</label>
                        <input type="number" step="0.01" name="nilai_dbm" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Tambah</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white"><h6 class="mb-0">Data OPM</h6></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead><tr><th>ODP</th><th>Port</th><th>dBm</th><th>Catatan</th><th>Aksi</th></tr></thead>
                        <tbody>
                            @forelse($records as $record)
                            <tr>
                                <td>{{ $record->nama_odp }}</td>
                                <td>{{ $record->port }}</td>
                                <td>{{ $record->nilai_dbm }}</td>
                                <td>{{ $record->catatan ?? '-' }}</td>
                                <td>
                                    <form action="{{ route('opm.destroy', [$project, $record]) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted">Belum ada data OPM</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
