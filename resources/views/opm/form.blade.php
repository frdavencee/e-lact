@extends('layouts.app')

@section('title', 'Pengukuran OPM')

@section('content')
<div class="container">
    <h3>Input Pengukuran OPM</h3>

    <form method="POST" action="{{ route('projects.documents.opm', $project) }}">
        @csrf

        <h5>ODP-PAT-FW/114</h5>
        <table class="table table-bordered mb-4">
            <thead><tr><th>Port</th><th>dBm</th></tr></thead>
            <tbody>
                @for($i = 1; $i <= 8; $i++)
                <tr>
                    <td class="text-center">{{ $i }}</td>
                    <td><input type="number" step="0.01" name="odp114[]" class="form-control"></td>
                </tr>
                @endfor
            </tbody>
        </table>

        <h5>ODP-PAT-FW/115</h5>
        <table class="table table-bordered mb-4">
            <thead><tr><th>Port</th><th>dBm</th></tr></thead>
            <tbody>
                @for($i = 1; $i <= 8; $i++)
                <tr>
                    <td class="text-center">{{ $i }}</td>
                    <td><input type="number" step="0.01" name="odp115[]" class="form-control"></td>
                </tr>
                @endfor
            </tbody>
        </table>

        <button type="submit" class="btn btn-success">Simpan Data OPM</button>
    </form>
</div>
@endsection
