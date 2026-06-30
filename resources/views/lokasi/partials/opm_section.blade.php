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

{{-- Upload Foto per ODP + Port --}}
@php
$opmFotos = $lokasi->fotoLampiran->filter(fn($f) => $f->kategori === 'opm_hasil_ukur');
$odpNames = $lokasi->opmRecords->pluck('odp_name')->unique()->filter()->values();
@endphp

<div style="border-top:1px solid #f3f4f6;margin-top:1.25rem;padding-top:1.25rem;">
    <form method="POST" action="{{ route('foto.store', $lokasi) }}" enctype="multipart/form-data"
        class="row g-2 mb-4 p-3" style="background:#f9fafb;border:1px dashed #d1d5db;border-radius:8px;">
        @csrf
        <input type="hidden" name="kategori" value="opm_hasil_ukur">
        <input type="hidden" name="label" id="opmFotoLabel">
        <div class="col-md-4">
            <label class="form-label-soft">Nama ODP</label>
            <select id="opmOdpSelect" class="form-select-soft" onchange="updateOpmLabel()">
                <option value="">-- Pilih ODP --</option>
                @foreach($odpNames as $odp)
                <option value="{{ $odp }}">{{ $odp }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label-soft">Port</label>
            <select id="opmPortSelect" class="form-select-soft" onchange="updateOpmLabel()">
                @for($p = 1; $p <= 8; $p++)
                <option value="P{{ $p }}">P{{ $p }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label-soft">Foto</label>
            <input type="file" name="fotos[]" class="form-control-soft" accept="image/*" required>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn-primary-gradient w-100"><i class="bi bi-upload"></i> Upload</button>
        </div>
    </form>

    @if($opmFotos->isNotEmpty())
    <div class="row g-2">
        @foreach($opmFotos as $foto)
        <div class="col-6 col-md-3">
            <div style="border:1px solid #e5e7eb;border-radius:8px;overflow:hidden;background:white;">
                <div style="position:relative;">
                    <img id="foto-img-{{ $foto->id }}" src="{{ asset('storage/' . $foto->file_path) }}"
                        style="width:100%;height:110px;object-fit:cover;display:block;">
                    <input type="file" id="foto-replace-{{ $foto->id }}" accept="image/*" style="display:none;"
                        onchange="replaceFoto({{ $foto->id }}, this)">
                    <button type="button" onclick="document.getElementById('foto-replace-{{ $foto->id }}').click()"
                        class="photo-remove-btn" style="right:28px;background:rgba(59,130,246,0.85);">
                        <i class="bi bi-camera" style="font-size:0.65rem;"></i>
                    </button>
                    <button type="button" onclick="removeFoto({{ $foto->id }})" class="photo-remove-btn">×</button>
                </div>
                <div style="padding:0.35rem 0.5rem;border-top:1px solid #f3f4f6;">
                    <input type="text" value="{{ $foto->label }}" placeholder="Label..."
                        onblur="updateFotoLabel({{ $foto->id }}, this.value)"
                        style="width:100%;border:none;background:transparent;font-size:0.75rem;color:#374151;outline:none;padding:0;">
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

@push('scripts')
<script>
function updateOpmLabel() {
    const odp  = document.getElementById('opmOdpSelect').value;
    const port = document.getElementById('opmPortSelect').value;
    document.getElementById('opmFotoLabel').value = odp ? odp + ' - ' + port : port;
}
updateOpmLabel();
</script>
