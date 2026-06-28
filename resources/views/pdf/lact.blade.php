<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Akhir Cabang Telekomunikasi (LACT)</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 11pt; line-height: 1.4; color: #000; }
        .page { page-break-after: always; padding: 40px; }
        .page:last-child { page-break-after: auto; }
        
        /* Cover Page */
        .cover { text-align: center; padding-top: 100px; }
        .cover h1 { font-size: 24pt; font-weight: bold; margin-bottom: 10px; }
        .cover h2 { font-size: 18pt; margin-bottom: 50px; }
        .cover .info { text-align: left; margin-top: 80px; font-size: 12pt; }
        .cover .info table { width: 100%; border-collapse: collapse; }
        .cover .info td { padding: 8px 0; vertical-align: top; }
        .cover .info td:first-child { width: 200px; font-weight: bold; }
        
        /* Commissioning Page */
        .signature-block { margin-top: 60px; }
        .signature-block table { width: 100%; }
        .signature-block td { width: 50%; vertical-align: top; padding: 20px; }
        .signature-line { border-bottom: 1px solid #000; height: 60px; margin-bottom: 10px; }
        
        /* Tables */
        table { width: 100%; border-collapse: collapse; margin: 15px 0; font-size: 10pt; }
        th, td { border: 1px solid #000; padding: 6px 8px; vertical-align: top; text-align: left; }
        th { background-color: #f0f0f0; font-weight: bold; text-align: center; }
        .no-border td { border: none; padding: 4px 0; }
        
        /* Evidence Grid */
        .photo-grid { display: table; width: 100%; }
        .photo-cell { display: table-cell; width: 33%; padding: 10px; text-align: center; vertical-align: top; }
        .photo-placeholder { border: 1px dashed #999; min-height: 150px; display: flex; align-items: center; justify-content: center; color: #999; }
        .photo-caption { font-size: 9pt; margin-top: 5px; text-align: center; }
        .photo-paraf { font-size: 9pt; margin-top: 8px; text-align: center; font-weight: bold; }
        .photo-frame { border: 1px solid #ccc; padding: 4px; }
        .photo-frame img { width: 100%; max-height: 180px; object-fit: contain; }
        .photo-info-table { width: 100%; border-collapse: collapse; margin-bottom: 16px; font-size: 9.5pt; }
        .photo-info-table td { padding: 3px 4px; vertical-align: top; }
        .photo-info-table td:first-child { width: 120px; font-weight: bold; }
        
        /* Header */
        .doc-header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .doc-header h3 { margin: 0; font-size: 14pt; }
        
        /* Section Title */
        .section-title { font-size: 13pt; font-weight: bold; margin: 20px 0 10px 0; border-bottom: 1px solid #333; padding-bottom: 5px; }
        
        /* OPM Table */
        .opm-table th { background-color: #e8f4f8; }
        
        /* Footer */
        .page-footer { position: fixed; bottom: 20px; left: 40px; right: 40px; font-size: 9pt; text-align: center; border-top: 1px solid #ccc; padding-top: 5px; }
    </style>
</head>
<body>

@php
    $projectMeta = [
        ['Proyek', $project->name ?? '-'],
        ['Kontrak', $project->contract_number ?? '-'],
        ['Surat Pesanan', $project->purchase_order_number ?? '-'],
        ['Branch', strtoupper($project->branch->name ?? '-')],
        ['Lokasi', ($lokasi->code ?? '-') . ' [' . ($lokasi->name ?? '-') . ']'],
        ['Pelaksana', $project->implementer ?? '-'],
    ];

    function renderPhotoMetaTable($meta) {
        echo '<table class="photo-info-table">';
        foreach ($meta as $row) {
            echo '<tr><td>' . $row[0] . '</td><td>: ' . $row[1] . '</td></tr>';
        }
        echo '</table>';
    }

    function renderPhotoGrid($photos, $limit = 6) {
        if (!$photos || $photos->count() === 0) {
            echo '<p class="text-muted">Belum ada foto</p>';
            return;
        }

        echo '<div class="photo-grid">';
        foreach ($photos->take($limit) as $photo) {
            $path = storage_path('app/public/' . $photo->file_path);
            $path = str_replace('\\', '/', $path);
            $src = file_exists($path) ? 'file:///' . $path : '';
            echo '<div class="photo-cell">';
            if ($src) {
                echo '<div class="photo-frame"><img src="' . $src . '" alt="' . e($photo->label ?: $photo->original_name ?? 'Foto') . '"></div>';
            } else {
                echo '<div class="photo-placeholder">[Foto: ' . e($photo->original_name ?? ($photo->label ?? 'Foto')) . ']</div>';
            }
            echo '<div class="photo-caption">' . e($photo->label ?: ($photo->original_name ?? 'Foto')) . '</div>';
            echo '<div class="photo-paraf">PARAF</div>';
            echo '</div>';
        }
        echo '</div>';
    }
@endphp

<!-- PAGE 1: COVER -->
<div class="page">
    <div style="text-align: center; padding-top: 60px;">
        <h1 style="font-size: 20pt; font-weight: bold; margin-bottom: 40px;">LAPORAN COMMISSIONING TEST (LACT)</h1>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 40px; font-size: 11pt; text-align: left;">
            <tr><td style="width: 160px; font-weight: bold; padding: 5px 0;">PROYEK</td><td style="padding: 5px 0;">: {{ $project->name ?? '-' }}</td></tr>
            <tr><td style="font-weight: bold; padding: 5px 0;">KONTRAK</td><td style="padding: 5px 0;">: {{ $project->contract_number ?? '-' }}</td></tr>
            <tr><td style="font-weight: bold; padding: 5px 0;">SURAT PESANAN</td><td style="padding: 5px 0;">: {{ $project->purchase_order_number ?? '-' }}</td></tr>
            <tr><td style="font-weight: bold; padding: 5px 0;">BRANCH</td><td style="padding: 5px 0;">: {{ strtoupper($project->branch->name ?? '-') }}</td></tr>
            <tr><td style="font-weight: bold; padding: 5px 0;">LOKASI</td><td style="padding: 5px 0;">: {{ $lokasi->name ?? '-' }} [{{ $lokasi->code ?? '-' }}]</td></tr>
            <tr><td style="font-weight: bold; padding: 5px 0;">PELAKSANA</td><td style="padding: 5px 0;">: {{ $project->implementer ?? '-' }}</td></tr>
        </table>

        @php
            $logoPath = public_path('images/logo.png');
        @endphp
        @if(file_exists($logoPath))
        <div style="margin: 40px auto;">
            <img src="file:///{{ str_replace('\\', '/', $logoPath) }}" style="max-width: 220px; max-height: 130px;">
        </div>
        @else
        <div style="height: 100px;"></div>
        @endif

        <div style="margin-top: 40px; font-size: 12pt; line-height: 2;">
            <p style="font-weight: bold;">ANTARA</p>
            <p style="font-weight: bold;">{{ $project->pihak_pertama ?? 'PT. TELKOM INFRASTRUKTUR INDONESIA, Tbk.' }}</p>
            <p style="font-weight: bold;">DENGAN</p>
            <p style="font-weight: bold;">{{ strtoupper($project->implementer ?? 'PT. TELKOM AKSES') }}</p>
        </div>
    </div>
</div>

<!-- PAGE 2: DAFTAR ISI -->
<div class="page">
    <div style="text-align: center; padding-top: 80px;">
        <h2 style="font-size: 16pt; font-weight: bold; margin-bottom: 6px;">DAFTAR ISI</h2>
        <h3 style="font-size: 13pt; font-weight: bold; margin-bottom: 4px;">DOKUMEN LAPORAN COMMISIONING TEST</h3>
        <h3 style="font-size: 13pt; font-weight: bold; margin-bottom: 0;">(LACT)</h3>
    </div>
    @php
        $tocItems = [];
        $no = 1;
        if (!empty($commissioning))
            $tocItems[] = $no++ . '.   Laporan Commisioning Test';
        if (!empty($boqItems) && $boqItems->count() > 0)
            $tocItems[] = $no++ . '.   Lampiran Bill Of Quantity';
        if ((!empty($opmRecords) && $opmRecords->count() > 0) || (!empty($otdrFiles) && $otdrFiles->count() > 0))
            $tocItems[] = $no++ . '.   Hasil Ukur OPM & OTDR (End To End Sesuai SOW)';
        if (!empty($mancoreItems) && $mancoreItems->count() > 0)
            $tocItems[] = $no++ . '.   Lampiran Mancore';
        $tocItems[] = $no++ . '.   Berita Acara Lapangan & Dokumen Pendukung Lainnya';
    @endphp
    <div style="margin-top: 60px; font-size: 12pt; line-height: 2.2;">
        @foreach($tocItems as $item)
        <p>{{ $item }}</p>
        @endforeach
    </div>
</div>

<!-- PAGE 3: COMMISSIONING TEST -->
<div class="page">
    <div class="doc-header">
        <h3>BAB 1: COMMISSIONING TEST</h3>
    </div>
    @php renderPhotoMetaTable($projectMeta); @endphp
    
    <div class="section-title">1.1 Identitas Pemeriksa (Waspang)</div>
    <table>
        <tr><td width="150">Nama</td><td>: {{ $waspang->name ?? 'Syaifin Nizar Zulmi' }}</td></tr>
        <tr><td>NIK</td><td>: {{ $waspang->nik ?? '885776' }}</td></tr>
        <tr><td>Jabatan</td><td>: Waspang</td></tr>
        <tr><td>Perusahaan</td><td>: PT TELKOM AKSES</td></tr>
    </table>
    
    <div class="section-title">1.2 Hasil Pemeriksaan</div>
    <table>
        <tr>
            <th width="200">Parameter</th>
            <th>Nilai</th>
        </tr>
        <tr>
            <td>Status Pekerjaan</td>
            <td>
                @if($commissioning->status_pekerjaan === 'telah')
                    <strong>TELAH SELESAI</strong>
                    <strike>Belum Selesai</strike>
                @else
                    <strike>Telah Selesai</strike>
                    <strong>BELUM SELESAI</strong>
                @endif
            </td>
        </tr>
        <tr>
            <td>Hasil Pekerjaan</td>
            <td>
                @if($commissioning->status_hasil === 'dapat')
                    <strong>DITERIMA & LAYAK UT</strong>
                    <strike>Tidak Diterima</strike>
                @else
                    <strike>Diterima & Layak UT</strike>
                    <strong>TIDAK DITERIMA</strong>
                @endif
            </td>
        </tr>
        <tr>
            <td>Tanggal Pemeriksaan</td>
            <td>: {{ $commissioning->tanggal?->format('d F Y') ?? '5 Mei 2026' }}</td>
        </tr>
        <tr>
            <td>Kota Tanda Tangan</td>
            <td>: {{ $kota_ttd }}</td>
        </tr>
    </table>
    
    <div class="section-title">1.3 Pernyataan Waspang</div>
    <p style="text-align: justify; margin: 20px 0;">
        Saya yang bertanda tangan di bawah ini, menyatakan bahwa pekerjaan pada proyek 
        <strong>{{ $project->name }}</strong> telah diperiksa dan diverifikasi. 
        Berdasarkan hasil pemeriksaan, pekerjaan tersebut 
        @if($commissioning->status_pekerjaan === 'telah')
            <strong>TELAH SELESAI</strong> 
        @else
            <strong>BELUM SELESAI</strong>
        @endif
        dan 
        @if($commissioning->status_hasil === 'dapat')
            <strong>DITERIMA & LAYAK UNTUK (UT)</strong>.
        @else
            <strong>TIDAK DITERIMA</strong>.
        @endif
    </p>
    
    <div class="signature-block">
        <table>
            <tr>
                <td>
                    <div class="signature-line"></div>
                    <p class="text-center mb-0"><strong>{{ $waspang->name ?? 'Syaifin Nizar Zulmi' }}</strong></p>
                    <p class="text-center mb-0">NIK: {{ $waspang->nik ?? '885776' }}</p>
                    <p class="text-center mb-0">Waspang</p>
                    <p class="text-center mb-0">PT TELKOM AKSES</p>
                </td>
                <td>
                    <div class="signature-line"></div>
                    <p class="text-center mb-0"><strong>Staff Waspang</strong></p>
                    <p class="text-center mb-0">PT TELKOM AKSES</p>
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="page">
    <div class="doc-header">
        <h3>BAB 1.4: LAMPIRAN FOTO COMMISSIONING TEST</h3>
    </div>
    @php renderPhotoMetaTable($projectMeta); @endphp
    <div class="section-title">1.4.1 Dokumentasi Commissioning Test</div>
    @php renderPhotoGrid($commissioningImages, 6); @endphp
</div>

<!-- PAGE 4-6: BOQ -->
<div class="page">
    <div class="doc-header">
        <h3>BAB 2: BILL OF QUANTITY (BOQ)</h3>
    </div>
    @php renderPhotoMetaTable($projectMeta); @endphp

    <table>
        <thead>
            <tr>
                <th class="text-center" width="35">No</th>
                <th width="85">Kode Item</th>
                <th>Nama Item</th>
                <th class="text-center" width="55">Satuan</th>
                <th class="text-center" width="60">DRM</th>
                <th class="text-center" width="60">Aktual</th>
                <th class="text-center" width="60">Tambah</th>
                <th class="text-center" width="60">Kurang</th>
            </tr>
        </thead>
        <tbody>
            @forelse($boqItems as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->kode_item ?? '' }}</td>
                <td>{{ $item->nama_item }}</td>
                <td class="text-center">{{ $item->satuan ?? '' }}</td>
                <td class="text-center">{{ $item->volume_drm ?? '-' }}</td>
                <td class="text-center">{{ $item->volume_aktual ?? '-' }}</td>
                <td class="text-center">{{ $item->volume_tambah ?? '-' }}</td>
                <td class="text-center">{{ $item->volume_kurang ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center text-muted">Belum ada data BOQ</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($boqItems->count() > 15)
<div class="page">
    <div class="doc-header">
        <h3>BAB 2: BILL OF QUANTITY (BOQ) - Lanjutan</h3>
    </div>
    @php renderPhotoMetaTable($projectMeta); @endphp
    <table>
        <thead>
            <tr>
                <th class="text-center" width="35">No</th>
                <th width="85">Kode Item</th>
                <th>Nama Item</th>
                <th class="text-center" width="55">Satuan</th>
                <th class="text-center" width="60">DRM</th>
                <th class="text-center" width="60">Aktual</th>
                <th class="text-center" width="60">Tambah</th>
                <th class="text-center" width="60">Kurang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($boqItems->slice(15) as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 16 }}</td>
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
</div>
@endif

<!-- PAGE 7-10: EVIDENCE PEKERJAAN -->
<div class="page">
    <div class="doc-header">
        <h3>BAB 3: LAMPIRAN EVIDENCE PEKERJAAN</h3>
    </div>
    @php renderPhotoMetaTable($projectMeta); @endphp
    
    <div class="section-title">3.1 Penarikan Kabel</div>
    @php $photos = $evidencePhotos->get('evident_penarikan_kabel', collect()); @endphp
    {!! renderPhotoGrid($photos) !!}
    
    <div class="section-title">3.2 Instalasi Aksesoris</div>
    @php $photos = $evidencePhotos->get('evident_instalasi_aksesoris', collect()); @endphp
    {!! renderPhotoGrid($photos) !!}
</div>

<div class="page">
    <div class="doc-header">
        <h3>BAB 4: LAMPIRAN EVIDENCE CLOSURE & ODP</h3>
    </div>
    @php renderPhotoMetaTable($projectMeta); @endphp
    
    <div class="section-title">4.1 Instalasi & Penyambungan Closure</div>
    @php $photos = $evidencePhotos->get('evident_closure', collect()); @endphp
    {!! renderPhotoGrid($photos) !!}
    
    <div class="section-title">4.2 Penyambungan & Instalasi ODP</div>
    @php $photos = $evidencePhotos->get('evident_odp', collect()); @endphp
    {!! renderPhotoGrid($photos) !!}
</div>

<div class="page">
    <div class="doc-header">
        <h3>BAB 5: LAMPIRAN EVIDENCE AS BUILD DRAWING (ABD)</h3>
    </div>
    @php renderPhotoMetaTable($projectMeta); @endphp
    @php $photos = $evidencePhotos->get('as_build_drawing', collect()); @endphp
    {!! renderPhotoGrid($photos) !!}
</div>

<!-- PAGE 11: MARKING KABEL -->
<div class="page">
    <div class="doc-header">
        <h3>BAB 6: MARKING KABEL</h3>
    </div>
    @php renderPhotoMetaTable($projectMeta); @endphp
    
    <table>
        <thead>
            <tr>
                <th class="text-center" width="50">No</th>
                <th>Jenis Kabel</th>
                <th class="text-center" width="100">Panjang (m)</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($markingKabels as $index => $mk)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $mk->jenis_kabel }}</td>
                <td class="text-center">{{ $mk->panjang_meter }}</td>
                <td>ODP {{ $mk->lokasi->code ?? '' }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center text-muted">Belum ada data marking kabel</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- PAGE 12-14: EVIDENCE ODP & AKSESORIS -->
<div class="page">
    <div class="doc-header">
        <h3>BAB 5: EVIDENCE ODP</h3>
    </div>
    @php renderPhotoMetaTable($projectMeta); @endphp
    
    <div class="section-title">5.1 Evidence ODP</div>
    @php $photos = $evidencePhotos->get('evident_odp', collect())->merge($evidencePhotos->get('odp_solid', collect()))->merge($evidencePhotos->get('pemasangan_odp', collect())); @endphp
    {!! renderPhotoGrid($photos) !!}
</div>

<div class="page">
    <div class="doc-header">
        <h3>BAB 6: EVIDENCE AKSESORIS & CLOSURE</h3>
    </div>
    @php renderPhotoMetaTable($projectMeta); @endphp
    
    <div class="section-title">6.1 Evidence Aksesoris (PU-AS-HL & PU-AS-SC)</div>
    @php $photos = $evidencePhotos->get('aksesoris_hl', collect())->merge($evidencePhotos->get('aksesoris_sc', collect())); @endphp
    {!! renderPhotoGrid($photos) !!}
    
    <div class="section-title">6.2 Evidence Closure dan Splitter 1:4</div>
    @php $photos = $evidencePhotos->get('closure_splitter', collect()); @endphp
    {!! renderPhotoGrid($photos) !!}
</div>

<div class="page">
    <div class="doc-header">
        <h3>BAB 7: LAMPIRAN EVIDENCE OPM & OTDR</h3>
    </div>
    @php renderPhotoMetaTable($projectMeta); @endphp
    @php $photos = $evidencePhotos->get('opm_hasil_ukur', $evidencePhotos->get('opm_otdr', collect())); @endphp
    {!! renderPhotoGrid($photos, 6) !!}
</div>

<!-- PAGE 17-18: OPM (dynamic) -->
<div class="page">
    <div class="doc-header">
        <h3>BAB 8: HASIL UKUR OPM</h3>
    </div>
    @php renderPhotoMetaTable($projectMeta); @endphp

    @if($opmRecords->count() > 0)
    <table class="opm-table">
        <thead>
            <tr>
                <th class="text-center" width="30">No</th>
                <th>Nama ODP</th>
                <th class="text-center" width="52">P1</th>
                <th class="text-center" width="52">P2</th>
                <th class="text-center" width="52">P3</th>
                <th class="text-center" width="52">P4</th>
                <th class="text-center" width="52">P5</th>
                <th class="text-center" width="52">P6</th>
                <th class="text-center" width="52">P7</th>
                <th class="text-center" width="52">P8</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($opmRecords as $i => $record)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $record->odp_name }}</td>
                <td class="text-center">{{ $record->port_1 ?? '-' }}</td>
                <td class="text-center">{{ $record->port_2 ?? '-' }}</td>
                <td class="text-center">{{ $record->port_3 ?? '-' }}</td>
                <td class="text-center">{{ $record->port_4 ?? '-' }}</td>
                <td class="text-center">{{ $record->port_5 ?? '-' }}</td>
                <td class="text-center">{{ $record->port_6 ?? '-' }}</td>
                <td class="text-center">{{ $record->port_7 ?? '-' }}</td>
                <td class="text-center">{{ $record->port_8 ?? '-' }}</td>
                <td>{{ $record->notes ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p class="text-muted">Belum ada data OPM.</p>
    @endif

    <div class="signature-block">
        <table>
            <tr>
                <td>
                    <div class="signature-line"></div>
                    <p class="text-center mb-0"><strong>Staff Pengukur</strong></p>
                    <p class="text-center mb-0">NIK: ___________</p>
                    <p class="text-center mb-0">PT TELKOM AKSES</p>
                </td>
                <td>
                    <div class="signature-line"></div>
                    <p class="text-center mb-0"><strong>{{ $waspang->nama ?? 'Waspang' }}</strong></p>
                    <p class="text-center mb-0">NIK: {{ $waspang->nik ?? '___________' }}</p>
                    <p class="text-center mb-0">PT TELKOM AKSES</p>
                </td>
            </tr>
        </table>
        <p class="text-center mt-3"><strong>{{ $kota_ttd }}, {{ $tanggal_ttd }}</strong></p>
    </div>
</div>

<!-- PAGE 19+: OTDR per ODP (dynamic) -->
@if($otdrFiles->count() > 0)
@php $otdrGrouped = $otdrFiles->groupBy('odp_name'); @endphp
@foreach($otdrGrouped as $odpName => $files)
<div class="page">
    <div class="doc-header">
        <h3>LAMPIRAN HASIL UKUR OTDR {{ strtoupper($odpName ?? 'OTDR') }}</h3>
    </div>
    @php renderPhotoMetaTable($projectMeta); @endphp

    @foreach($files as $otdr)
    @php
        $otdrPath = str_replace('\', '/', storage_path('app/public/' . $otdr->file_path));
        $ext = strtolower(pathinfo($otdr->original_name ?? $otdr->file_path, PATHINFO_EXTENSION));
        $isImg = in_array($ext, ['jpg', 'jpeg', 'png']);
        $otdrSrc = file_exists($otdrPath) ? 'file:///' . $otdrPath : '';
    @endphp
    <div style="margin-bottom:20px;text-align:center;">
        @if($otdrSrc && $isImg)
        <div class="photo-frame">
            <img src="{{ $otdrSrc }}" alt="{{ $otdr->odp_name }}" style="width:100%;max-height:320px;object-fit:contain;">
        </div>
        @else
        <div class="photo-placeholder" style="height:200px;">
            [{{ $otdr->original_name ?? basename($otdr->file_path) }}]
        </div>
        @endif
        <div class="photo-caption">{{ $otdr->original_name ?? basename($otdr->file_path) }}</div>
        <div class="photo-paraf">PARAF</div>
    </div>
    @endforeach
</div>
@endforeach
@else
<div class="page">
    <div class="doc-header">
        <h3>BAB 10: HASIL UKUR OTDR</h3>
    </div>
    @php renderPhotoMetaTable($projectMeta); @endphp
    <p class="text-muted">Belum ada file OTDR.</p>
</div>
@endif

<!-- PAGE 21: MANCORE -->
<div class="page">
    <div class="doc-header">
        <h3>BAB 11: DATA MANCORE</h3>
    </div>
    @php renderPhotoMetaTable($projectMeta); @endphp
    
    <div class=\"section-title\">11.1 Data Penyambungan Core di Closure</div>
    <table>
        <thead>
            <tr>
                <th class="text-center" width="50">No</th>
                <th>Core Dari</th>
                <th>Warna</th>
                <th>Core Ke</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mancoreItems as $index => $mcore)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $mcore->core_from }}</td>
                <td>{{ $mcore->warna }}</td>
                <td>{{ $mcore->core_to }}</td>
                <td>{{ $mcore->description ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted">Belum ada data mancore</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- PAGE 22-23: APPROVAL -->
<div class="page">
    <div class="doc-header">
        <h3>BAB 12: PERSETUJUAN WASPANG</h3>
    </div>
    @php renderPhotoMetaTable($projectMeta); @endphp
    
    <div class=\"section-title\">12.1 Pernyataan Persetujuan</div>
    <p style="text-align: justify; margin: 20px 0;">
        Saya yang bertanda tangan di bawah ini, selaku <strong>Waspang</strong> PT TELKOM AKSES, 
        menyatakan bahwa seluruh dokumen Laporan Akhir Cabang Telekomunikasi (LACT) untuk proyek 
        <strong>{{ $project->name }}</strong> telah diperiksa dan diverifikasi kelengkapannya.
    </p>
    @if(isset($approval) && $approval)
    <table>
        <tr>
            <th width="150">Status</th>
            <td><strong>{{ strtoupper($approval->status) }}</strong></td>
        </tr>
        <tr>
            <th>Disetujui Oleh</th>
            <td>{{ $approval->reviewer->name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td>{{ $approval->decided_at?->format('d F Y H:i') ?? '-' }}</td>
        </tr>
        @if(isset($approval) && $approval && $approval->notes)
        <tr>
            <th>Catatan</th>
            <td>{{ $approval->notes }}</td>
        </tr>
        @endif
    </table>
    @else
    <p class="text-muted">Belum ada persetujuan</p>
    @endif
    
    <div class="signature-block">
        <table>
            <tr>
                <td>
                    <div class="signature-line"></div>
                    <p class="text-center mb-0"><strong>{{ $waspang->name ?? 'Syaifin Nizar Zulmi' }}</strong></p>
                    <p class="text-center mb-0">NIK: {{ $waspang->nik ?? '885776' }}</p>
                    <p class="text-center mb-0">Waspang</p>
                    <p class="text-center mb-0">PT TELKOM AKSES</p>
                </td>
                <td>
                    <div class="signature-line"></div>
                    <p class="text-center mb-0"><strong>Koordinator Waspang</strong></p>
                    <p class="text-center mb-0">PT TELKOM AKSES</p>
                </td>
            </tr>
        </table>
        <p class="text-center mt-3"><strong>{{ $kota_ttd }}, {{ $tanggal_ttd }}</strong></p>
    </div>
</div>

</body>
</html>
