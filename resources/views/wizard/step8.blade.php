@extends('layouts.app')

@section('title', 'Data Mancore - Step 8')

@section('content')
<div class="container">
    <h3>Data Mancore (Penyambungan Core)</h3>

    <div class="mb-4">
        <div class="progress" style="height: 25px;">
            <div class="progress-bar bg-success" role="progressbar" style="width: 100%;">Step 8/8</div>
        </div>
        <div class="d-flex justify-content-between mt-1 small text-muted">
            <span>✓ Data Project</span>
            <span>✓ Commissioning</span>
            <span>✓ BOQ</span>
            <span>✓ Evidence</span>
            <span>✓ Marking</span>
            <span>✓ OPM</span>
            <span>✓ OTDR</span>
            <span>Mancore</span>
        </div>
    </div>

    <div class="alert alert-info">
        <strong>Project:</strong> {{ $project->name }}<br>
        <strong>Lokasi:</strong> {{ $project->location->name ?? '-' }} ({{ $project->location->code ?? '-' }})
    </div>

    <form method="POST" action="{{ route('wizard.step8.submit') }}">
        @csrf
        <div class="card mb-3">
            <div class="card-header bg-white fw-bold">Data Penyambungan Core di Closure</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Core Dari</th>
                            <th>Warna</th>
                            <th>Core Ke</th>
                            <th width="80">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="mancoreTable">
                        @foreach(old('core_from', $mancoreItems->pluck('core_from')->toArray()) as $index => $from)
                        <tr>
                            <td><input type="text" name="core_from[]" class="form-control" value="{{ $from }}" required></td>
                            <td><input type="text" name="warna[]" class="form-control" value="{{ old('warna')[$index] ?? ($mancoreItems[$index]->warna ?? '') }}" required></td>
                            <td><input type="text" name="core_to[]" class="form-control" value="{{ old('core_to')[$index] ?? ($mancoreItems[$index]->core_to ?? '') }}" required></td>
                            <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Hapus</button></td>
                        </tr>
                        @endforeach
                        @if(old('core_from', $mancoreItems->pluck('core_from')->toArray())->count() == 0)
                        <tr>
                            <td><input type="text" name="core_from[]" class="form-control" required placeholder="Contoh: Core 1"></td>
                            <td><input type="text" name="warna[]" class="form-control" required placeholder="Contoh: Biru"></td>
                            <td><input type="text" name="core_to[]" class="form-control" required placeholder="Contoh: Core 1"></td>
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
            <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Selesai - Buat Project</button>
        </div>
    </form>
</div>

<script>
function addRow(){
    const row = document.createElement('tr');
    row.innerHTML = `
        <td><input type="text" name="core_from[]" class="form-control" required></td>
        <td><input type="text" name="warna[]" class="form-control" required></td>
        <td><input type="text" name="core_to[]" class="form-control" required></td>
        <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Hapus</button></td>
    `;
    document.getElementById('mancoreTable').appendChild(row);
}
function removeRow(btn){ btn.closest('tr').remove(); }
</script>
@endsection
