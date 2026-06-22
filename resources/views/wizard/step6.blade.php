@extends('layouts.app')

@section('title', 'Pengukuran OPM - Step 6')

@section('content')
<div class="container">
    <h3>Input Pengukuran OPM</h3>

    <div class="mb-4">
        <div class="progress" style="height: 25px;">
            <div class="progress-bar bg-success" role="progressbar" style="width: 75%;">Step 6/8</div>
        </div>
        <div class="d-flex justify-content-between mt-1 small text-muted">
            <span>✓ Data Project</span>
            <span>✓ Commissioning</span>
            <span>✓ BOQ</span>
            <span>✓ Evidence</span>
            <span>✓ Marking</span>
            <span>OPM</span>
            <span>OTDR</span>
            <span>Mancore</span>
        </div>
    </div>

    <div class="alert alert-info">
        <strong>Project:</strong> {{ $project->name }}<br>
        <strong>Lokasi:</strong> {{ $project->location->name ?? '-' }} ({{ $project->location->code ?? '-' }})
    </div>

    <form method="POST" action="{{ route('wizard.step6.submit') }}">
        @csrf

        <div class="card mb-3">
            <div class="card-header bg-white fw-bold">ODP-PAT-FW/114</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead><tr><th class="text-center">Port</th><th>Nilai (dBm)</th></tr></thead>
                    <tbody>
                        @for($i = 1; $i <= 8; $i++)
                        <tr>
                            <td class="text-center">{{ $i }}</td>
                            <td><input type="number" step="0.01" name="odp114[]" class="form-control" value="{{ $opmRecords->where('odp_name', 'ODP-PAT-FW/114')->where('port', $i)->first()->value ?? '' }}"></td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header bg-white fw-bold">ODP-PAT-FW/115</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead><tr><th class="text-center">Port</th><th>Nilai (dBm)</th></tr></thead>
                    <tbody>
                        @for($i = 1; $i <= 8; $i++)
                        <tr>
                            <td class="text-center">{{ $i }}</td>
                            <td><input type="number" step="0.01" name="odp115[]" class="form-control" value="{{ $opmRecords->where('odp_name', 'ODP-PAT-FW/115')->where('port', $i)->first()->value ?? '' }}"></td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('wizard.prev') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
            <button type="submit" class="btn btn-primary">Selanjutnya <i class="bi bi-arrow-right"></i></button>
        </div>
    </form>
</div>
@endsection
