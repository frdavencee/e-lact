@extends('layouts.app')

@section('title', 'Marking Kabel - Step 5')

@section('content')
<div class="container">
    <h3>Marking Kabel</h3>

    <div class="mb-4">
        <div class="progress" style="height: 25px;">
            <div class="progress-bar bg-success" role="progressbar" style="width: 62.5%;">Step 5/8</div>
        </div>
        <div class="d-flex justify-content-between mt-1 small text-muted">
            <span>✓ Data Project</span>
            <span>✓ Commissioning</span>
            <span>✓ BOQ</span>
            <span>✓ Evidence</span>
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

    <form method="POST" action="{{ route('wizard.step5.submit') }}">
        @csrf
        <div class="card mb-3">
            <div class="card-header bg-white fw-bold">Daftar Marking Kabel</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Jenis Kabel</th>
                            <th width="150">Panjang (m)</th>
                            <th width="80">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="markingTable">
                        @foreach(old('jenis_kabel', $markingKabels->pluck('jenis_kabel')->toArray()) as $index => $jenis)
                        <tr>
                            <td><input type="text" name="jenis_kabel[]" class="form-control" value="{{ $jenis }}" required></td>
                            <td><input type="number" step="0.01" name="panjang_meter[]" class="form-control" value="{{ old('panjang_meter')[$index] ?? ($markingKabels[$index]->panjang_meter ?? '') }}" required></td>
                            <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Hapus</button></td>
                        </tr>
                        @endforeach
                        @if(old('jenis_kabel', $markingKabels->pluck('jenis_kabel')->toArray())->count() == 0)
                        <tr>
                            <td><input type="text" name="jenis_kabel[]" class="form-control" required></td>
                            <td><input type="number" step="0.01" name="panjang_meter[]" class="form-control" required></td>
                            <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Hapus</button></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary" onclick="addRow()">Tambah Data</button>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('wizard.prev') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
            <button type="submit" class="btn btn-primary">Selanjutnya <i class="bi bi-arrow-right"></i></button>
        </div>
    </form>
</div>

<script>
function addRow(){
    const row = document.createElement('tr');
    row.innerHTML = `
        <td><input type="text" name="jenis_kabel[]" class="form-control" required></td>
        <td><input type="number" step="0.01" name="panjang_meter[]" class="form-control" required></td>
        <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Hapus</button></td>
    `;
    document.getElementById('markingTable').appendChild(row);
}
function removeRow(btn){ btn.closest('tr').remove(); }
</script>
@endsection
