@extends('layouts.app')

@section('title', 'BOQ - ' . $lokasi->code)

@section('content')
<div class="detail-header">
    <h2>BOQ - {{ $lokasi->code }} - {{ $lokasi->name }}</h2>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('lokasi.index') }}" class="btn-soft-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
        <button type="button" onclick="saveBoqItems()" class="btn-primary-gradient">Simpan Semua</button>
        <button type="button" onclick="addBoqItem()" class="btn-soft-secondary"><i class="bi bi-plus"></i> Tambah Item</button>
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
            <table class="table-modern" id="boq-table">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Kode</th>
                        <th>Deskripsi</th>
                        <th width="100">Qty</th>
                        <th width="120">Satuan</th>
                        <th width="50"></th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @php $boqIndex = 0; @endphp
                    @foreach($items as $boq)
                    <tr>
                        <td>{{ $boqIndex + 1 }}</td>
                        <td><input type="text" class="form-control-soft input-mono" name="boq[{{ $boqIndex }}][kode_item]" value="{{ $boq->kode_item ?? '' }}"></td>
                        <td><input type="text" class="form-control-soft" name="boq[{{ $boqIndex }}][nama_item]" value="{{ $boq->nama_item ?? '' }}"></td>
                        <td><input type="text" class="form-control-soft input-mono" name="boq[{{ $boqIndex }}][volume]" value="{{ $boq->volume ?? '' }}"></td>
                        <td><input type="text" class="form-control-soft input-mono" name="boq[{{ $boqIndex }}][satuan]" value="{{ $boq->satuan ?? '' }}"></td>
                        <td><button type="button" class="btn-danger-sm" onclick="this.closest('tr').remove()">×</button></td>
                        <td><input type="text" class="form-control-soft" name="boq[{{ $boqIndex }}][keterangan]" value="{{ $boq->keterangan ?? '' }}"></td>
                    </tr>
                    @php $boqIndex++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function addBoqItem() {
        const table = document.getElementById('boq-table').querySelector('tbody');
        const index = table.rows.length;
        const row = table.insertRow();
        row.innerHTML = `
            <td>${index + 1}</td>
            <td><input type="text" class="form-control-soft input-mono" name="boq[${index}][kode_item]"></td>
            <td><input type="text" class="form-control-soft" name="boq[${index}][nama_item]"></td>
            <td><input type="text" class="form-control-soft input-mono" name="boq[${index}][volume]"></td>
            <td><input type="text" class="form-control-soft input-mono" name="boq[${index}][satuan]"></td>
            <td><button type="button" class="btn-danger-sm" onclick="this.closest('tr').remove()">×</button></td>
            <td><input type="text" class="form-control-soft" name="boq[${index}][keterangan]"></td>
        `;
    }

    function saveBoqItems() {
        const lokasiId = '{{ $lokasi->id }}';
        const rows = Array.from(document.querySelectorAll('#boq-table tbody tr'));
        const form = new FormData();
        form.append('_token', '{{ csrf_token() }}');
        rows.forEach((row, index) => {
            Array.from(row.querySelectorAll('input')).forEach(input => form.append(input.name, input.value));
        });

        fetch('/lokasi/' + lokasiId + '/boq', { method: 'POST', body: form })
            .then(r => r.json())
            .then(data => {
                if (data.success) alert('BOQ berhasil disimpan.');
                else alert('Gagal menyimpan BOQ');
            })
            .catch(() => alert('Gagal menyimpan BOQ'));
    }
</script>
@endsection
