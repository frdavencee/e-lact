<h5>Data BOQ</h5>
<form method="POST" action="{{ route('boq.store', $lokasi) }}" class="row g-2 mb-3">
    @csrf
    <div class="col-md-2"><input type="text" name="kode_item" class="form-control-soft input-mono" placeholder="Kode Item" required></div>
    <div class="col-md-3"><input type="text" name="nama_item" class="form-control-soft" placeholder="Nama Item" required></div>
    <div class="col-md-2"><input type="text" name="satuan" class="form-control-soft input-mono" placeholder="Satuan" required></div>
    <div class="col-md-2"><input type="number" step="0.01" name="volume" class="form-control-soft input-mono" placeholder="Volume" required></div>
    <div class="col-md-2"><input type="text" name="keterangan" class="form-control-soft" placeholder="Keterangan"></div>
    <div class="col-md-1"><button type="submit" class="btn-primary-gradient w-100"><i class="bi bi-plus"></i></button></div>
</form>
<div class="table-responsive">
    <table class="table-modern">
        <thead><tr><th>Kode</th><th>Nama Item</th><th>Satuan</th><th>Volume</th><th>Ket</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($lokasi->boqItems as $item)
            <tr>
                <td><span class="badge-modern-sm" style="background: #f3f4f6; color: #4b5563;">{{ $item->kode_item }}</span></td>
                <td>{{ $item->nama_item }}</td>
                <td>{{ $item->satuan }}</td>
                <td>{{ $item->volume }}</td>
                <td>{{ $item->keterangan }}</td>
                <td>
                    <form action="{{ route('boq.destroy', [$lokasi, $item]) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="action-icon-btn btn-delete" title="Hapus"><i class="bi bi-trash"></i></button></form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>