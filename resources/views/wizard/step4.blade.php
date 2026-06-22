@extends('layouts.app')

@section('title', 'Evidence Pekerjaan - Step 4')

@section('content')
<div class="container">
    <h3>Lampiran Evidence Pekerjaan</h3>

    <div class="mb-4">
        <div class="progress" style="height: 25px;">
            <div class="progress-bar bg-success" role="progressbar" style="width: 50%;">Step 4/8</div>
        </div>
        <div class="d-flex justify-content-between mt-1 small text-muted">
            <span>✓ Data Project</span>
            <span>✓ Commissioning</span>
            <span>✓ BOQ</span>
            <span>Evidence</span>
            <span>Marking</span>
            <span>OPM</span>
            <span>OTDR</span>
            <span>Mancore</span>
        </div>
    </div>

    <div class="alert alert-info">
        <strong>Project:</strong> {{ $project->name }}<br>
        <strong>Lokasi:</strong> {{ $project->location->name ?? '-' }} ({{ $project->location->code ?? '-' }})
    </div>

    <form method="POST" action="{{ route('wizard.step4.submit') }}" enctype="multipart/form-data">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-white fw-bold">Penarikan Kabel</div>
                    <div class="card-body">
                        <input type="file" name="penarikan_kabel[]" multiple class="form-control" accept="image/*">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-white fw-bold">Instalasi Aksesoris</div>
                    <div class="card-body">
                        <input type="file" name="instalasi_aksesoris[]" multiple class="form-control" accept="image/*">
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-white fw-bold">Instalasi & Penyambungan Closure</div>
                    <div class="card-body">
                        <input type="file" name="instalasi_closure[]" multiple class="form-control" accept="image/*">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-white fw-bold">Penyambungan & Instalasi ODP</div>
                    <div class="card-body">
                        <input type="file" name="penyambungan_odp[]" multiple class="form-control" accept="image/*">
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('wizard.prev') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
            <button type="submit" class="btn btn-primary">Selanjutnya <i class="bi bi-arrow-right"></i></button>
        </div>
    </form>
</div>
@endsection
