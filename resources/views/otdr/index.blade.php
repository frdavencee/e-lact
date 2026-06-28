@extends('layouts.app')

@section('title', 'OTDR - ' . $project->nama_proyek)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>OTDR - {{ $project->nama_proyek }}</h3>
    <a href="{{ route('projects.show', $project) }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="card mb-4">
    <div class="card-header bg-white"><h6 class="mb-0">Upload File OTDR (PDF/JPG/PNG)</h6></div>
    <div class="card-body">
        <form method="POST" action="{{ route('otdr.store', $project) }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8 mb-3">
                    <input type="file" name="file" class="form-control" required accept=".pdf,.jpg,.jpeg,.png">
                </div>
                <div class="col-md-4 mb-3">
                    <button type="submit" class="btn btn-primary w-100">Upload</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white"><h6 class="mb-0">Daftar File</h6></div>
    <div class="card-body">
        <table class="table table-hover">
            <thead><tr><th>Nama File</th><th>Tipe</th><th>Upload</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($files as $file)
                <tr>
                    <td>{{ $file->nama_file }}</td>
                    <td><span class="badge bg-secondary">{{ strtoupper($file->tipe) }}</span></td>
                    <td>{{ $file->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $file->path) }}" target="_blank" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                        <form action="{{ route('otdr.destroy', [$project, $file]) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center">Belum ada file OTDR</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
