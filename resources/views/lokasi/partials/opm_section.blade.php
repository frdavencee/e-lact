<div id="opm-show-msg" style="display:none;" class="alert-custom mb-3"></div>

<div class="d-flex gap-2 mb-3">
    <button type="button" onclick="addOpmShowRow()" class="btn-soft-secondary btn-sm">
        <i class="bi bi-plus"></i> Tambah ODP
    </button>
    <button type="button" onclick="saveOpmShow()" class="btn-primary-gradient btn-sm">
        <i class="bi bi-save"></i> Simpan Data OPM
    </button>
</div>

<div class="table-responsive">
    <table class="table-modern" id="opm-show-table" style="min-width:860px;">
        <thead>
            <tr>
                <th>Nama ODP</th>
                @for($p = 1; $p <= 8; $p++)
                <th style="text-align:center;width:58px;">P{{ $p }}</th>
                @endfor
                <th>Catatan</th>
                <th width="36"></th>
            </tr>
        </thead>
        <tbody id="opm-show-tbody">
            @forelse($lokasi->opmRecords as $opm)
            <tr>
                <td><input type="text" class="form-control-soft input-mono" style="padding:0.35rem 0.5rem;font-size:0.8rem;min-width:120px;" value="{{ $opm->odp_name }}"></td>
                @for($p = 1; $p <= 8; $p++)
                <td><input type="text" class="form-control-soft input-mono" style="padding:0.35rem 0.25rem;font-size:0.8rem;width:56px;text-align:center;" value="{{ $opm->{'port_'.$p} ?? '' }}"></td>
                @endfor
                <td><input type="text" class="form-control-soft" style="padding:0.35rem 0.5rem;font-size:0.8rem;min-width:90px;" value="{{ $opm->notes ?? '' }}"></td>
                <td><button type="button" class="btn-danger-sm" onclick="this.closest('tr').remove()">×</button></td>
            </tr>
            @empty
            <tr id="opm-show-empty">
                <td colspan="11"><div class="empty-state" style="padding:1.5rem;"><i class="bi bi-bar-chart"></i><p>Belum ada data OPM.</p></div></td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@push('scripts')
<script>
(function () {
    const CSRF_OPM_SHOW = '{{ csrf_token() }}';
    const LOKASI_OPM_SHOW = {{ $lokasi->id }};

    window.addOpmShowRow = function () {
        const emptyRow = document.getElementById('opm-show-empty');
        if (emptyRow) emptyRow.remove();
        const tbody = document.getElementById('opm-show-tbody');
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><input type="text" class="form-control-soft input-mono" style="padding:0.35rem 0.5rem;font-size:0.8rem;min-width:120px;" placeholder="ODP-XXX-FW/001"></td>
            ${[1,2,3,4,5,6,7,8].map(() =>
                `<td><input type="text" class="form-control-soft input-mono" style="padding:0.35rem 0.25rem;font-size:0.8rem;width:56px;text-align:center;" placeholder="-"></td>`
            ).join('')}
            <td><input type="text" class="form-control-soft" style="padding:0.35rem 0.5rem;font-size:0.8rem;min-width:90px;"></td>
            <td><button type="button" class="btn-danger-sm" onclick="this.closest('tr').remove()">×</button></td>
        `;
        tbody.appendChild(tr);
        tr.querySelector('input').focus();
    };

    function showOpmShowMsg(text, ok) {
        const el = document.getElementById('opm-show-msg');
        el.className = 'alert-custom mb-3 ' + (ok ? 'alert-success-custom' : 'alert-error-custom');
        el.textContent = text;
        el.style.display = 'flex';
        setTimeout(() => { el.style.display = 'none'; }, 3500);
    }

    window.saveOpmShow = function () {
        const rows = Array.from(document.querySelectorAll('#opm-show-tbody tr:not(#opm-show-empty)'));
        const items = [];
        for (const row of rows) {
            const inputs = row.querySelectorAll('input');
            if (inputs.length < 10) continue;
            const odp = inputs[0].value.trim();
            if (!odp) continue;
            items.push({
                odp_name: odp,
                port_1: inputs[1].value, port_2: inputs[2].value,
                port_3: inputs[3].value, port_4: inputs[4].value,
                port_5: inputs[5].value, port_6: inputs[6].value,
                port_7: inputs[7].value, port_8: inputs[8].value,
                notes: inputs[9].value,
            });
        }
        showOpmShowMsg('Menyimpan...', true);
        fetch('/lokasi/' + LOKASI_OPM_SHOW + '/opm', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_OPM_SHOW },
            body: JSON.stringify({ items }),
        })
        .then(r => r.json())
        .then(d => showOpmShowMsg(d.success ? 'Data OPM berhasil disimpan.' : 'Gagal menyimpan.', !!d.success))
        .catch(() => showOpmShowMsg('Gagal menyimpan data OPM.', false));
    };
})();
</script>
@endpush
