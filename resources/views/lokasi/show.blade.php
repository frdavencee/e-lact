@extends('layouts.app')

@section('title', 'Detail Lokasi - ' . $lokasi->code)

@section('content')
<div class="detail-header">
    <h2>{{ $lokasi->code }} - {{ $lokasi->name }}</h2>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('lokasi.edit', $lokasi) }}" class="btn-soft-secondary"><i class="bi bi-pencil"></i> Edit</a>
        <a href="{{ route('lokasi.generate', $lokasi) }}" class="btn-primary-gradient" onclick="return confirm('Generate DOCX untuk lokasi ini?')"><i class="bi bi-file-earmark-word"></i> Generate DOCX</a>
        <a href="{{ route('lokasi.generate.pdf', $lokasi) }}" class="btn-danger-gradient" onclick="return confirm('Generate PDF untuk lokasi ini?')"><i class="bi bi-file-earmark-pdf"></i> Generate PDF</a>
    </div>
</div>

{{-- Status --}}
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

{{-- SECTION 1: INFO PROYEK --}}
<div class="detail-card mb-4">
    <div class="detail-card-header">
        <h5 class="mb-0">Info Proyek</h5>
    </div>
    <div class="detail-card-body">
        @php $project = $lokasi->project; @endphp
        <form method="POST" action="{{ $project ? route('project.update', [$lokasi, $project]) : route('project.store', $lokasi) }}">
            @csrf
            @if($project) @method('PUT') @endif
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label-soft">Nama Proyek</label>
                    <input type="text" name="name" class="form-control-soft" value="{{ old('name', $project->name ?? '') }}" placeholder="Nama Proyek" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label-soft">Kontrak</label>
                    <input type="text" name="contract_number" class="form-control-soft" value="{{ old('contract_number', $project->contract_number ?? '') }}" placeholder="Nomor Kontrak">
                </div>
                <div class="col-md-6">
                    <label class="form-label-soft">Surat Pesanan</label>
                    <input type="text" name="purchase_order_number" class="form-control-soft" value="{{ old('purchase_order_number', $project->purchase_order_number ?? '') }}" placeholder="Nomor Surat Pesanan">
                </div>
                <div class="col-md-6">
                    <label class="form-label-soft">Pelaksana</label>
                    <input type="text" name="implementer" class="form-control-soft" value="{{ old('implementer', $project->implementer ?? '') }}" placeholder="Nama Pelaksana">
                </div>
                <div class="col-md-6">
                    <label class="form-label-soft">WASPANG</label>
                    <select name="waspang_id" class="form-select-soft">
                        <option value="">-- Pilih WASPANG --</option>
                        @foreach($personelList as $p)
                        <option value="{{ $p->id }}" {{ old('waspang_id', $project->waspang_id ?? '') == $p->id ? 'selected' : '' }}>{{ $p->nama }} ({{ $p->nik }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn-primary-gradient">Simpan Info Proyek</button>
            </div>
        </form>
    </div>
</div>

{{-- SECTION 2: COMMISSIONING TEST --}}
<div class="detail-card mb-4">
    <div class="detail-card-header">
        <h5 class="mb-0">Commissioning Test</h5>
    </div>
    <div class="detail-card-body">
        @include('lokasi.partials.commissioning_test')
    </div>
</div>

{{-- SECTION 3: BOQ --}}
<div class="detail-card mb-4">
    <div class="detail-card-header">
        <h5 class="mb-0">Bill of Quantity (BOQ)</h5>
    </div>
    <div class="detail-card-body">
        @include('lokasi.partials.boq')
    </div>
</div>

{{-- SECTION 4: MARKING KABEL --}}
<div class="detail-card mb-4">
    <div class="detail-card-header">
        <h5 class="mb-0">Marking Kabel</h5>
    </div>
    <div class="detail-card-body">
        @include('lokasi.partials.marking_kabel')
    </div>
</div>

{{-- SECTION 5: UPLOAD FOTO --}}
<div class="detail-card mb-4">
    <div class="detail-card-header">
        <h5 class="mb-0">Upload Foto Lampiran</h5>
    </div>
    <div class="detail-card-body">
        @include('lokasi.partials.foto')
    </div>
</div>

@endsection
