@extends('layouts.app')

@section('title', 'Commissioning Test - Step 2')

@section('content')
<div class="container">
    <h3>Commissioning Test</h3>

    <div class="mb-4">
        <div class="progress" style="height: 25px;">
            <div class="progress-bar bg-success" role="progressbar" style="width: 25%;">Step 2/8</div>
        </div>
        <div class="d-flex justify-content-between mt-1 small text-muted">
            <span>✓ Data Project</span>
            <span>Commissioning</span>
            <span>BOQ</span>
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

    <form method="POST" action="{{ route('wizard.step2.submit') }}" enctype="multipart/form-data">
        @csrf
        <div class="card mb-3">
            <div class="card-header bg-white fw-bold">Identitas Waspang</div>
            <div class="card-body">
                <div class="mb-3">
                    <label>Nama Waspang</label>
                    <input type="text" name="waspang_name" class="form-control" value="{{ old('waspang_name', $commissioning->waspang_name ?? $data['waspang_name'] ?? '') }}">
                </div>
                <div class="mb-3">
                    <label>NIK</label>
                    <input type="text" name="nik" class="form-control" value="{{ old('nik', $commissioning->nik ?? $data['nik'] ?? '') }}">
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header bg-white fw-bold">Status Pekerjaan</div>
            <div class="card-body">
                <div class="form-check">
                    <input type="radio" name="work_status" value="selesai" class="form-check-input" {{ old('work_status', $commissioning->status_pekerjaan ?? $data['work_status'] ?? '') == 'selesai' ? 'checked' : '' }}>
                    <label class="form-check-label">Telah Selesai</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="work_status" value="belum_selesai" class="form-check-input" {{ old('work_status', $commissioning->status_pekerjaan ?? $data['work_status'] ?? '') == 'belum_selesai' ? 'checked' : '' }}>
                    <label class="form-check-label">Belum Selesai</label>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header bg-white fw-bold">Hasil Pekerjaan</div>
            <div class="card-body">
                <div class="form-check">
                    <input type="radio" name="result_status" value="diterima" class="form-check-input" {{ old('result_status', $commissioning->status_hasil ?? $data['result_status'] ?? '') == 'diterima' ? 'checked' : '' }}>
                    <label class="form-check-label">Diterima dan Layak UT</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="result_status" value="ditolak" class="form-check-input" {{ old('result_status', $commissioning->status_hasil ?? $data['result_status'] ?? '') == 'ditolak' ? 'checked' : '' }}>
                    <label class="form-check-label">Tidak Diterima</label>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header bg-white fw-bold">Tanda Tangan</div>
            <div class="card-body">
                <div class="mb-3">
                    <label>Tanggal</label>
                    <input type="date" name="signed_at" class="form-control" value="{{ old('signed_at', $commissioning->tanggal ?? date('Y-m-d')) }}">
                </div>
                <div class="mb-3">
                    <label>Tanda Tangan Waspang (opsional)</label>
                    <input type="file" name="signature_image" class="form-control" accept="image/*">
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
