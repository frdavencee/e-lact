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
    <div class="cover">
        <h1>LAPORAN AKHIR CABANG<br>TELEKOMUNIKASI</h1>
        <h2>LACT</h2>
        
        <div class="info">
            <table>
                <tr><td>Proyek</td><td>: {{ $project->name }}</td></tr>
                <tr><td>Kontrak</td><td>: {{ $project->contract_number ?? '-' }}</td></tr>
                <tr><td>Surat Pesanan</td><td>: {{ $project->purchase_order_number ?? '-' }}</td></tr>
                <tr><td>Branch</td><td>: {{ strtoupper($project->branch->name ?? '-') }}</td></tr>
                <tr><td>Lokasi</td><td>: {{ $project->location->code ?? '-' }} [{{ $project->location->name ?? '-' }}]</td></tr>
                <tr><td>Pelaksana</td><td>: {{ $project->implementer ?? '-' }}</td></tr>
                <tr><td>Tanggal</td><td>: {{ now()->format('d F Y') }}</td></tr>
            </table>
        </div>
    </div>
</div>

<!-- PAGE 2: INDEX -->
<div class="page">
    <div class="doc-header">
        <h3>DAFTAR ISI</h3>
    </div>
    <table>
        <tr><th>No</th><th>Bab</th><th>Deskripsi</th><th>Halaman</th></tr>
        <tr><td class="text-center">1</td><td>Commissioning Test</td><td>Hasil pemeriksaan Waspang</td><td class="text-center">3</td></tr>
        <tr><td class="text-center">2</td><td>Bill of Quantity</td><td>Daftar item pekerjaan</td><td class="text-center">4-6</td></tr>
        <tr><td class="text-center">3</td><td>Evidence Pekerjaan</td><td>Dokumentasi foto pekerjaan</td><td class="text-center">7-10</td></tr>
        <tr><td class="text-center">4</td><td>Marking Kabel</td><td>Diagram marking kabel</td><td class="text-center">11</td></tr>
        <tr><td class="text-center">5</td><td>Evidence ODP</td><td>Foto ODP & aksesoris</td><td class="text-center">12-14</td></tr>
        <tr><td class="text-center">6</td><td>Evidence Closure</td><td>Foto closure & splitter</td><td class="text-center">15-16</td></tr>
        <tr><td class="text-center">7</td><td>Hasil Ukur OPM</td><td>Data pengukuran ODP</td><td class="text-center">17-18</td></tr>
        <tr><td class="text-center">8</td><td>Hasil Ukur OTDR</td><td>Grafik OTDR</td><td class="text-center">19-20</td></tr>
        <tr><td class="text-center">9</td><td>Mancore</td><td>Data penyambungan core</td><td class="text-center">21</td></tr>
        <tr><td class="text-center">10</td><td>Approval</td><td>Persetujuan Waspang</td><td class="text-center">22-23</td></tr>
    </table>
</div>

