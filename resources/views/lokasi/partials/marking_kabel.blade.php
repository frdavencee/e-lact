<h5>Data Marking Kabel</h5>
<form method="POST" action="{{ route('marking-kabel.store', $lokasi) }}" class="row g-2 mb-3">

    @csrf
    <div class="col-md-5"><input type="text" name="jenis_kabel" class="form-control-soft" placeholder="Jenis Kabel" required></div>
    <div class="col-md-3"><input type="number" step="0.01" name="panjang_meter" class="form-control-soft input-mono" placeholder="Panjang (m)" required></div>
    <div class="col-md-2"><button type="submit" class="btn-primary-gradient w-100"><i class="bi bi-plus"></i> Tambah</button></div>
</form>
<div class="table-responsive">
    <table class="table-modern">
        <thead><tr><th>Jenis Kabel</th><th>Panjang (Meter)</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($lokasi->markingKabel as $mk)
            <tr>
                <td>{{ $mk->jenis_kabel }}</td>
                <td><span class="badge-modern-sm" style="background: #dbeafe; color: #1e40af;">{{ $mk->panjang_meter }} m</span></td>
                <td>
                    <form action="{{ route('marking-kabel.destroy', [$lokasi, $mk]) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">
                        @csrf @method('DELETE')
                        <button class="action-icon-btn btn-delete" title="Hapus"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>