@extends('layouts.app')

@section('title', 'Data Mancore')

@section('content')
<div class="container">
    <h3>Data Mancore</h3>

    <form method="POST" action="{{ route('projects.documents.mancore', $project) }}">
        @csrf
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Core</th>
                    <th>Warna</th>
                    <th>Tujuan</th>
                    <th width="80">Aksi</th>
                </tr>
            </thead>
            <tbody id="mancoreTable">
                <tr>
                    <td><input type="text" name="core_from[]" class="form-control" placeholder="Dari"></td>
                    <td><input type="text" name="warna[]" class="form-control"></td>
                    <td><input type="text" name="core_to[]" class="form-control" placeholder="Ke"></td>
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
        <td><input type="text" name="core_from[]" class="form-control"></td>
        <td><input type="text" name="warna[]" class="form-control"></td>
        <td><input type="text" name="core_to[]" class="form-control"></td>
        <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Hapus</button></td>
    </tr>`;
    document.getElementById('mancoreTable').insertAdjacentHTML('beforeend', row);
}

function removeRow(btn){
    btn.closest('tr').remove();
}
</script>
@endsection
