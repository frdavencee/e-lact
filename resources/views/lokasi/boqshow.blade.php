@extends('layouts.app')

@section('title', 'BOQ - ' . $lokasi->code)

@section('content')
<div class="detail-header">
    <h2>BOQ - {{ $lokasi->code }} - {{ $lokasi->name }}</h2>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('lokasi.index') }}" class="btn-soft-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
        <button type="button" id="importExcelBtn" class="btn-soft-secondary"><i class="bi bi-file-earmark-spreadsheet"></i> Import Excel</button>
        <input type="file" id="excelFileInput" accept=".xlsx,.xls" style="display:none;">
        <button type="button" onclick="addBoqItem()" class="btn-soft-secondary"><i class="bi bi-plus"></i> Tambah Item</button>
        <button type="button" onclick="saveBoqItems()" class="btn-primary-gradient"><i class="bi bi-save"></i> Simpan Semua</button>
    </div>
</div>

<div id="save-msg" style="display:none;" class="alert-custom mb-3"></div>

<div class="detail-card mb-4">
    <div class="detail-card-body">
        <table class="info-table">
            <tr><th>Kode Lokasi</th><td>{{ $lokasi->code }}</td></tr>
            <tr><th>Nama Lokasi</th><td>{{ $lokasi->name }}</td></tr>
            <tr><th>Branch</th><td>{{ $lokasi->branch->name ?? '-' }}</td></tr>
            <tr><th>Status</th><td>{{ ucfirst($lokasi->status) }}</td></tr>
            <tr><th>Total Item</th><td id="item-count">{{ $items->count() }} item</td></tr>
        </table>
    </div>
</div>

<div class="detail-card">
    <div class="detail-card-body">
        <div class="table-responsive">
            <table class="table-modern" id="boq-table" style="min-width:1000px;">
                <thead>
                    <tr>
                        <th width="40" rowspan="2" style="vertical-align:middle;">#</th>
                        <th width="110" rowspan="2" style="vertical-align:middle;">Kode</th>
                        <th rowspan="2" style="vertical-align:middle;">Nama Item</th>
                        <th width="90" rowspan="2" style="vertical-align:middle;">Satuan</th>
                        <th colspan="4" style="text-align:center;">Volume</th>
                        <th rowspan="2" style="vertical-align:middle;">Keterangan</th>
                        <th width="40" rowspan="2"></th>
                    </tr>
                    <tr>
                        <th width="85" style="text-align:center;">DRM</th>
                        <th width="85" style="text-align:center;">Aktual</th>
                        <th width="85" style="text-align:center;">Tambah</th>
                        <th width="85" style="text-align:center;">Kurang</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($items as $boq)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><input type="text" class="form-control-soft input-mono" style="padding:0.4rem 0.5rem;font-size:0.8rem;" name="boq[{{ $i }}][kode_item]" value="{{ $boq->kode_item ?? '' }}"></td>
                        <td><input type="text" class="form-control-soft" style="padding:0.4rem 0.5rem;font-size:0.8rem;" name="boq[{{ $i }}][nama_item]" value="{{ $boq->nama_item ?? '' }}"></td>
                        <td><input type="text" class="form-control-soft input-mono" style="padding:0.4rem 0.5rem;font-size:0.8rem;" name="boq[{{ $i }}][satuan]" value="{{ $boq->satuan ?? '' }}"></td>
                        <td><input type="number" step="any" class="form-control-soft input-mono" style="padding:0.4rem 0.5rem;font-size:0.8rem;text-align:center;" name="boq[{{ $i }}][volume_drm]" value="{{ $boq->volume_drm ?? '' }}"></td>
                        <td><input type="number" step="any" class="form-control-soft input-mono" style="padding:0.4rem 0.5rem;font-size:0.8rem;text-align:center;" name="boq[{{ $i }}][volume_aktual]" value="{{ $boq->volume_aktual ?? '' }}"></td>
                        <td><input type="number" step="any" class="form-control-soft input-mono" style="padding:0.4rem 0.5rem;font-size:0.8rem;text-align:center;" name="boq[{{ $i }}][volume_tambah]" value="{{ $boq->volume_tambah ?? '' }}"></td>
                        <td><input type="number" step="any" class="form-control-soft input-mono" style="padding:0.4rem 0.5rem;font-size:0.8rem;text-align:center;" name="boq[{{ $i }}][volume_kurang]" value="{{ $boq->volume_kurang ?? '' }}"></td>
                        <td><input type="text" class="form-control-soft" style="padding:0.4rem 0.5rem;font-size:0.8rem;" name="boq[{{ $i }}][keterangan]" value="{{ $boq->keterangan ?? '' }}"></td>
                        <td><button type="button" class="btn-danger-sm" onclick="removeRow(this)">×</button></td>
                    </tr>
                    @php $i++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
