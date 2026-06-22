@extends('layouts.app')

@section('title', 'BOQ - Step 3')

@section('content')
<div class="container">
    <h3>Bill of Quantity (BOQ)</h3>

    <div class="mb-4">
        <div class="progress" style="height: 25px;">
            <div class="progress-bar bg-success" role="progressbar" style="width: 37.5%;">Step 3/8</div>
        </div>
        <div class="d-flex justify-content-between mt-1 small text-muted">
            <span>✓ Data Project</span>
            <span>✓ Commissioning</span>
            <span>BOQ</span>
            <span>Evidence</span>
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

    <form method="POST" action="{{ route('wizard.step3.submit') }}">
        @csrf
        <div class="card mb-3">
            <div class="card-header bg-white fw-bold">Daftar Item Pekerjaan</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Material / Uraian Pekerjaan</th>
                            <th width="150">Volume</th>
                            <th width="100">Satuan</th>
                            <th width="80">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="boqTable">
                        @foreach(old('item_name', $boqItems->pluck('name')->toArray()) as $index => $name)
                        <tr>
                            <td><input type="text" name="item_name[]" class="form-control" value="{{ $name }}" required></td>
                            <td><input type="number" step="0.01" name="qty[]" class="form-control" value="{{ old('qty')[$index] ?? ($boqItems[$index]->volume ?? '') }}" required></td>
                            <td><input type="text" name="unit[]" class="form-control" value="{{ old('unit')[$index] ?? ($boqItems[$index]->unit ?? '') }}" required></td>
                            <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Hapus</button></td>
                        </tr>
                        @endforeach
                        @if(old('item_name', $boqItems->pluck('name')->toArray())->count() == 0)
                        <tr>
                            <td><input type="text" name="item_name[]" class="form-control" required></td>
                            <td><input type="number" step="0.01" name="qty[]" class="form-control" required></td>
                            <td><input type="text" name="unit[]" class="form-control" required></td>
                            <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Hapus</button></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary" onclick="addRow()">Tambah Item</button>
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
        <td><input type="text" name="item_name[]" class="form-control" required></td>
        <td><input type="number" step="0.01" name="qty[]" class="form-control" required></td>
        <td><input type="text" name="unit[]" class="form-control" required></td>
        <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Hapus</button></td>
    `;
    document.getElementById('boqTable').appendChild(row);
}
function removeRow(btn){ btn.closest('tr').remove(); }
</script>
@endsection
