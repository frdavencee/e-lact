@extends('layouts.app')

@section('title', 'Commissioning Test')

@section('content')
<div class="container">
    <h3>Commissioning Test</h3>

    <form method="POST" action="{{ route('projects.documents.commissioning', $project) }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Nama Waspang</label>
            <input type="text" name="waspang_name" class="form-control" value="{{ old('waspang_name', $commissioning->waspang->name ?? '') }}">
        </div>

        <div class="mb-3">
            <label>NIK</label>
            <input type="text" name="nik" class="form-control" value="{{ old('nik', $commissioning->waspang->nik ?? '') }}">
        </div>

        <label>Status Pekerjaan</label>
        <div class="form-check">
            <input type="radio" name="work_status" value="selesai" class="form-check-input" {{ old('work_status', $commissioning->status_pekerjaan ?? '') == 'selesai' ? 'checked' : '' }}>
            <label class="form-check-label">Telah Selesai</label>
        </div>
        <div class="form-check">
            <input type="radio" name="work_status" value="belum_selesai" class="form-check-input" {{ old('work_status', $commissioning->status_pekerjaan ?? '') == 'belum_selesai' ? 'checked' : '' }}>
            <label class="form-check-label">Belum Selesai</label>
        </div>

        <hr>

        <label>Hasil Pekerjaan</label>
        <div class="form-check">
            <input type="radio" name="result_status" value="diterima" class="form-check-input" {{ old('result_status', $commissioning->status_hasil ?? '') == 'diterima' ? 'checked' : '' }}>
            <label class="form-check-label">Diterima dan Layak UT</label>
        </div>
        <div class="form-check">
            <input type="radio" name="result_status" value="ditolak" class="form-check-input" {{ old('result_status', $commissioning->status_hasil ?? '') == 'ditolak' ? 'checked' : '' }}>
            <label class="form-check-label">Tidak Diterima</label>
        </div>

        <div class="mb-3 mt-3">
            <label>Tanggal</label>
            <input type="date" name="signed_at" class="form-control" value="{{ old('signed_at', $commissioning->tanggal ?? now()->format('Y-m-d')) }}">
        </div>

        <div class="mb-3">
            <label>Tanda Tangan (opsional)</label>
            <input type="file" name="signature_image" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success mt-3">Simpan</button>
    </form>
</div>
@endsection
