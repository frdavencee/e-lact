@extends('layouts.app')

@section('title', 'OPM & OTDR - ' . $lokasi->code)

@section('content')
<div class="detail-header">
    <h2>OPM & OTDR - {{ $lokasi->code }} - {{ $lokasi->name }}</h2>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('lokasi.show', $lokasi) }}" class="btn-soft-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>
</div>

<ul class="nav-tabs-modern" id="opmTab" role="tablist">
    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-opm">OPM</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-otdr">OTDR</button></li>
</ul>

<div class="tab-content-modern">

    {{-- TAB OPM --}}
    <div class="tab-pane fade show active" id="tab-opm">
        <div id="opm-msg" style="display:none;" class="alert-custom mb-3"></div>

        <div class="detail-card mt-3">
            <div class="detail-card-header">
                <h5>Data Pengukuran OPM</h5>
                <div class="d-flex gap-2">
                    <button type="button" onclick="addOpmRow()" class="btn-soft-secondary btn-sm">
                        <i class="bi bi-plus"></i> Tambah ODP
                    </button>
                    <button type="button" onclick="saveOpmData()" class="btn-primary-gradient btn-sm">
                        <i class="bi bi-save"></i> Simpan Data OPM
                    </button>
                </div>
            </div>
            <div class="detail-card-body">
                <div class="table-responsive">
                    <table class="table-modern" id="opm-table" style="min-width:900px;">
                        <thead>
                            <tr>
                                <th>Nama ODP</th>
                                <th style="text-align:center;">P1</th>
                                <th style="text-align:center;">P2</th>
                                <th style="text-align:center;">P3</th>
                                <th style="text-align:center;">P4</th>
                                <th style="text-align:center;">P5</th>
                                <th style="text-align:center;">P6</th>
                                <th style="text-align:center;">P7</th>
                                <th style="text-align:center;">P8</th>
                                <th>Catatan</th>
                                <th width="40"></th>
                            </tr>
                        </thead>
                        <tbody id="opm-tbody">
                            @forelse($opmRecords as $opm)
                            <tr>
                                <td><input type="text" class="form-control-soft input-mono" style="padding:0.4rem 0.5rem;font-size:0.8rem;min-width:130px;" value="{{ $opm->odp_name }}"></td>
                                @for($p = 1; $p <= 8; $p++)
                                <td><input type="text" class="form-control-soft input-mono" style="padding:0.4rem 0.3rem;font-size:0.8rem;width:60px;text-align:center;" value="{{ $opm->{'port_'.$p} ?? '' }}"></td>
                                @endfor
                                <td><input type="text" class="form-control-soft" style="padding:0.4rem 0.5rem;font-size:0.8rem;min-width:100px;" value="{{ $opm->notes ?? '' }}"></td>
                                <td><button type="button" class="btn-danger-sm" onclick="this.closest('tr').remove()">×</button></td>
                            </tr>
                            @empty
                            <tr id="empty-row">
                                <td colspan="11"><div class="empty-state"><i class="bi bi-bar-chart"></i><p>Belum ada data OPM. Klik "Tambah ODP" untuk mulai.</p></div></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- TAB OTDR --}}
    <div class="tab-pane fade" id="tab-otdr">
        <div class="detail-card mt-3">
            <div class="detail-card-header">
                <h5>Upload File OTDR</h5>
            </div>
            <div class="detail-card-body">
                <form method="POST" action="{{ route('otdr.store', $lokasi) }}" enctype="multipart/form-data" class="row g-2">
                    @csrf
                    <div class="col-md-4">
                        <label class="form-label-soft">Nama ODP</label>
                        <input type="text" name="odp_name" class="form-control-soft input-mono" placeholder="ODP-PAT-FW/114" required>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label-soft">File OTDR (JPG/PNG/PDF)</label>
                        <input type="file" name="file" class="form-control-soft" accept="image/*,.pdf" required>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn-primary-gradient w-100"><i class="bi bi-upload"></i> Upload</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="detail-card mt-3">
            <div class="detail-card-header">
                <h5>File OTDR</h5>
                <span class="badge-modern badge-info">{{ $otdrFiles->count() }} file</span>
            </div>
            <div class="detail-card-body">
                <div class="table-responsive">
                    <table class="table-modern">
                        <thead>
                            <tr><th>ODP</th><th>Nama File</th><th>Tipe</th><th>Ukuran</th><th width="60"></th></tr>
                        </thead>
                        <tbody>
                            @forelse($otdrFiles as $otdr)
                            <tr>
                                <td><strong>{{ $otdr->odp_name ?? '-' }}</strong></td>
                                <td>{{ $otdr->original_name }}</td>
                                <td><span class="badge-modern-sm" style="background:#f3f4f6;color:#4b5563;">{{ strtoupper(pathinfo($otdr->original_name, PATHINFO_EXTENSION)) }}</span></td>
                                <td>{{ number_format($otdr->size / 1024, 1) }} KB</td>
                                <td>
                                    <form action="{{ route('otdr.destroy', [$lokasi, $otdr]) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                        @csrf @method('DELETE')
                                        <button class="action-icon-btn btn-delete"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5"><div class="empty-state"><i class="bi bi-file-earmark-bar-graph"></i><p>Belum ada file OTDR.</p></div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const CSRF_OPM = '{{ csrf_token() }}';
