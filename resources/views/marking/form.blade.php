@extends('layouts.app')

@section('title', 'Marking Kabel')

@section('content')
<div class="container">
    <h3>Marking Kabel</h3>

    <form method="POST" action="{{ route('projects.documents.marking', $project) }}">
        @csrf
        <table class="table">
            <thead>
                <tr>
                    <th>Jenis Kabel</th>
                    <th>Panjang (m)</th>
                    <th width="80">Aksi</th>
                </tr>
            </thead>
            <tbody id="markingTable">
                <tr>
                    <td><input type="text" name="jenis_kabel[]" class="form-control" required></td>
                    <td><input type="number" step="0.01" name="panjang_meter[]" class="form-control" required></td>
                    <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Hapus</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" class="btn btn-primary" onclick="addRow()">Tambah Data</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>

<script>
function addRow(){
    let row = `
    <tr>
        <td><input type="text" name="jenis_kabel[]" class="form-control" required></td>
        <td><input type="number" step="0.01" name="panjang_meter[]" class="form-control" required></td>
        <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Hapus</button></td>
    </tr>`;
    document.getElementById('markingTable').insertAdjacentHTML('beforeend', row);
}

function removeRow(btn){
    btn.closest('tr').remove();
}
</script>
@endsection
