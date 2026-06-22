@extends('layouts.app')

@section('title', 'Evidence Aksesoris')

@section('content')
<div class="container">
    <h3>Lampiran Evidence Aksesoris</h3>

    <form method="POST" action="{{ route('projects.documents.evidence', $project) }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="category" value="evidence_aksesoris">

        <div class="mb-3">
            <label>Upload Foto Aksesoris (PU-AS-HL 1-10 & PU-AS-SC 1-11)</label>
            <input type="file" name="photos[]" multiple class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Upload Foto</button>
    </form>
</div>
@endsection
