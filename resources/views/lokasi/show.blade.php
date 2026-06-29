@extends('layouts.app')

@section('title', $lokasi->code . ' - ' . $lokasi->name)

@push('styles')
<style>
.acc-btn { cursor:pointer; transition:background .15s; }
.acc-btn:hover { background:#f9fafb !important; }
.acc-btn.collapsed .acc-icon { transform:rotate(0deg); }
.acc-btn:not(.collapsed) .acc-icon { transform:rotate(180deg); }
.acc-icon { transition:transform .2s; color:#9ca3af; font-size:.8rem; }
.acc-wrap { background:white;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,.08);overflow:hidden;margin-bottom:8px; }
.acc-body { padding:1.25rem 1.5rem 1.5rem;border-top:1px solid #f3f4f6; }
</style>
@endpush

@section('content')

{{-- Header --}}
<div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
    <div>
        <h2 style="font-weight:700;color:#1f2937;font-size:1.25rem;margin:0;">{{ $lokasi->name }}</h2>
        <p style="font-family:monospace;font-size:.85rem;color:#6b7280;margin-top:.25rem;">
            {{ $lokasi->code }}
            &nbsp;
            @php $bc = match($lokasi->status) {'belum'=>'badge-secondary','draft'=>'badge-warning','siap'=>'badge-info','generated'=>'badge-success',default=>'badge-secondary'}; @endphp
            <span class="badge-modern {{ $bc }}" style="font-size:.7rem;">{{ ucfirst($lokasi->status) }}</span>
        </p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('lokasi.index') }}" class="btn-soft-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
        <a href="{{ route('lokasi.generate', $lokasi) }}" class="btn-primary-gradient"
            onclick="return confirm('Generate DOCX?')"><i class="bi bi-file-earmark-word"></i> Generate DOCX</a>
        <a href="{{ route('lokasi.generate.pdf', $lokasi) }}" class="btn-soft-secondary"
            onclick="return confirm('Generate PDF?')" style="background:#1f2937;color:white;border-color:#1f2937;">
            <i class="bi bi-file-earmark-pdf"></i> Generate PDF</a>
    </div>
</div>

{{-- Accordion --}}
@php
$project = $lokasi->project;
$fotoSections = [
    ['id'=>'evident-pekerjaan','title'=>'Lampiran Evident Pekerjaan','categories'=>[
        ['value'=>'evident_penarikan_kabel','label'=>'Penarikan Kabel'],
        ['value'=>'evident_instalasi_aksesoris','label'=>'Instalasi Aksesoris'],
        ['value'=>'evident_closure','label'=>'Closure'],
        ['value'=>'evident_odp','label'=>'ODP'],
    ]],
    ['id'=>'evidence-odp','title'=>'Lampiran Evidence ODP','categories'=>[
        ['value'=>'odp_solid','label'=>'ODP Solid'],
        ['value'=>'pemasangan_odp','label'=>'Pemasangan ODP'],
    ]],
    ['id'=>'evidence-aksesoris','title'=>'Lampiran Evidence Aksesoris','categories'=>[
        ['value'=>'aksesoris_hl','label'=>'Aksesoris HL'],
        ['value'=>'aksesoris_sc','label'=>'Aksesoris SC'],
    ]],
    ['id'=>'closure-splitter','title'=>'Lampiran Evidence Closure & Spliter 1:4','categories'=>[
        ['value'=>'closure_splitter','label'=>'Closure & Splitter'],
    ]],
    ['id'=>'opm-foto','title'=>'Lampiran Evident Hasil Ukur OPM','categories'=>[
        ['value'=>'opm_hasil_ukur','label'=>'Hasil Ukur OPM'],
    ]],
    ['id'=>'data-pengukuran-opm','title'=>'Lampiran Data Pengukuran OPM','categories'=>[
        ['value'=>'data_pengukuran_opm','label'=>'Data Pengukuran OPM'],
    ]],
    ['id'=>'mancore','title'=>'Lampiran Mancore','categories'=>[
        ['value'=>'mancore','label'=>'Mancore'],
    ]],
    ['id'=>'abd','title'=>'Lampiran Evident As Build Drawing (ABD)','categories'=>[
        ['value'=>'as_build_drawing','label'=>'As Build Drawing'],
    ]],
];
@endphp

