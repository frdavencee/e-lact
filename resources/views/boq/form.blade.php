@extends('layouts.app')

@section('title', 'Bill of Quantity')

@section('content')
<div class="container">
    <h3>Bill Of Quantity</h3>

    <form method="POST" action="{{ route('projects.documents.boq.store', $project) }}">
        @csrf
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Volume</th>
                    <th>Satuan</th>
                    <th width="80">Aksi</th>
                </tr>
            </thead>
            <tbody id="boqTable">
                <tr>
                    <td><input type="text" name="item_name[]" class="form-control" required></td>
                    <td><input type="number" step="0.01" name="qty[]" class="form-control" required></td>
                    <td><input type="text" name="unit[]" class="form-control" required></td>
                    <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Hapus</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" class="btn btn-primary" onclick="addRow()">Tambah Item</button>
        <button type="submit" class="btn btn-success">Simpan Semua</button>
    </form>
</div>

<script>
function addRow(){
    let row = `
    <tr>
        <td><input type="text" name="item_name[]" class="form-control" required></td>
        <td><input type="number" step="0.01" name="qty[]" class="form-control" required></td>
        <td><input type="text" name="unit[]" class="form-control" required></td>
        <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Hapus</button></td>
    </tr>`;
    document.getElementById('boqTable').insertAdjacentHTML('beforeend', row);
}

function removeRow(btn){
    btn.closest('tr').remove();
}
</script>
@endsection
