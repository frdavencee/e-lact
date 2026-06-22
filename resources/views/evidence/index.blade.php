@extends('layouts.app')

@section('title', 'Evidence - ' . $project->nama_proyek)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Evidence - {{ $project->nama_proyek }}</h3>
    <a href="{{ route('projects.show', $project) }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="card mb-4">
    <div class="card-header bg-white"><h6 class="mb-0">Upload Gambar</h6></div>
    <div class="card-body">
        <form method="POST" action="{{ route('evidence.store', $project) }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-select" required>
                        @foreach($kategoriList as $kat)
                        <option value="{{ $kat }}">{{ $kat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Gambar (Multiple)</label>
                    <input type="file" name="images[]" class="form-control" multiple required accept="image/*">
                </div>
                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Upload</button>
                </div>
            </div>
        </form>
    </div>
</div>

@foreach($kategoriList as $kategori)
@if(isset($images[$kategori]))
<div class="card mb-4">
    <div class="card-header bg-white"><h6 class="mb-0">{{ $kategori }}</h6></div>
    <div class="card-body">
        <div class="row">
            @foreach($images[$kategori] as $img)
            <div class="col-md-3 mb-3">
                <div class="card h-100">
                    <img src="{{ asset('storage/' . $img->path) }}" class="card-img-top" alt="{{ $img->nama_file }}" style="height: 150px; object-fit: cover;">
                    <div class="card-body p-2">
                        <p class="card-text small text-truncate mb-0">{{ $img->nama_file }}</p>
                        <form action="{{ route('evidence.destroy', [$project, $img]) }}" method="POST" class="mt-2" onsubmit="return confirm('Hapus gambar?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger w-100">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endforeach
@endsection