const LOKASI_ID_OPM = {{ $lokasi->id }};

function addOpmRow() {
    const emptyRow = document.getElementById('empty-row');
    if (emptyRow) emptyRow.remove();

    const tbody = document.getElementById('opm-tbody');
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td><input type="text" class="form-control-soft input-mono" style="padding:0.4rem 0.5rem;font-size:0.8rem;min-width:130px;" placeholder="ODP-XXX-FW/001"></td>
        ${[1,2,3,4,5,6,7,8].map(() =>
            `<td><input type="text" class="form-control-soft input-mono" style="padding:0.4rem 0.3rem;font-size:0.8rem;width:60px;text-align:center;" placeholder="-"></td>`
        ).join('')}
        <td><input type="text" class="form-control-soft" style="padding:0.4rem 0.5rem;font-size:0.8rem;min-width:100px;"></td>
        <td><button type="button" class="btn-danger-sm" onclick="this.closest('tr').remove()">×</button></td>
    `;
    tbody.appendChild(tr);
    tr.querySelector('input').focus();
}

function showOpmMsg(text, success) {
    const el = document.getElementById('opm-msg');
    el.className = 'alert-custom mb-3 ' + (success ? 'alert-success-custom' : 'alert-error-custom');
    el.textContent = text;
    el.style.display = 'flex';
    setTimeout(() => { el.style.display = 'none'; }, 3500);
}

function saveOpmData() {
    const rows = Array.from(document.querySelectorAll('#opm-tbody tr'));
    const items = [];

    for (const row of rows) {
        if (row.id === 'empty-row') continue;
        const inputs = row.querySelectorAll('input');
        if (inputs.length < 10) continue;
        const odp = inputs[0].value.trim();
        if (!odp) continue;
        items.push({
            odp_name: odp,
            port_1: inputs[1].value,
            port_2: inputs[2].value,
            port_3: inputs[3].value,
            port_4: inputs[4].value,
            port_5: inputs[5].value,
            port_6: inputs[6].value,
            port_7: inputs[7].value,
            port_8: inputs[8].value,
            notes:  inputs[9].value,
        });
    }

    showOpmMsg('Menyimpan...', true);

    fetch('/lokasi/' + LOKASI_ID_OPM + '/opm', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_OPM,
        },
        body: JSON.stringify({ items }),
    })
    .then(r => r.json())
    .then(d => showOpmMsg(d.success ? 'Data OPM berhasil disimpan.' : 'Gagal menyimpan.', !!d.success))
    .catch(() => showOpmMsg('Gagal menyimpan data OPM.', false));
}
</script>
@endpush
