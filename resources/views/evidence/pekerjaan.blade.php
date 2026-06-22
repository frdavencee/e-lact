@extends('layouts.app')

@section('title', 'Evidence Pekerjaan')

@section('content')
<div class="container">
    <h3>Lampiran Evident Pekerjaan</h3>

    <form method="POST" action="{{ route('projects.documents.evidence', $project) }}" enctype="multipart/form-data">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Penarikan Kabel</label>
                <input type="file" name="penarikan[]" multiple class="form-control" accept="image/*">
            </div>
            <div class="col-md-6">
                <label>Instalasi Aksesoris</label>
                <input type="file" name="aksesoris[]" multiple class="form-control" accept="image/*">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Instalasi Closure</label>
                <input type="file" name="closure[]" multiple class="form-control" accept="image/*">
            </div>
            <div class="col-md-6">
                <label>Instalasi & Penyambungan ODP</label>
                <input type="file" name="odp[]" multiple class="form-control" accept="image/*">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Upload Foto</button>
    </form>
</div>
@endsection
