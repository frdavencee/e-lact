@extends('layouts.app')

@section('title', 'Upload OTDR - Step 7')

@section('content')
<div class="container">
    <h3>Upload Hasil Ukur OTDR</h3>

    <div class="mb-4">
        <div class="progress" style="height: 25px;">
            <div class="progress-bar bg-success" role="progressbar" style="width: 87.5%;">Step 7/8</div>
        </div>
        <div class="d-flex justify-content-between mt-1 small text-muted">
            <span>✓ Data Project</span>
            <span>✓ Commissioning</span>
            <span>✓ BOQ</span>
            <span>✓ Evidence</span>
            <span>✓ Marking</span>
            <span>✓ OPM</span>
            <span>OTDR</span>
            <span>Mancore</span>
        </div>
    </div>

    <div class="alert alert-info">
        <strong>Project:</strong> {{ $project->name }}<br>
        <strong>Lokasi:</strong> {{ $project->location->name ?? '-' }} ({{ $project->location->code ?? '-' }})
    </div>

    <form method="POST" action="{{ route('wizard.step7.submit') }}" enctype="multipart/form-data">
        @csrf

        <div class="card mb-3">
            <div class="card-header bg-white fw-bold">File OTDR</div>
            <div class="card-body">
                <div class="mb-3">
                    <label>Upload File OTDR (Grafik/screenshot alat ukur)</label>
                    <input type="file" name="files[]" multiple class="form-control" accept="image/*,.pdf">
                    <small class="text-muted">Format: JPG, PNG, atau PDF. Maks 5MB per file.</small>
                </div>
            </div>
        </div>

        @if($otdrFiles->count() > 0)
        <div class="card mb-3">
            <div class="card-header bg-white fw-bold">File yang Sudah Diupload</div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($otdrFiles as $file)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-file-earmark"></i> {{ $file->nama_file }}</span>
                        <span class="badge bg-secondary">{{ strtoupper($file->tipe) }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <div class="d-flex justify-content-between">
            <a href="{{ route('wizard.prev') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
            <button type="submit" class="btn btn-primary">Selanjutnya <i class="bi bi-arrow-right"></i></button>
        </div>
    </form>
</div>
@endsection
