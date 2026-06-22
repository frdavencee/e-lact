@extends('layouts.app')

@section('title', 'Evidence ODP')

@section('content')
<div class="container">
    <h3>Lampiran Evidence ODP</h3>

    <form method="POST" action="{{ route('projects.documents.evidence', $project) }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="category" value="evidence_odp">

        <div class="mb-3">
            <label>Upload Foto ODP (Solid-PB-8 AS)</label>
            <input type="file" name="photos[]" multiple class="form-control" accept="image/*">
            <small class="text-muted">Upload foto pemasangan ODP, termasuk klem cooker</small>
        </div>

        <button type="submit" class="btn btn-primary">Upload Foto</button>
    </form>
</div>
@endsection
