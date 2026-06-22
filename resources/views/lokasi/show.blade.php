@extends('layouts.app')

@section('title', 'Detail Lokasi - ' . $lokasi->code)

@section('content')
<div class="detail-header">
    <h2>{{ $lokasi->code }} - {{ $lokasi->name }}</h2>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('lokasi.edit', $lokasi) }}" class="btn-soft-secondary"><i class="bi bi-pencil"></i> Edit</a>
        @if($lokasi->status === 'siap' || $lokasi->status === 'draft')
        <a href="{{ route('lokasi.generate', $lokasi) }}" class="btn-primary-gradient" onclick="return confirm('Generate DOCX untuk lokasi ini?')"><i class="bi bi-file-earmark-word"></i> Generate DOCX</a>
        <a href="{{ route('lokasi.generate.pdf', $lokasi) }}" class="btn-danger-gradient" onclick="return confirm('Generate PDF untuk lokasi ini?')"><i class="bi bi-file-earmark-pdf"></i> Generate PDF</a>
        @endif
    </div>
</div>

<div class="detail-card mb-4">
    <div class="detail-card-body">
        <div class="info-row">
            <div class="info-item">
                <span class="info-label">Status:</span>
                @php
                    $badgeClass = match($lokasi->status) {
                        'belum' => 'badge-secondary',
                        'draft' => 'badge-warning',
                        'siap' => 'badge-info',
                        'generated' => 'badge-success',
                        default => 'badge-secondary'
                    };
                @endphp
                <span class="badge-modern {{ $badgeClass }}">{{ ucfirst($lokasi->status) }}</span>
            </div>
        </div>
    </div>
</div>

<ul class="nav-tabs-modern" id="lactTab" role="tablist">
    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-ct">Info Commissioning Test</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-boq">BOQ</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-kabel">Marking Kabel</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-foto">Upload Foto</button></li>
</ul>

<div class="tab-content-modern">
    <div class="tab-pane fade show active" id="tab-ct">
        @include('lokasi.partials.commissioning_test')
    </div>
    <div class="tab-pane fade" id="tab-boq">
        @include('lokasi.partials.boq')
    </div>
    <div class="tab-pane fade" id="tab-kabel">
        @include('lokasi.partials.marking_kabel')
    </div>
    <div class="tab-pane fade" id="tab-foto">
        @include('lokasi.partials.foto')
    </div>
</div>
@endsection