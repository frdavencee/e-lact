@extends('layouts.app')

@section('title', 'Upload OTDR')

@section('content')
<div class="container">
    <h3>Upload Hasil Ukur OTDR</h3>

    <form method="POST" action="{{ route('projects.documents.otdr', $project) }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>ODP 114</label>
            <input type="file" name="otdr114" class="form-control" accept="image/*,.pdf">
        </div>

        <div class="mb-3">
            <label>ODP 115</label>
            <input type="file" name="otdr115" class="form-control" accept="image/*,.pdf">
        </div>

        <button type="submit" class="btn btn-primary">Upload File OTDR</button>
    </form>
</div>
@endsection
