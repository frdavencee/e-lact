@extends('layouts.app')

@section('title', 'Marking Kabel - ' . $lokasi->code)

@section('content')
<div class="detail-header">
    <h2>Marking Kabel - {{ $lokasi->code }} - {{ $lokasi->name }}</h2>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('lokasi.index') }}" class="btn-soft-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
        <button type="button" onclick="saveMarkingKabel()" class="btn-primary-gradient">Simpan Semua</button>
        <button type="button" onclick="addMarkingRow()" class="btn-soft-secondary"><i class="bi bi-plus"></i> Tambah Item</button>
    </div>
</div>

<div class="detail-card mb-4">
    <div class="detail-card-body">
        <table class="info-table">
            <tr><th>Kode Lokasi</th><td>{{ $lokasi->code }}</td></tr>
            <tr><th>Nama Lokasi</th><td>{{ $lokasi->name }}</td></tr>
            <tr><th>Branch</th><td>{{ $lokasi->branch->name ?? '-' }}</td></tr>
            <tr><th>Status</th><td>{{ ucfirst($lokasi->status) }}</td></tr>
            <tr><th>Total Item</th><td>{{ $items->count() }} item</td></tr>
        </table>
    </div>
</div>

<div class="detail-card">
    <div class="detail-card-body">
        <div class="table-responsive">
            <table class="table-modern" id="marking-table">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Jenis Kabel</th>
                        <th width="140">Panjang (m)</th>
                        <th width="50"></th>
                    </tr>
                </thead>
                <tbody>
                    @php $mkIndex = 0; @endphp
                    @foreach($items as $mk)
                    <tr>
                        <td>{{ $mkIndex + 1 }}</td>
                        <td><input type="text" class="form-control-soft" name="marking[{{ $mkIndex }}][jenis_kabel]" value="{{ $mk->jenis_kabel }}"></td>
                        <td><input type="number" step="0.01" class="form-control-soft input-mono" name="marking[{{ $mkIndex }}][panjang_meter]" value="{{ $mk->panjang_meter }}"></td>
                        <td><button type="button" class="btn-danger-sm" onclick="this.closest('tr').remove()">×</button></td>
                    </tr>
                    @php $mkIndex++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function addMarkingRow() {
        const table = document.getElementById('marking-table').querySelector('tbody');
        const index = table.rows.length;
        const row = table.insertRow();
        row.innerHTML = `
            <td>${index + 1}</td>
            <td><input type="text" class="form-control-soft" name="marking[${index}][jenis_kabel]"></td>
            <td><input type="number" step="0.01" class="form-control-soft input-mono" name="marking[${index}][panjang_meter]" value="0"></td>
            <td><button type="button" class="btn-danger-sm" onclick="this.closest('tr').remove()">×</button></td>
        `;
    }

    function saveMarkingKabel() {
        const lokasiId = '{{ $lokasi->id }}';
        const rows = Array.from(document.querySelectorAll('#marking-table tbody tr'));
        const form = new FormData();
        form.append('_token', '{{ csrf_token() }}');
        rows.forEach((row, index) => {
            Array.from(row.querySelectorAll('input')).forEach(input => form.append(input.name, input.value));
        });

        fetch('/lokasi/' + lokasiId + '/marking-kabel', { method: 'POST', body: form })
            .then(r => r.json())
            .then(data => {
                if (data.success) alert('Marking kabel berhasil disimpan.');
                else alert('Gagal menyimpan marking kabel');
            })
            .catch(() => alert('Gagal menyimpan marking kabel'));
    }
</script>
@endpush