<div id="lokasiAccordion">

    {{-- 1: INFO PROYEK (default open) --}}
    <div class="acc-wrap">
        <button type="button" class="acc-btn d-flex justify-content-between align-items-center w-100 px-4 py-3 border-0 bg-white text-start"
            data-bs-toggle="collapse" data-bs-target="#collapse-info">
            <span style="font-weight:600;color:#374151;font-size:.9rem;">Info Proyek</span>
            <i class="bi bi-chevron-down acc-icon"></i>
        </button>
        <div id="collapse-info" class="collapse show" data-bs-parent="#lokasiAccordion">
            <div class="acc-body">
                <form method="POST" action="{{ $project ? route('project.update', [$lokasi, $project]) : route('project.store', $lokasi) }}">
                    @csrf
                    @if($project) @method('PUT') @endif
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label-soft">Nama Proyek</label>
                            <input type="text" name="name" class="form-control-soft" value="{{ old('name', $project->name ?? '') }}" placeholder="Nama Proyek" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-soft">Kontrak</label>
                            <input type="text" name="contract_number" class="form-control-soft" value="{{ old('contract_number', $project->contract_number ?? '') }}" placeholder="Nomor Kontrak">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-soft">Surat Pesanan</label>
                            <input type="text" name="purchase_order_number" class="form-control-soft" value="{{ old('purchase_order_number', $project->purchase_order_number ?? '') }}" placeholder="Nomor SP">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-soft">Pelaksana</label>
                            <input type="text" name="implementer" class="form-control-soft" value="{{ old('implementer', $project->implementer ?? '') }}" placeholder="Nama Pelaksana">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-soft">Pihak Pertama (ANTARA)</label>
                            <input type="text" name="pihak_pertama" class="form-control-soft" value="{{ old('pihak_pertama', $project->pihak_pertama ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-soft">WASPANG</label>
                            <select name="waspang_id" class="form-select-soft">
                                <option value="">-- Pilih WASPANG --</option>
                                @foreach($personelList as $p)
                                <option value="{{ $p->id }}" {{ old('waspang_id', $project->waspang_id ?? '') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama }} ({{ $p->nik }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn-primary-gradient">Simpan Info Proyek</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- 2: COMMISSIONING TEST --}}
    <div class="acc-wrap">
        <button type="button" class="acc-btn collapsed d-flex justify-content-between align-items-center w-100 px-4 py-3 border-0 bg-white text-start"
            data-bs-toggle="collapse" data-bs-target="#collapse-ct">
            <span style="font-weight:600;color:#374151;font-size:.9rem;">Commissioning Test</span>
            <i class="bi bi-chevron-down acc-icon"></i>
        </button>
        <div id="collapse-ct" class="collapse" data-bs-parent="#lokasiAccordion">
            <div class="acc-body">
                @include('lokasi.partials.commissioning_test')
            </div>
        </div>
    </div>

    {{-- 3: BOQ + foto laporan_boq --}}
    <div class="acc-wrap">
        <button type="button" class="acc-btn collapsed d-flex justify-content-between align-items-center w-100 px-4 py-3 border-0 bg-white text-start"
            data-bs-toggle="collapse" data-bs-target="#collapse-boq">
            <span style="font-weight:600;color:#374151;font-size:.9rem;">Bill of Quantity (BOQ)</span>
            <i class="bi bi-chevron-down acc-icon"></i>
        </button>
        <div id="collapse-boq" class="collapse" data-bs-parent="#lokasiAccordion">
            <div class="acc-body">
                @include('lokasi.partials.boq')
                <div style="border-top:1px solid #f3f4f6;margin-top:1.25rem;padding-top:1.25rem;">
                    <p style="font-size:.8rem;font-weight:600;color:#6b7280;margin-bottom:.75rem;">FOTO LAPORAN BOQ</p>
                    @include('lokasi.partials.foto_section', ['sectionCategories' => [['value'=>'laporan_boq','label'=>'Laporan BOQ']]])
                </div>
            </div>
        </div>
    </div>

    {{-- 4: MARKING KABEL + foto marking_kabel --}}
    <div class="acc-wrap">
        <button type="button" class="acc-btn collapsed d-flex justify-content-between align-items-center w-100 px-4 py-3 border-0 bg-white text-start"
            data-bs-toggle="collapse" data-bs-target="#collapse-marking">
            <span style="font-weight:600;color:#374151;font-size:.9rem;">Marking Kabel</span>
            <i class="bi bi-chevron-down acc-icon"></i>
        </button>
        <div id="collapse-marking" class="collapse" data-bs-parent="#lokasiAccordion">
            <div class="acc-body">
                @include('lokasi.partials.marking_kabel')
                <div style="border-top:1px solid #f3f4f6;margin-top:1.25rem;padding-top:1.25rem;">
                    <p style="font-size:.8rem;font-weight:600;color:#6b7280;margin-bottom:.75rem;">FOTO MARKING KABEL</p>
                    @include('lokasi.partials.foto_section', ['sectionCategories' => [['value'=>'marking_kabel','label'=>'Marking Kabel']]])
                </div>
            </div>
        </div>
    </div>

    {{-- 5-12: FOTO SECTIONS (loop) --}}
    @foreach($fotoSections as $fs)
    <div class="acc-wrap">
        <button type="button" class="acc-btn collapsed d-flex justify-content-between align-items-center w-100 px-4 py-3 border-0 bg-white text-start"
            data-bs-toggle="collapse" data-bs-target="#collapse-{{ $fs['id'] }}">
            <span style="font-weight:600;color:#374151;font-size:.9rem;">{{ $fs['title'] }}</span>
            <i class="bi bi-chevron-down acc-icon"></i>
        </button>
        <div id="collapse-{{ $fs['id'] }}" class="collapse" data-bs-parent="#lokasiAccordion">
            <div class="acc-body">
                @include('lokasi.partials.foto_section', ['sectionCategories' => $fs['categories']])
            </div>
        </div>
    </div>
    @endforeach

    {{-- 13: DATA OPM --}}
    <div class="acc-wrap">
        <button type="button" class="acc-btn collapsed d-flex justify-content-between align-items-center w-100 px-4 py-3 border-0 bg-white text-start"
            data-bs-toggle="collapse" data-bs-target="#collapse-opm">
            <span style="font-weight:600;color:#374151;font-size:.9rem;">Data OPM</span>
            <i class="bi bi-chevron-down acc-icon"></i>
        </button>
        <div id="collapse-opm" class="collapse" data-bs-parent="#lokasiAccordion">
            <div class="acc-body">
                @include('lokasi.partials.opm_section')
            </div>
        </div>
    </div>

    {{-- 14: FILE OTDR --}}
    <div class="acc-wrap">
        <button type="button" class="acc-btn collapsed d-flex justify-content-between align-items-center w-100 px-4 py-3 border-0 bg-white text-start"
            data-bs-toggle="collapse" data-bs-target="#collapse-otdr">
            <span style="font-weight:600;color:#374151;font-size:.9rem;">File OTDR</span>
            <i class="bi bi-chevron-down acc-icon"></i>
        </button>
        <div id="collapse-otdr" class="collapse" data-bs-parent="#lokasiAccordion">
            <div class="acc-body">
                @include('lokasi.partials.otdr_section')
            </div>
        </div>
    </div>

</div>{{-- end accordion --}}

@endsection

@push('scripts')
<script>
(function () {
    const CSRF_SHOW  = '{{ csrf_token() }}';
    const LOKASI_SHOW = {{ $lokasi->id }};
    const SECTION_KEY = 'lokasi_section_' + LOKASI_SHOW;

    // ── Simpan section aktif lalu reload ───────────────────────────────
    window.reloadPage = function () {
        const open = document.querySelector('#lokasiAccordion .collapse.show');
        if (open) sessionStorage.setItem(SECTION_KEY, open.id);
        location.reload();
    };

    // ── Simpan section saat form di-submit (foto, CT, project, OTDR) ──
    document.addEventListener('submit', function () {
        const open = document.querySelector('#lokasiAccordion .collapse.show');
        if (open) sessionStorage.setItem(SECTION_KEY, open.id);
    });

    // ── Simpan section saat accordion dibuka ───────────────────────────
    const acc = document.getElementById('lokasiAccordion');
    if (acc) {
        acc.addEventListener('show.bs.collapse', function (e) {
            sessionStorage.setItem(SECTION_KEY, e.target.id);
        });
    }

    // ── Restore section saat page load ─────────────────────────────────
    const saved = sessionStorage.getItem(SECTION_KEY);
    if (saved) {
        sessionStorage.removeItem(SECTION_KEY);
        setTimeout(function () {
            const el = document.getElementById(saved);
            if (!el) return;
            // Tutup section default (collapse-info) lalu buka yang tersimpan
            const currentOpen = document.querySelector('#lokasiAccordion .collapse.show');
            if (currentOpen && currentOpen.id !== saved) {
                bootstrap.Collapse.getOrCreateInstance(currentOpen).hide();
            }
            bootstrap.Collapse.getOrCreateInstance(el).show();
            // Scroll ke section tersebut
            setTimeout(function () {
                const wrap = el.closest('.acc-wrap');
                if (wrap) wrap.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 350);
        }, 100);
    }

    // ── Delete foto ────────────────────────────────────────────────────
    window.removeFoto = function (id) {
        if (!confirm('Hapus foto ini?')) return;
        fetch('/lokasi/' + LOKASI_SHOW + '/foto/' + id, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF_SHOW, 'X-Requested-With': 'XMLHttpRequest' },
        })
        .then(r => {
            if (r.ok) {
                window.reloadPage();
            } else {
                alert('Gagal menghapus foto. Status: ' + r.status);
            }
        })
        .catch(err => alert('Error: ' + err.message));
    };
})();
</script>
@endpush
