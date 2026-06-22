<h5>Upload Foto Lampiran</h5>
<form method="POST" action="{{ route('foto.store', $lokasi) }}" enctype="multipart/form-data" class="row g-2 mb-4">

    @csrf
    <div class="col-md-3">
        <select name="kategori" class="form-select-soft" required>
            <option value="">-- Kategori --</option>
            <option value="evident_penarikan_kabel">Laporan Commissioning Test</option>
            <option value="evident_instalasi_aksesoris">Laporan Bill of Quantity</option>
            <option value="evident_closure">Lampiran Evident Pekerjaan</option>
            <option value="marking_kabel">Lampiran Marking Kabel</option>
            <option value="odp_solid">Lampiran Evidence ODP</option>
            <option value="pemasangan_odp">Lampiran Evidence ODP (Pemasangan)</option>
            <option value="aksesoris_hl">Lampiran Evidence Aksesoris</option>
            <option value="aksesoris_sc">Lampiran Evidence Aksesoris (SC)</option>
            <option value="closure_splitter">Lampiran Evidence Closure dan Spliter 1:4</option>
            <option value="opm_otdr">Lampiran Evident Hasil Ukur OPM</option>
            <option value="mancore">Lampiran Mancore</option>
            <option value="as_build_drawing">Lampiran Evident As Build Drawing (ABD)</option>
        </select>
    </div>
    <div class="col-md-3"><input type="text" name="label" class="form-control-soft" placeholder="Label (opsional)"></div>
    <div class="col-md-4"><input type="file" name="fotos[]" class="form-control-soft" multiple accept="image/*" required></div>
    <div class="col-md-2"><button type="submit" class="btn-primary-gradient w-100"><i class="bi bi-upload"></i> Upload</button></div>
</form>

@php
$grouped = $lokasi->fotoLampiran->groupBy('kategori');
$catConfig = [
    'evident_penarikan_kabel' => 'info',
    'evident_instalasi_aksesoris' => 'success',
    'evident_closure' => 'warning',
    'evident_odp' => 'primary',
    'odp_solid' => 'secondary',
    'pemasangan_odp' => 'info',
    'aksesoris_hl' => 'secondary',
    'aksesoris_sc' => 'secondary',
    'closure_splitter' => 'secondary',
    'opm_otdr' => 'secondary',
    'marking_kabel' => 'secondary',
    'mancore' => 'secondary',
    'as_build_drawing' => 'secondary',
];
$catLabel = [
    'evident_penarikan_kabel'    => 'Laporan Commissioning Test',
    'evident_instalasi_aksesoris'=> 'Laporan Bill of Quantity',
    'evident_closure'            => 'Lampiran Evident Pekerjaan',
    'evident_odp'                => 'Lampiran Evident Pekerjaan',
    'odp_solid'                  => 'Lampiran Evidence ODP',
    'pemasangan_odp'             => 'Lampiran Evidence ODP (Pemasangan)',
    'aksesoris_hl'               => 'Lampiran Evidence Aksesoris',
    'aksesoris_sc'               => 'Lampiran Evidence Aksesoris (SC)',
    'closure_splitter'           => 'Lampiran Evidence Closure dan Spliter 1:4',
    'opm_otdr'                   => 'Lampiran Evident Hasil Ukur OPM',
    'marking_kabel'              => 'Lampiran Marking Kabel',
    'mancore'                    => 'Lampiran Mancore',
    'as_build_drawing'           => 'Lampiran Evident As Build Drawing (ABD)',
];
@endphp
@foreach($grouped as $kategori => $fotos)
<div class="detail-card mb-3">
    <div class="detail-card-header">
        <h5 class="mb-0">{{ $catLabel[$kategori] ?? str_replace('_', ' ', ucfirst($kategori)) }}</h5>
        <span class="badge-modern {{ $catConfig[$kategori] ?? 'badge-secondary' }}">{{ $fotos->count() }} foto</span>
    </div>
    <div class="detail-card-body">
        <div class="row">
            @foreach($fotos as $foto)
            <div class="col-md-3 mb-3">
                <div class="photo-tile-modern">
                    <img src="{{ asset('storage/' . $foto->file_path) }}" alt="{{ $foto->label }}">
                    <div class="photo-overlay-modern">
                        <input type="text" class="photo-label-input" value="{{ $foto->label ?: '(Tanpa Label)' }}" onchange="updateLabel({{ $foto->id }}, this.value)">
                    </div>
                    <button type="button" onclick="removeFoto({{ $foto->id }})" class="photo-remove-btn">×</button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endforeach

<script>
function updateLabel(id, label) {
    fetch(`/lokasi/{{ $lokasi->id }}/foto/${id}/label`, {
        method: 'PUT',
        headers: { 
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ label })
    }).then(r => r.json()).then(data => {
        if (data.success) console.log('Label updated');
    });
}

function removeFoto(id) {
    if (confirm('Hapus foto ini?')) {
        fetch(`/lokasi/{{ $lokasi->id }}/foto/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        }).then(() => location.reload());
    }
}
</script>