<!-- PAGE 3: COMMISSIONING TEST -->
<div class="page">
    <div class="doc-header">
        <h3>BAB 1: COMMISSIONING TEST</h3>
    </div>
    
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
    
    <table>
        <thead>
            <tr>
                <th class="text-center" width="50">No</th>
                <th>Kode Item</th>
                <th>Uraian Pekerjaan</th>
                <th class="text-center" width="80">Volume</th>
                <th class="text-center" width="70">Satuan</th>
                <th class="text-end" width="120">Harga Satuan (Rp)</th>
                <th class="text-end" width="140">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @forelse($boqItems as $index => $item)
            @php
                $jumlah = $item->price * $item->volume;
                $total += $jumlah;
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->item_code ?? '' }}</td>
                <td>{{ $item->name }}</td>
                <td class="text-center">{{ $item->volume }}</td>
                <td class="text-center">{{ $item->unit }}</td>
                <td class="text-end">{{ number_format($item->price, 2) }}</td>
                <td class="text-end">{{ number_format($jumlah, 2) }}</td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted">Belum ada data BOQ</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="fw-bold">
                <td colspan="6" class="text-end">TOTAL</td>
                <td class="text-end">{{ number_format($total, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</div>

@if($boqItems->count() > 10)
<div class="page">
    <div class="doc-header">
        <h3>BAB 2: BILL OF QUANTITY (BOQ) - Lanjutan</h3>
    </div>
    <table>
        <thead>
            <tr>
                <th class="text-center" width="50">No</th>
                <th>Kode Item</th>
                <th>Uraian Pekerjaan</th>
                <th class="text-center" width="80">Volume</th>
                <th class="text-center" width="70">Satuan</th>
                <th class="text-end" width="120">Harga Satuan (Rp)</th>
                <th class="text-end" width="140">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($boqItems->slice(10) as $index => $item)
            @php
                $no = $index + 11;
                $jumlah = $item->price * $item->volume;
            @endphp
            <tr>
                <td class="text-center">{{ $no }}</td>
                <td>{{ $item->item_code ?? '' }}</td>
                <td>{{ $item->name }}</td>
                <td class="text-center">{{ $item->volume }}</td>
                <td class="text-center">{{ $item->unit }}</td>
                <td class="text-end">{{ number_format($item->price, 2) }}</td>
                <td class="text-end">{{ number_format($jumlah, 2) }}</td>
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
    @php $photos = $evidencePhotos->get('opm_otdr', collect()); @endphp
    {!! renderPhotoGrid($photos, 6) !!}
</div>

<!-- PAGE 17-18: OPM -->
<div class="page">
    <div class="doc-header">
        <h3>BAB 8: HASIL UKUR OPM</h3>
    </div>
    @php renderPhotoMetaTable($projectMeta); @endphp
    
    <div class=\"section-title\">9.1 Data Pengukuran ODP-PAT-FW/114</div>
    <table class="opm-table">
        <thead>
            <tr>
                <th class="text-center" width="80">Port</th>
                <th class="text-center">Fiber</th>
                <th class="text-end">Nilai (dBm)</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $records114 = $opmRecords->where('odp_name', 'ODP-PAT-FW/114');
            @endphp
            @forelse($records114 as $record)
            <tr>
                <td class="text-center">{{ $record->port }}</td>
                <td class="text-center">-</td>
                <td class="text-end">{{ $record->value }}</td>
                <td>-</td>
            </tr>
            @empty
            <tr>
                <td class="text-center">1</td><td class="text-center">-</td><td class="text-end">-15,30</td><td>-</td>
                <td class="text-center">2</td><td class="text-center">-</td><td class="text-end">-15,35</td><td>-</td>
                <td class="text-center">3</td><td class="text-center">-</td><td class="text-end">-15,40</td><td>-</td>
                <td class="text-center">4</td><td class="text-center">-</td><td class="text-end">-15,25</td><td>-</td>
                <td class="text-center">5</td><td class="text-center">-</td><td class="text-end">-15,50</td><td>-</td>
                <td class="text-center">6</td><td class="text-center">-</td><td class="text-end">-15,45</td><td>-</td>
                <td class="text-center">7</td><td class="text-center">-</td><td class="text-end">-15,30</td><td>-</td>
                <td class="text-center">8</td><td class="text-center">-</td><td class="text-end">-15,35</td><td>-</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class=\"section-title\">9.2 Data Pengukuran ODP-PAT-FW/115</div>
    <table class="opm-table">
        <thead>
            <tr>
                <th class="text-center" width="80">Port</th>
                <th class="text-center">Fiber</th>
                <th class="text-end">Nilai (dBm)</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $records115 = $opmRecords->where('odp_name', 'ODP-PAT-FW/115');
            @endphp
            @forelse($records115 as $record)
            <tr>
                <td class="text-center">{{ $record->port }}</td>
                <td class="text-center">-</td>
                <td class="text-end">{{ $record->value }}</td>
                <td>-</td>
            </tr>
            @empty
            <tr>
                <td class="text-center">1</td><td class="text-center">-</td><td class="text-end">-15,10</td><td>-</td>
                <td class="text-center">2</td><td class="text-center">-</td><td class="text-end">-15,20</td><td>-</td>
                <td class="text-center">3</td><td class="text-center">-</td><td class="text-end">-15,40</td><td>-</td>
                <td class="text-center">4</td><td class="text-center">-</td><td class="text-end">-16,00</td><td>-</td>
                <td class="text-center">5</td><td class="text-center">-</td><td class="text-end">-15,60</td><td>-</td>
                <td class="text-center">6</td><td class="text-center">-</td><td class="text-end">-16,20</td><td>-</td>
                <td class="text-center">7</td><td class="text-center">-</td><td class="text-end">-16,50</td><td>-</td>
                <td class="text-center">8</td><td class="text-center">-</td><td class="text-end">-15,80</td><td>-</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="page">
    <div class="doc-header">
        <h3>TANDA TANGAN PENGUKUR OPM</h3>
    </div>
    
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
                    <p class="text-center mb-0"><strong>Waspang</strong></p>
                    <p class="text-center mb-0">NIK: {{ $commissioning->nik ?? '885776' }}</p>
                    <p class="text-center mb-0">PT TELKOM AKSES</p>
                </td>
            </tr>
        </table>
        <p class="text-center mt-3"><strong>{{ $kota_ttd }}, {{ $tanggal_ttd }}</strong></p>
    </div>
</div>

<!-- PAGE 19-20: OTDR -->
<div class="page">
    <div class="doc-header">
        <h3>BAB 10: HASIL UKUR OTDR</h3>
    </div>
    
    <div class=\"section-title\">10.1 Grafik OTDR ODP-PAT-FW/114</div>
    @php $files114 = $otdrFiles->filter(fn($f) => str_contains(strtolower($f->nama_file), '114')); @endphp
    @if($files114->count() > 0)
        @foreach($files114->take(2) as $file)
        <div class="photo-placeholder" style="height: 300px; margin-bottom: 10px;">
            [Grafik OTDR 114: {{ $file->nama_file }}]
        </div>
        @endforeach
    @else
        <div class="photo-placeholder" style="height: 300px;">
            [Screenshot Alat Ukur OTDR - ODP 114]
        </div>
    @endif
    
    <div class=\"section-title\">10.2 Grafik OTDR ODP-PAT-FW/115</div>
    @php $files115 = $otdrFiles->filter(fn($f) => str_contains(strtolower($f->nama_file), '115')); @endphp
    @if($files115->count() > 0)
        @foreach($files115->take(2) as $file)
        <div class="photo-placeholder" style="height: 300px; margin-bottom: 10px;">
            [Grafik OTDR 115: {{ $file->nama_file }}]
        </div>
        @endforeach
    @else
        <div class="photo-placeholder" style="height: 300px;">
            [Screenshot Alat Ukur OTDR - ODP 115]
        </div>
    @endif
</div>

<!-- PAGE 21: MANCORE -->
<div class="page">
    <div class="doc-header">
        <h3>BAB 11: DATA MANCORE</h3>
    </div>
    
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
        @if($approval->notes)
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