<script>
const CSRF = '{{ csrf_token() }}';
const LOKASI_ID = '{{ $lokasi->id }}';

function renumberRows() {
    const rows = document.querySelectorAll('#boq-table tbody tr');
    rows.forEach((row, i) => {
        row.cells[0].textContent = i + 1;
        row.querySelectorAll('input').forEach(inp => {
            inp.name = inp.name.replace(/\[\d+\]/, `[${i}]`);
        });
    });
    document.getElementById('item-count').textContent = rows.length + ' item';
}

function removeRow(btn) {
    btn.closest('tr').remove();
    renumberRows();
}

function addBoqItem() {
    const tbody = document.querySelector('#boq-table tbody');
    const idx = tbody.rows.length;
    const tr = tbody.insertRow();
    tr.innerHTML = `
        <td>${idx + 1}</td>
        <td><input type="text" class="form-control-soft input-mono" style="padding:0.4rem 0.5rem;font-size:0.8rem;" name="boq[${idx}][kode_item]"></td>
        <td><input type="text" class="form-control-soft" style="padding:0.4rem 0.5rem;font-size:0.8rem;" name="boq[${idx}][nama_item]"></td>
        <td><input type="text" class="form-control-soft input-mono" style="padding:0.4rem 0.5rem;font-size:0.8rem;" name="boq[${idx}][satuan]"></td>
        <td><input type="number" step="any" class="form-control-soft input-mono" style="padding:0.4rem 0.5rem;font-size:0.8rem;text-align:center;" name="boq[${idx}][volume_drm]"></td>
        <td><input type="number" step="any" class="form-control-soft input-mono" style="padding:0.4rem 0.5rem;font-size:0.8rem;text-align:center;" name="boq[${idx}][volume_aktual]"></td>
        <td><input type="number" step="any" class="form-control-soft input-mono" style="padding:0.4rem 0.5rem;font-size:0.8rem;text-align:center;" name="boq[${idx}][volume_tambah]"></td>
        <td><input type="number" step="any" class="form-control-soft input-mono" style="padding:0.4rem 0.5rem;font-size:0.8rem;text-align:center;" name="boq[${idx}][volume_kurang]"></td>
        <td><input type="text" class="form-control-soft" style="padding:0.4rem 0.5rem;font-size:0.8rem;" name="boq[${idx}][keterangan]"></td>
        <td><button type="button" class="btn-danger-sm" onclick="removeRow(this)">×</button></td>
    `;
    renumberRows();
    tr.querySelector('[name*="[nama_item]"]').focus();
}

function showMsg(text, success) {
    const el = document.getElementById('save-msg');
    el.className = 'alert-custom mb-3 ' + (success ? 'alert-success-custom' : 'alert-error-custom');
    el.textContent = text;
    el.style.display = 'flex';
    setTimeout(() => { el.style.display = 'none'; }, 3500);
}

function saveBoqItems() {
    const rows = Array.from(document.querySelectorAll('#boq-table tbody tr'));
    const form = new FormData();
    form.append('_token', CSRF);
    rows.forEach(row => {
        row.querySelectorAll('input').forEach(inp => form.append(inp.name, inp.value));
    });

    showMsg('Menyimpan...', true);

    fetch('/lokasi/' + LOKASI_ID + '/boq', { method: 'POST', body: form })
        .then(r => r.json())
        .then(d => showMsg(d.success ? 'BOQ berhasil disimpan.' : 'Gagal menyimpan BOQ.', !!d.success))
        .catch(() => showMsg('Gagal menyimpan BOQ.', false));
}

// Excel Import
document.getElementById('importExcelBtn').addEventListener('click', () => {
    document.getElementById('excelFileInput').click();
});

