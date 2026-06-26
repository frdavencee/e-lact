<h5>Upload Foto Lampiran</h5>
<form method="POST" action="{{ route('foto.store', $lokasi) }}" enctype="multipart/form-data" class="row g-2 mb-4">
    @csrf
    <div class="col-md-4">
        <select name="kategori" class="form-select-soft" required>
            <option value="">-- Pilih Kategori --</option>
            <optgroup label="Lampiran Evident Pekerjaan">
                <option value="evident_penarikan_kabel">Penarikan Kabel</option>
                <option value="evident_instalasi_aksesoris">Instalasi Aksesoris</option>
                <option value="evident_closure">Closure</option>
                <option value="evident_odp">ODP</option>
            </optgroup>
            <optgroup label="Lampiran Evidence ODP">
                <option value="odp_solid">ODP Solid</option>
                <option value="pemasangan_odp">Pemasangan ODP</option>
            </optgroup>
            <optgroup label="Lampiran Evidence Aksesoris">
                <option value="aksesoris_hl">Aksesoris HL</option>
                <option value="aksesoris_sc">Aksesoris SC</option>
            </optgroup>
            <option value="closure_splitter">Lampiran Evidence Closure & Spliter 1:4</option>
            <option value="marking_kabel">Lampiran Marking Kabel</option>
            <option value="laporan_boq">Laporan BOQ</option>
            <option value="opm_hasil_ukur">Lampiran Evident Hasil Ukur OPM</option>
            <option value="data_pengukuran_opm">Lampiran Data Pengukuran OPM</option>
            <option value="mancore">Lampiran Mancore</option>
            <option value="as_build_drawing">Lampiran Evident As Build Drawing (ABD)</option>
        </select>
    </div>
    <div class="col-md-3"><input type="text" name="label" class="form-control-soft" placeholder="Label (opsional)"></div>
    <div class="col-md-3"><input type="file" name="fotos[]" class="form-control-soft" multiple accept="image/*" required></div>
    <div class="col-md-2"><button type="submit" class="btn-primary-gradient w-100"><i class="bi bi-upload"></i> Upload</button></div>
</form>

@php
$grouped = $lokasi->fotoLampiran->groupBy('kategori');
$catLabel = [
    'evident_penarikan_kabel'     => 'Penarikan Kabel',
    'evident_instalasi_aksesoris' => 'Instalasi Aksesoris',
    'evident_closure'             => 'Closure',
    'evident_odp'                 => 'ODP',
    'odp_solid'                   => 'ODP Solid',
    'pemasangan_odp'              => 'Pemasangan ODP',
    'aksesoris_hl'                => 'Aksesoris HL',
    'aksesoris_sc'                => 'Aksesoris SC',
    'closure_splitter'            => 'Lampiran Evidence Closure & Spliter 1:4',
    'marking_kabel'               => 'Lampiran Marking Kabel',
    'laporan_boq'                 => 'Laporan BOQ',
    'opm_hasil_ukur'              => 'Lampiran Evident Hasil Ukur OPM',
    'data_pengukuran_opm'         => 'Lampiran Data Pengukuran OPM',
    'mancore'                     => 'Lampiran Mancore',
    'as_build_drawing'            => 'Lampiran Evident As Build Drawing (ABD)',
];
@endphp

@foreach($grouped as $kategori => $fotos)
<div class="detail-card mb-3">
    <div class="detail-card-header">
        <h5 class="mb-0">{{ $catLabel[$kategori] ?? str_replace('_', ' ', ucfirst($kategori)) }}</h5>
        <span class="badge-modern badge-info">{{ $fotos->count() }} foto</span>
    </div>
    <div class="detail-card-body">
        <div class="row g-2">
            @foreach($fotos as $foto)
            <div class="col-6 col-md-3">
                <div class="photo-tile-modern">
                    <img src="{{ asset('storage/' . $foto->file_path) }}" alt="{{ $foto->label }}">
                    <div class="photo-overlay-modern">
                        <small style="color:#fff;font-size:0.7rem;">{{ $foto->label ?: $catLabel[$foto->kategori] ?? $foto->kategori }}</small>
                    </div>
                    <button type="button" onclick="removeFoto({{ $foto->id }})" class="photo-remove-btn">×</button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
(function () {
    const CSRF_FOTO = '{{ csrf_token() }}';
    const LOKASI_FOTO = {{ $lokasi->id }};

    window.removeFoto = function (id) {
        if (!confirm('Hapus foto ini?')) return;
        fetch('/lokasi/' + LOKASI_FOTO + '/foto/' + id, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF_FOTO, 'X-Requested-With': 'XMLHttpRequest' },
        }).then(r => {
            if (r.ok) location.reload();
        });
    };
})();
</script>
@endpush
