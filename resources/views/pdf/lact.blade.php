<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>LACT</title>
<style>
body { font-family:'Times New Roman',serif; font-size:11pt; line-height:1.5; color:#000; }
.page { page-break-after:always; padding:40px 50px; }
.page:last-child { page-break-after:auto; }
table { width:100%; border-collapse:collapse; margin:10px 0; font-size:9pt; }
th,td { border:1px solid #000; padding:4px; vertical-align:top; text-align:left; }
th { background:#f0f0f0; font-weight:bold; text-align:center; }
.no-border td { border:none; padding:3px 0; }
.section-title { font-size:14pt; font-weight:bold; text-align:center; margin-bottom:12px; padding-bottom:5px; border-bottom:1px solid #000; }
.info-table { width:100%; border-collapse:collapse; margin-bottom:14px; font-size:9.5pt; }
.info-table td { border:none; padding:2px 4px; vertical-align:top; }
.info-table td:first-child { width:130px; font-weight:bold; }
.photo-grid { display:table; width:100%; }
.photo-cell { display:table-cell; width:33%; padding:8px; text-align:center; vertical-align:top; }
.photo-frame { border:1px solid #ccc; padding:3px; }
.photo-frame img { width:100%; max-height:180px; object-fit:contain; }
.photo-placeholder { border:1px dashed #999; height:150px; display:flex; align-items:center; justify-content:center; color:#999; font-size:9pt; }
.photo-caption { font-size:8.5pt; margin-top:4px; text-align:center; }
.photo-paraf { font-size:9pt; font-weight:bold; text-align:center; margin-top:6px; }
.text-center { text-align:center; }
</style>
</head>
<body>

@php
$projectMeta = [
    ['PROYEK',        $project->name ?? '-'],
    ['KONTRAK',       $project->contract_number ?? '-'],
    ['SURAT PESANAN', $project->purchase_order_number ?? '-'],
    ['BRANCH',        strtoupper($project->branch->name ?? '-')],
    ['LOKASI',        ($lokasi->name ?? '-') . ' [' . ($lokasi->code ?? '-') . ']'],
    ['PELAKSANA',     $project->implementer ?? '-'],
];

function renderInfoTable($meta) {
    echo '<table class="info-table">';
    foreach ($meta as $row) {
        echo '<tr><td>' . $row[0] . '</td><td>: ' . $row[1] . '</td></tr>';
    }
    echo '</table>';
}

function getImageSrc($filePath) {
    if (empty($filePath)) return '';
    $path = storage_path('app/public/' . $filePath);
    if (!file_exists($path)) return '';
    $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $mime = $ext === 'png' ? 'image/png' : ($ext === 'gif' ? 'image/gif' : 'image/jpeg');
    return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($path));
}

function renderPhotoGrid($photos, $limit = 6) {
    $items = is_array($photos) ? $photos : $photos->all();
    if (empty($items)) { echo '<p style="color:#999;font-size:9pt;">Belum ada foto.</p>'; return; }
    echo '<div class="photo-grid">';
    foreach (array_slice($items, 0, $limit) as $photo) {
        $src = getImageSrc($photo->file_path);
        echo '<div class="photo-cell">';
        if ($src) echo '<div class="photo-frame"><img src="' . $src . '"></div>';
        else       echo '<div class="photo-placeholder">[Foto]</div>';
        if (!empty($photo->label)) echo '<div class="photo-caption">' . e($photo->label) . '</div>';

        echo '</div>';
    }
    echo '</div>';
}

function renderLargePhotoGrid($photos) {
    $items = is_array($photos) ? $photos : $photos->all();
    if (empty($items)) { echo '<p style="color:#999;font-size:9pt;">Belum ada foto.</p>'; return; }
    foreach ($items as $photo) {
        $src = getImageSrc($photo->file_path);
        echo '<div style="text-align:center;margin-bottom:18px;">';
        if ($src) echo '<div class="photo-frame"><img src="' . $src . '" style="width:100%;max-height:280px;object-fit:contain;"></div>';
        else       echo '<div class="photo-placeholder" style="height:200px;">[Foto tidak ditemukan]</div>';
        if (!empty($photo->label)) echo '<div class="photo-caption">' . e($photo->label) . '</div>';

        echo '</div>';
    }
}

function renderParaf($waspang, $branch, $tanggal, $implementer, $ctImgSrc = null) {
    $name = $waspang ? e($waspang->nama ?? $waspang->name ?? '-') : '-';
    $nik  = $waspang ? e($waspang->nik ?? '-') : '-';
    echo '<table style="width:100%;border-collapse:collapse;margin-top:40px;">';
    echo '<tr>';
    echo '<td style="border:none;width:55%;">&nbsp;</td>';
    echo '<td style="border:none;width:45%;text-align:center;vertical-align:top;">';
    echo '<p style="font-weight:bold;margin:0;">' . e(strtoupper($branch)) . ', ' . e($tanggal) . '</p>';
    echo '<p style="margin:3px 0;">WASPANG</p>';
    echo '<p style="margin:3px 0;">' . e($implementer ?? 'PT TELKOM AKSES') . '</p>';
    if ($ctImgSrc) echo '<img src="' . $ctImgSrc . '" style="width:100px;height:50px;object-fit:contain;margin:6px auto;display:block;">';
    else           echo '<div style="height:55px;"></div>';
    echo '<p style="font-weight:bold;margin:0;text-decoration:underline;">' . $name . '</p>';
    echo '<p style="margin:0;">NIK : ' . $nik . '</p>';
    echo '</td>';
    echo '</tr></table>';
}

// CT image - base64
$ctImgSrc = null;
if (!empty($commissioningImages) && $commissioningImages->count() > 0) {
    $ci = $commissioningImages->first();
    $cp = storage_path('app/public/' . $ci->file_path);
    if (file_exists($cp)) {
        $ciExt  = strtolower(pathinfo($cp, PATHINFO_EXTENSION));
        $ciMime = $ciExt === 'png' ? 'image/png' : 'image/jpeg';
        $ctImgSrc = 'data:' . $ciMime . ';base64,' . base64_encode(file_get_contents($cp));
    }
}

// Foto sections (matching Next.js FOTO_SECTIONS)
$fotoSections = [
    ['label'=>'LAMPIRAN EVIDENT PEKERJAAN',
     'cats'=>['evident_penarikan_kabel','evident_instalasi_aksesoris','evident_closure','evident_odp'],'large'=>false],
    ['label'=>'LAMPIRAN MARKING KABEL',
     'cats'=>['marking_kabel'],'large'=>false],
    ['label'=>'LAMPIRAN EVIDENCE ODP',
     'cats'=>['odp_solid','pemasangan_odp'],'large'=>false],
    ['label'=>'LAMPIRAN EVIDENCE AKSESORIS',
     'cats'=>['aksesoris_hl','aksesoris_sc'],'large'=>false],
    ['label'=>'LAMPIRAN EVIDENCE CLOSURE & SPLITER 1:4',
     'cats'=>['closure_splitter'],'large'=>false],
    ['label'=>'LAMPIRAN EVIDENT HASIL UKUR OPM',
     'cats'=>['opm_hasil_ukur'],'large'=>false],
    ['label'=>'LAMPIRAN DATA PENGUKURAN OPM PROJECT OUTSIDE PLANT FIBER OPTIC',
     'cats'=>['data_pengukuran_opm'],'large'=>true],
    ['label'=>'LAMPIRAN MANCORE',
     'cats'=>['mancore'],'large'=>true],
    ['label'=>'LAMPIRAN EVIDENT AS BUILD DRAWING (ABD)',
     'cats'=>['as_build_drawing'],'large'=>true],
];

// TOC
$tocItems = [];
$no = 1;
if ($commissioning) $tocItems[] = $no++ . '.   Laporan Commisioning Test';
if ($boqItems->count() > 0) $tocItems[] = $no++ . '.   Lampiran Bill Of Quantity';
if ($opmRecords->count() > 0 || $otdrFiles->count() > 0)
    $tocItems[] = $no++ . '.   Hasil Ukur OPM & OTDR (End To End Sesuai SOW)';
if ($fotos->where('kategori','mancore')->count() > 0)
    $tocItems[] = $no++ . '.   Lampiran Mancore';
$tocItems[] = $no++ . '.   Berita Acara Lapangan & Dokumen Pendukung Lainnya';
@endphp

{{-- ===== COVER ===== --}}
<div class="page">
    <div style="text-align:center;padding-top:60px;">
        <h1 style="font-size:20pt;font-weight:bold;margin-bottom:30px;">LAPORAN&nbsp;&nbsp;COMMISSIONING TEST (LACT)</h1>
        <table style="border:none;margin-bottom:30px;font-size:11pt;">
            <tr><td style="border:none;width:160px;font-weight:bold;padding:4px 0;">PROYEK</td><td style="border:none;padding:4px 0;">: {{ $project->name ?? '-' }}</td></tr>
            <tr><td style="border:none;font-weight:bold;padding:4px 0;">KONTRAK</td><td style="border:none;padding:4px 0;">: {{ $project->contract_number ?? '-' }}</td></tr>
            <tr><td style="border:none;font-weight:bold;padding:4px 0;">SURAT PESANAN</td><td style="border:none;padding:4px 0;">: {{ $project->purchase_order_number ?? '-' }}</td></tr>
            <tr><td style="border:none;font-weight:bold;padding:4px 0;">BRANCH</td><td style="border:none;padding:4px 0;">: {{ strtoupper($project->branch->name ?? '-') }}</td></tr>
            <tr><td style="border:none;font-weight:bold;padding:4px 0;">LOKASI</td><td style="border:none;padding:4px 0;">: {{ $lokasi->name ?? '-' }} [{{ $lokasi->code ?? '-' }}]</td></tr>
            <tr><td style="border:none;font-weight:bold;padding:4px 0;">PELAKSANA</td><td style="border:none;padding:4px 0;">: {{ $project->implementer ?? '-' }}</td></tr>
        </table>
        @php $logoPath = public_path('images/logo.png'); @endphp
        @if(file_exists($logoPath))
        @php
        $logoExt  = strtolower(pathinfo($logoPath, PATHINFO_EXTENSION));
        $logoMime = $logoExt === 'png' ? 'image/png' : 'image/jpeg';
        $logoSrc  = 'data:' . $logoMime . ';base64,' . base64_encode(file_get_contents($logoPath));
        @endphp
        <div style="margin:30px auto;">
            <img src="{{ $logoSrc }}" style="max-width:280px;max-height:140px;">
        </div>
        @else
        <div style="height:80px;"></div>
        @endif
        <div style="margin-top:50px;font-size:12pt;line-height:2.2;">
            <p style="font-weight:bold;margin:0;">ANTARA</p>
            <p style="font-weight:bold;margin:0;">{{ $project->pihak_pertama ?? 'PT. TELKOM INFRASTRUKTUR INDONESIA, Tbk.' }}</p>
            <p style="font-weight:bold;margin:0;">DENGAN</p>
            <p style="font-weight:bold;margin:0;">{{ strtoupper($project->implementer ?? 'PT. TELKOM AKSES') }}</p>
        </div>
    </div>
</div>

{{-- ===== DAFTAR ISI ===== --}}
<div class="page">
    <div style="text-align:center;padding-top:60px;margin-bottom:40px;">
        <h2 style="font-size:16pt;font-weight:bold;margin-bottom:6px;">DAFTAR ISI</h2>
        <h3 style="font-size:13pt;font-weight:bold;margin-bottom:4px;">DOKUMEN LAPORAN COMMISIONING TEST</h3>
        <h3 style="font-size:13pt;font-weight:bold;margin:0;">(LACT)</h3>
    </div>
    <div style="font-size:12pt;line-height:2.4;margin-top:20px;">
        @foreach($tocItems as $item)
        <p style="margin:0;">{{ $item }}</p>
        @endforeach
    </div>
</div>

{{-- ===== COMMISSIONING TEST ===== --}}
@if($commissioning)
<div class="page">
    <div class="section-title">LAPORAN COMMISIONING TEST</div>
    @php renderInfoTable($projectMeta); @endphp

    <p style="margin-bottom:8px;">Pada hari ini {{ $tanggal_ttd }} yang bertanda tangan di bawah ini :</p>

    <table class="no-border" style="margin:8px 0 12px;">
        <tr><td style="width:80px;">Nama</td><td>: {{ $waspang->nama ?? ($waspang->name ?? '-') }}</td></tr>
        <tr><td>NIK</td><td>: {{ $waspang->nik ?? '-' }}</td></tr>
        <tr><td>Jabatan</td><td>: WASPANG PT. TELKOM AKSES</td></tr>
    </table>

    <p style="margin-bottom:8px;">Sehubungan dengan {{ $lokasi->name }} [{{ $lokasi->code }}] menerangkan bahwa telah melaksanakan pemeriksaan kesisteman (Commisioning Test) dan fisik pada lokasi {{ $lokasi->name }} [{{ $lokasi->code }}] sebagai berikut :</p>

    <p style="margin-bottom:6px;">1.&nbsp;&nbsp;&nbsp;Pelaksanaan pekerjaan <strong>{{ $commissioning->status_pekerjaan === 'telah' ? 'telah' : 'belum' }}</strong> diselesaikan dengan spesifikasi teknis TELKOM</p>
    <p style="margin-bottom:12px;">2.&nbsp;&nbsp;&nbsp;Hasil pekerjaan <strong>{{ $commissioning->status_hasil === 'dapat' ? 'dapat' : 'tidak dapat' }}</strong> diterima dan <strong>{{ $commissioning->status_kelayakan === 'layak' ? 'layak' : 'tidak layak' }}</strong> untuk diajukan Uji Terima (UT)</p>

    <p style="margin-bottom:0;">Demikian Laporan Commisioning Test dan Hasil Ukur ini dibuat dengan sebenarnya dan dapat dipertanggung jawabkan.</p>

    @php renderParaf($waspang, $kota_ttd, $tanggal_ttd, $project->implementer ?? 'PT TELKOM AKSES', $ctImgSrc); @endphp
</div>
@endif

{{-- ===== BOQ ===== --}}
@if($boqItems->count() > 0)
<div class="page">
    <div class="section-title">LAPORAN BILL OF QUANTITY</div>
    @php renderInfoTable($projectMeta); @endphp
    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="70">Kode Item</th>
                <th>Nama Item</th>
                <th width="40">Satuan</th>
                <th width="40">DRM</th>
                <th width="40">Aktual</th>
                <th width="40">Tambah</th>
                <th width="40">Kurang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($boqItems as $i => $item)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $item->kode_item ?? '' }}</td>
                <td>{{ $item->nama_item }}</td>
                <td class="text-center">{{ $item->satuan ?? '' }}</td>
                <td class="text-center">{{ $item->volume_drm ?? '-' }}</td>
                <td class="text-center">{{ $item->volume_aktual ?? '-' }}</td>
                <td class="text-center">{{ $item->volume_tambah ?? '-' }}</td>
                <td class="text-center">{{ $item->volume_kurang ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @php renderParaf($waspang, $kota_ttd, $tanggal_ttd, $project->implementer ?? 'PT TELKOM AKSES', $ctImgSrc); @endphp
</div>

{{-- BOQ Photos --}}
@php
$boqPhotos  = $fotos->where('kategori','laporan_boq')->values();
$boqChunks  = $boqPhotos->chunk(2);
@endphp
@foreach($boqChunks as $ci => $chunk)
<div class="page">
    <div class="section-title">{{ $ci === 0 ? 'FOTO LAPORAN BOQ' : 'FOTO LAPORAN BOQ (lanjutan)' }}</div>
    @php renderInfoTable($projectMeta); @endphp
    @php renderLargePhotoGrid($chunk->all()); @endphp
    @php renderParaf($waspang, $kota_ttd, $tanggal_ttd, $project->implementer ?? 'PT TELKOM AKSES', $ctImgSrc); @endphp
</div>
@endforeach
@endif

{{-- ===== FOTO SECTIONS ===== --}}
@foreach($fotoSections as $fs)
@php
$secFotos  = $fotos->filter(fn($f) => in_array($f->kategori, $fs['cats']))->values();
$chunkSize = $fs['large'] ? 2 : 6;
$secChunks = $secFotos->chunk($chunkSize);
@endphp
@if($secFotos->count() > 0)
@foreach($secChunks as $ci => $chunk)
<div class="page">
    <div class="section-title">{{ strtoupper($fs['label']) }}</div>
    @php renderInfoTable($projectMeta); @endphp
    @if($fs['large'])
        @php renderLargePhotoGrid($chunk->all()); @endphp
    @else
        @php renderPhotoGrid($chunk->all(), $chunkSize); @endphp
    @endif
    @php renderParaf($waspang, $kota_ttd, $tanggal_ttd, $project->implementer ?? 'PT TELKOM AKSES', $ctImgSrc); @endphp
</div>
@endforeach
@endif
@endforeach

{{-- ===== OPM (per-ODP mini-tables) ===== --}}
@if($opmRecords->count() > 0)
<div class="page">
    <div class="section-title">LAMPIRAN EVIDENT HASIL UKUR OPM</div>
    @php renderInfoTable($projectMeta); @endphp
    @foreach($opmRecords as $opm)
    <table style="margin-bottom:14px;">
        <tr>
            <th width="90">Nama ODP</th>
            <th>P1</th><th>P2</th><th>P3</th><th>P4</th>
            <th>P5</th><th>P6</th><th>P7</th><th>P8</th>
        </tr>
        <tr>
            <td style="font-weight:bold;">{{ $opm->odp_name }}</td>
            <td class="text-center">{{ $opm->port_1 ?? '-' }}</td>
            <td class="text-center">{{ $opm->port_2 ?? '-' }}</td>
            <td class="text-center">{{ $opm->port_3 ?? '-' }}</td>
            <td class="text-center">{{ $opm->port_4 ?? '-' }}</td>
            <td class="text-center">{{ $opm->port_5 ?? '-' }}</td>
            <td class="text-center">{{ $opm->port_6 ?? '-' }}</td>
            <td class="text-center">{{ $opm->port_7 ?? '-' }}</td>
            <td class="text-center">{{ $opm->port_8 ?? '-' }}</td>
        </tr>
    </table>
    @endforeach
    @php renderParaf($waspang, $kota_ttd, $tanggal_ttd, $project->implementer ?? 'PT TELKOM AKSES', $ctImgSrc); @endphp
</div>
@endif

{{-- ===== OTDR (2 per page) ===== --}}
@if($otdrFiles->count() > 0)
@php $otdrChunks = $otdrFiles->chunk(1); @endphp
@foreach($otdrChunks as $chunk)
<div class="page">
    <div class="section-title">LAMPIRAN HASIL UKUR OTDR</div>
    @php renderInfoTable($projectMeta); @endphp
    @foreach($chunk as $otdr)
    @php
        $os = getImageSrc($otdr->file_path);
    @endphp
    <div style="text-align:center;margin-bottom:18px;">
        @if($os)
        <div class="photo-frame"><img src="{{ $os }}" style="width:100%;max-height:280px;object-fit:contain;"></div>
        @else
        <div style="border:1px dashed #bbb;height:180px;padding-top:72px;text-align:center;color:#666;font-size:9pt;">
            {{ $otdr->original_name ?? basename($otdr->file_path) }}
        </div>
        @endif
        <div class="photo-caption"><strong>{{ $otdr->odp_name ?? '' }}</strong></div>

    </div>
    @endforeach
    @php renderParaf($waspang, $kota_ttd, $tanggal_ttd, $project->implementer ?? 'PT TELKOM AKSES', $ctImgSrc); @endphp
</div>
@endforeach
@endif

</body>
</html>