document.getElementById('excelFileInput').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function (e) {
        const wb = XLSX.read(new Uint8Array(e.target.result), { type: 'array' });
        const rows = XLSX.utils.sheet_to_json(wb.Sheets[wb.SheetNames[0]], { header: 1, defval: '' });

        let colNo=-1, colDesignator=-1, colUraian=-1, colSatuan=-1;
        let colDrm=-1, colAktual=-1, colTambah=-1, colKurang=-1, dataStart=0;

        for (let i = 0; i < rows.length; i++) {
            const r = rows[i].map(c => String(c).trim().toUpperCase());
            if (colDesignator === -1 && r.includes('DESIGNATOR')) {
                colNo = r.indexOf('NO');
                colDesignator = r.indexOf('DESIGNATOR');
                colUraian = r.findIndex(c => c.includes('URAIAN'));
                colSatuan = r.indexOf('SATUAN');
            }
            if (colDrm === -1 && r.includes('DRM') && r.includes('AKTUAL')) {
                colDrm = r.indexOf('DRM');
                colAktual = r.indexOf('AKTUAL');
                colTambah = r.indexOf('TAMBAH');
                colKurang = r.indexOf('KURANG');
                dataStart = i + 1;
                break;
            }
        }

        if (colDesignator === -1 || colDrm === -1) {
            alert('Format Excel tidak dikenali. Pastikan ada kolom DESIGNATOR, DRM, dan AKTUAL.');
            return;
        }

        const toNum = v => { const n = parseFloat(String(v ?? '').trim()); return isNaN(n) ? '' : String(n); };
        const tbody = document.querySelector('#boq-table tbody');
        tbody.innerHTML = '';
        let idx = 0;

        for (let i = dataStart; i < rows.length; i++) {
            const row = rows[i];
            if (!String(row[colNo] ?? '').trim() || isNaN(Number(String(row[colNo]).trim()))) continue;
            const kode   = String(row[colDesignator] ?? '').trim();
            const nama   = String(row[colUraian] ?? '').trim();
            const satuan = String(row[colSatuan] ?? '').trim();
            const drm    = toNum(row[colDrm]);
            const aktual = toNum(row[colAktual]);
            const tambah = colTambah >= 0 ? toNum(row[colTambah]) : '';
            const kurang = colKurang >= 0 ? toNum(row[colKurang]) : '';
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${idx + 1}</td>
                <td><input type="text" class="form-control-soft input-mono" style="padding:0.4rem 0.5rem;font-size:0.8rem;" name="boq[${idx}][kode_item]" value="${kode}"></td>
                <td><input type="text" class="form-control-soft" style="padding:0.4rem 0.5rem;font-size:0.8rem;" name="boq[${idx}][nama_item]" value="${nama}"></td>
                <td><input type="text" class="form-control-soft input-mono" style="padding:0.4rem 0.5rem;font-size:0.8rem;" name="boq[${idx}][satuan]" value="${satuan}"></td>
                <td><input type="number" step="any" class="form-control-soft input-mono" style="padding:0.4rem 0.5rem;font-size:0.8rem;text-align:center;" name="boq[${idx}][volume_drm]" value="${drm}"></td>
                <td><input type="number" step="any" class="form-control-soft input-mono" style="padding:0.4rem 0.5rem;font-size:0.8rem;text-align:center;" name="boq[${idx}][volume_aktual]" value="${aktual}"></td>
                <td><input type="number" step="any" class="form-control-soft input-mono" style="padding:0.4rem 0.5rem;font-size:0.8rem;text-align:center;" name="boq[${idx}][volume_tambah]" value="${tambah}"></td>
                <td><input type="number" step="any" class="form-control-soft input-mono" style="padding:0.4rem 0.5rem;font-size:0.8rem;text-align:center;" name="boq[${idx}][volume_kurang]" value="${kurang}"></td>
                <td><input type="text" class="form-control-soft" style="padding:0.4rem 0.5rem;font-size:0.8rem;" name="boq[${idx}][keterangan]"></td>
                <td><button type="button" class="btn-danger-sm" onclick="removeRow(this)">×</button></td>
            `;
            tbody.appendChild(tr);
            idx++;
        }
        document.getElementById('item-count').textContent = idx + ' item';
        if (idx > 0) saveBoqItems();
    };
    reader.readAsArrayBuffer(file);
    this.value = '';
});
</script>
@endpush
