<div id="boq-msg-partial" style="display:none;" class="alert-custom mb-3"></div>

<div class="d-flex gap-2 flex-wrap mb-3">
    <button type="button" id="boqImportBtn" class="btn-soft-secondary btn-sm">
        <i class="bi bi-file-earmark-spreadsheet"></i> Import Excel
    </button>
    <input type="file" id="boqExcelInput" accept=".xlsx,.xls" style="display:none;">
    <button type="button" onclick="addBoqRow()" class="btn-soft-secondary btn-sm">
        <i class="bi bi-plus"></i> Tambah Baris
    </button>
    <button type="button" onclick="hapusSemuaBoq()" class="btn-soft-secondary btn-sm" style="color:#dc2626;border-color:#dc2626;">
        <i class="bi bi-trash"></i> Hapus Semua
    </button>
    <button type="button" onclick="saveBoq()" class="btn-primary-gradient btn-sm">
        <i class="bi bi-save"></i> Simpan BOQ
    </button>
</div>

<div class="table-responsive">
    <table class="table-modern" id="boq-partial-table" style="min-width:950px;">
        <thead>
            <tr>
                <th width="35" rowspan="2" style="vertical-align:middle;">#</th>
                <th width="110" rowspan="2" style="vertical-align:middle;">Kode</th>
                <th rowspan="2" style="vertical-align:middle;">Nama Item</th>
                <th width="80" rowspan="2" style="vertical-align:middle;">Satuan</th>
                <th colspan="4" style="text-align:center;border-bottom:1px solid #e5e7eb;">Volume</th>
                <th rowspan="2" style="vertical-align:middle;">Keterangan</th>
                <th width="35" rowspan="2"></th>
            </tr>
            <tr>
                <th width="80" style="text-align:center;">DRM</th>
                <th width="80" style="text-align:center;">Aktual</th>
                <th width="80" style="text-align:center;">Tambah</th>
                <th width="80" style="text-align:center;">Kurang</th>
            </tr>
        </thead>
        <tbody id="boq-partial-tbody">
            @forelse($lokasi->boqItems as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td><input type="text" class="form-control-soft input-mono" style="padding:0.35rem 0.5rem;font-size:0.8rem;" name="boq[{{ $i }}][kode_item]" value="{{ $item->kode_item ?? '' }}"></td>
                <td><input type="text" class="form-control-soft" style="padding:0.35rem 0.5rem;font-size:0.8rem;" name="boq[{{ $i }}][nama_item]" value="{{ $item->nama_item ?? '' }}"></td>
                <td><input type="text" class="form-control-soft input-mono" style="padding:0.35rem 0.5rem;font-size:0.8rem;" name="boq[{{ $i }}][satuan]" value="{{ $item->satuan ?? '' }}"></td>
                <td><input type="number" step="any" class="form-control-soft input-mono" style="padding:0.35rem 0.3rem;font-size:0.8rem;text-align:center;" name="boq[{{ $i }}][volume_drm]" value="{{ $item->volume_drm ?? '' }}"></td>
                <td><input type="number" step="any" class="form-control-soft input-mono" style="padding:0.35rem 0.3rem;font-size:0.8rem;text-align:center;" name="boq[{{ $i }}][volume_aktual]" value="{{ $item->volume_aktual ?? '' }}"></td>
                <td><input type="number" step="any" class="form-control-soft input-mono" style="padding:0.35rem 0.3rem;font-size:0.8rem;text-align:center;" name="boq[{{ $i }}][volume_tambah]" value="{{ $item->volume_tambah ?? '' }}"></td>
                <td><input type="number" step="any" class="form-control-soft input-mono" style="padding:0.35rem 0.3rem;font-size:0.8rem;text-align:center;" name="boq[{{ $i }}][volume_kurang]" value="{{ $item->volume_kurang ?? '' }}"></td>
                <td><input type="text" class="form-control-soft" style="padding:0.35rem 0.5rem;font-size:0.8rem;" name="boq[{{ $i }}][keterangan]" value="{{ $item->keterangan ?? '' }}"></td>
                <td><button type="button" class="btn-danger-sm" onclick="this.closest('tr').remove();boqRenumber()">×</button></td>
            </tr>
            @empty
            <tr id="boq-empty-row">
                <td colspan="10"><div class="empty-state" style="padding:1.5rem;"><i class="bi bi-table"></i><p>Belum ada data BOQ.</p></div></td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@push('scripts')
<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
<script>
(function() {
    const CSRF_BOQ = '{{ csrf_token() }}';
    const LOKASI_BOQ = {{ $lokasi->id }};

    window.boqRenumber = function() {
        document.querySelectorAll('#boq-partial-tbody tr:not(#boq-empty-row)').forEach((row, i) => {
            row.cells[0].textContent = i + 1;
            row.querySelectorAll('input').forEach(inp => {
                inp.name = inp.name.replace(/\[\d+\]/, `[${i}]`);
            });
        });
    };

    window.addBoqRow = function() {
        const emptyRow = document.getElementById('boq-empty-row');
        if (emptyRow) emptyRow.remove();
        const tbody = document.getElementById('boq-partial-tbody');
        const idx = tbody.querySelectorAll('tr').length;
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${idx + 1}</td>
            <td><input type="text" class="form-control-soft input-mono" style="padding:0.35rem 0.5rem;font-size:0.8rem;" name="boq[${idx}][kode_item]"></td>
            <td><input type="text" class="form-control-soft" style="padding:0.35rem 0.5rem;font-size:0.8rem;" name="boq[${idx}][nama_item]"></td>
            <td><input type="text" class="form-control-soft input-mono" style="padding:0.35rem 0.5rem;font-size:0.8rem;" name="boq[${idx}][satuan]"></td>
            <td><input type="number" step="any" class="form-control-soft input-mono" style="padding:0.35rem 0.3rem;font-size:0.8rem;text-align:center;" name="boq[${idx}][volume_drm]"></td>
            <td><input type="number" step="any" class="form-control-soft input-mono" style="padding:0.35rem 0.3rem;font-size:0.8rem;text-align:center;" name="boq[${idx}][volume_aktual]"></td>
            <td><input type="number" step="any" class="form-control-soft input-mono" style="padding:0.35rem 0.3rem;font-size:0.8rem;text-align:center;" name="boq[${idx}][volume_tambah]"></td>
            <td><input type="number" step="any" class="form-control-soft input-mono" style="padding:0.35rem 0.3rem;font-size:0.8rem;text-align:center;" name="boq[${idx}][volume_kurang]"></td>
            <td><input type="text" class="form-control-soft" style="padding:0.35rem 0.5rem;font-size:0.8rem;" name="boq[${idx}][keterangan]"></td>
            <td><button type="button" class="btn-danger-sm" onclick="this.closest('tr').remove();boqRenumber()">×</button></td>
        `;
        tbody.appendChild(tr);
        tr.querySelector('[name*="[nama_item]"]').focus();
    };

    function showBoqMsg(text, ok) {
        const el = document.getElementById('boq-msg-partial');
        el.className = 'alert-custom mb-3 ' + (ok ? 'alert-success-custom' : 'alert-error-custom');
        el.textContent = text;
        el.style.display = 'flex';
        setTimeout(() => { el.style.display = 'none'; }, 3500);
    }

    window.hapusSemuaBoq = function() {
        if (!confirm('Hapus semua data BOQ?')) return;
        document.getElementById('boq-partial-tbody').innerHTML =
            '<tr id="boq-empty-row"><td colspan="10"><div class="empty-state" style="padding:1.5rem;"><i class="bi bi-table"></i><p>Belum ada data BOQ.</p></div></td></tr>';
        window.saveBoq();
    };

    window.saveBoq = function() {
        const rows = Array.from(document.querySelectorAll('#boq-partial-tbody tr:not(#boq-empty-row)'));
        const form = new FormData();
        form.append('_token', CSRF_BOQ);
        rows.forEach(row => row.querySelectorAll('input').forEach(inp => form.append(inp.name, inp.value)));

        showBoqMsg('Menyimpan...', true);
        fetch('/lokasi/' + LOKASI_BOQ + '/boq', { method: 'POST', body: form })
            .then(r => r.json())
            .then(d => {
                if (d.success) {
                    showBoqMsg('BOQ berhasil disimpan!', true);
                    setTimeout(() => window.reloadPage(), 1000);
                } else {
                    showBoqMsg('Gagal menyimpan: ' + (d.message ?? 'unknown error'), false);
                }
            })
            .catch(err => showBoqMsg('Gagal menyimpan BOQ: ' + err.message, false));
    };

    // Excel Import
    document.getElementById('boqImportBtn').addEventListener('click', () => {
        if (typeof XLSX === 'undefined') {
            alert('Library Excel (SheetJS) belum dimuat. Pastikan koneksi internet aktif dan refresh halaman.');
            return;
        }
        document.getElementById('boqExcelInput').click();
    });
    document.getElementById('boqExcelInput').addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            const wb = XLSX.read(new Uint8Array(e.target.result), { type: 'array' });
            const rows = XLSX.utils.sheet_to_json(wb.Sheets[wb.SheetNames[0]], { header: 1, defval: '' });

            let colNo=-1, colDes=-1, colUraian=-1, colSatuan=-1;
            let colDrm=-1, colAktual=-1, colTambah=-1, colKurang=-1, start=0;

            for (let i = 0; i < rows.length; i++) {
                const r = rows[i].map(c => String(c).trim().toUpperCase());
                if (colDes === -1 && r.includes('DESIGNATOR')) {
                    colNo = r.indexOf('NO'); colDes = r.indexOf('DESIGNATOR');
                    colUraian = r.findIndex(c => c.includes('URAIAN')); colSatuan = r.indexOf('SATUAN');
                }
                if (colDrm === -1 && r.includes('DRM') && r.includes('AKTUAL')) {
                    colDrm = r.indexOf('DRM'); colAktual = r.indexOf('AKTUAL');
                    colTambah = r.indexOf('TAMBAH'); colKurang = r.indexOf('KURANG');
                    start = i + 1; break;
                }
            }
            if (colDes === -1 || colDrm === -1) { alert('Format Excel tidak dikenali.'); return; }

            const toNum = v => { const n = parseFloat(String(v ?? '').trim()); return isNaN(n) ? '' : String(n); };
            const esc   = v => String(v ?? '').trim().replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
            const tbody = document.getElementById('boq-partial-tbody');
            tbody.innerHTML = '';
            let idx = 0;
            for (let i = start; i < rows.length; i++) {
                const row = rows[i];
                if (!String(row[colNo] ?? '').trim() || isNaN(Number(String(row[colNo]).trim()))) continue;
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${idx+1}</td>
                    <td><input type="text" class="form-control-soft input-mono" style="padding:0.35rem 0.5rem;font-size:0.8rem;" name="boq[${idx}][kode_item]" value="${esc(row[colDes])}"></td>
                    <td><input type="text" class="form-control-soft" style="padding:0.35rem 0.5rem;font-size:0.8rem;" name="boq[${idx}][nama_item]" value="${esc(row[colUraian])}"></td>
                    <td><input type="text" class="form-control-soft input-mono" style="padding:0.35rem 0.5rem;font-size:0.8rem;" name="boq[${idx}][satuan]" value="${esc(row[colSatuan])}"></td>
                    <td><input type="number" step="any" class="form-control-soft input-mono" style="padding:0.35rem 0.3rem;font-size:0.8rem;text-align:center;" name="boq[${idx}][volume_drm]" value="${toNum(row[colDrm])}"></td>
                    <td><input type="number" step="any" class="form-control-soft input-mono" style="padding:0.35rem 0.3rem;font-size:0.8rem;text-align:center;" name="boq[${idx}][volume_aktual]" value="${toNum(row[colAktual])}"></td>
                    <td><input type="number" step="any" class="form-control-soft input-mono" style="padding:0.35rem 0.3rem;font-size:0.8rem;text-align:center;" name="boq[${idx}][volume_tambah]" value="${colTambah>=0?toNum(row[colTambah]):''}"></td>
                    <td><input type="number" step="any" class="form-control-soft input-mono" style="padding:0.35rem 0.3rem;font-size:0.8rem;text-align:center;" name="boq[${idx}][volume_kurang]" value="${colKurang>=0?toNum(row[colKurang]):''}"></td>
                    <td><input type="text" class="form-control-soft" style="padding:0.35rem 0.5rem;font-size:0.8rem;" name="boq[${idx}][keterangan]"></td>
                    <td><button type="button" class="btn-danger-sm" onclick="this.closest('tr').remove();boqRenumber()">×</button></td>
                `;
                tbody.appendChild(tr); idx++;
            }
            if (idx > 0) saveBoq();
        };
        reader.readAsArrayBuffer(file);
        this.value = '';
    });
})();
</script>
@endpush
