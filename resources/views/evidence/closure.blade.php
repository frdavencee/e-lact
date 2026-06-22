@extends('layouts.app')

@section('title', 'Evidence Closure')

@section('content')
<div class="container">
    <h3>Lampiran Evidence Closure dan Splitter 1:4</h3>

    <form method="POST" action="{{ route('projects.documents.evidence', $project) }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="category" value="evidence_closure">

        <div class="mb-3">
            <label>Upload Foto SC-OF-SM-24 dan PS-1-4-ODC</label>
            <input type="file" name="photos[]" multiple class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Upload Foto</button>
    </form>
</div>
@endsection
