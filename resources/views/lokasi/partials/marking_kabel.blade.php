<div id="mk-msg" style="display:none;" class="alert-custom mb-3"></div>

<div class="d-flex gap-2 mb-3">
    <button type="button" onclick="addMkRow()" class="btn-soft-secondary btn-sm">
        <i class="bi bi-plus"></i> Tambah Baris
    </button>
    <button type="button" onclick="saveMk()" class="btn-primary-gradient btn-sm">
        <i class="bi bi-save"></i> Simpan Marking Kabel
    </button>
</div>

<div class="table-responsive">
    <table class="table-modern" id="mk-table">
        <thead>
            <tr>
                <th>Jenis Kabel</th>
                <th width="160">Panjang (Meter)</th>
                <th width="40"></th>
            </tr>
        </thead>
        <tbody id="mk-tbody">
            @forelse($lokasi->markingKabel as $mk)
            <tr>
                <td><input type="text" class="form-control-soft" style="padding:0.4rem 0.6rem;font-size:0.875rem;" value="{{ $mk->jenis_kabel }}"></td>
                <td><input type="number" step="0.01" class="form-control-soft input-mono" style="padding:0.4rem 0.6rem;font-size:0.875rem;" value="{{ $mk->panjang_meter }}"></td>
                <td><button type="button" class="btn-danger-sm" onclick="this.closest('tr').remove()">×</button></td>
            </tr>
            @empty
            <tr id="mk-empty">
                <td colspan="3"><div class="empty-state" style="padding:1.5rem;"><i class="bi bi-scissors"></i><p>Belum ada data marking kabel.</p></div></td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@push('scripts')
<script>
(function () {
    const CSRF_MK = '{{ csrf_token() }}';
    const LOKASI_MK = {{ $lokasi->id }};

    window.addMkRow = function () {
        const emptyRow = document.getElementById('mk-empty');
        if (emptyRow) emptyRow.remove();
        const tbody = document.getElementById('mk-tbody');
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><input type="text" class="form-control-soft" style="padding:0.4rem 0.6rem;font-size:0.875rem;" placeholder="Kabel Drop 2 Core"></td>
            <td><input type="number" step="0.01" class="form-control-soft input-mono" style="padding:0.4rem 0.6rem;font-size:0.875rem;" placeholder="0"></td>
            <td><button type="button" class="btn-danger-sm" onclick="this.closest('tr').remove()">×</button></td>
        `;
        tbody.appendChild(tr);
        tr.querySelector('input').focus();
    };

    function showMkMsg(text, ok) {
        const el = document.getElementById('mk-msg');
        el.className = 'alert-custom mb-3 ' + (ok ? 'alert-success-custom' : 'alert-error-custom');
        el.textContent = text;
        el.style.display = 'flex';
        setTimeout(() => { el.style.display = 'none'; }, 3500);
    }

    window.saveMk = function () {
        const rows = Array.from(document.querySelectorAll('#mk-tbody tr:not(#mk-empty)'));
        const items = rows.map(row => {
            const inputs = row.querySelectorAll('input');
            return { jenis_kabel: inputs[0]?.value ?? '', panjang_meter: inputs[1]?.value ?? '' };
        }).filter(r => r.jenis_kabel.trim());

        showMkMsg('Menyimpan...', true);
        fetch('/lokasi/' + LOKASI_MK + '/marking-kabel', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_MK },
            body: JSON.stringify({ items }),
        })
        .then(r => r.json())
        .then(d => showMkMsg(d.success ? 'Marking kabel berhasil disimpan.' : 'Gagal menyimpan.', !!d.success))
        .catch(() => showMkMsg('Gagal menyimpan marking kabel.', false));
    };
})();
</script>
@endpush
