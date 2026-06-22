@php
    $projectMeta = [
        ['Nama Pekerjaan Kontrak', $project->name ?? '-'],
        ['Surat Pesanan', $project->purchase_order_number ?? '-'],
        ['Branch', strtoupper($project->branch->name ?? '-')],
        ['Lokasi', ($lokasi->code ?? '-') . ' [' . ($lokasi->name ?? '-') . ']'],
        ['Pelaksana', $project->implementer ?? '-'],
    ];
@endphp

<div class="page-break">
    <h3 class="text-center">BAB 1.4: LAMPIRAN FOTO COMMISSIONING TEST</h3>
    <table class="photo-info-table">
        @foreach($projectMeta as $row)
        <tr>
            <td style="width: 150px; font-weight: bold;">{{ $row[0] }}</td>
            <td>: {{ $row[1] }}</td>
        </tr>
        @endforeach
    </table>
    
    <h4>1.4.1 Dokumentasi Commissioning Test</h4>
    <div class="photo-grid">
        @foreach($commissioningImages as $photo)
        <div class="photo-cell">
            @php
                $path = storage_path('app/public/' . $photo->file_path);
                $path = str_replace('\\', '/', $path);
            @endphp
            @if(file_exists($path))
                <div class="photo-frame"><img src="file:///{{ $path }}" alt="{{ $photo->label ?: $photo->original_name ?? 'Foto' }}"></div>
            @else
                <div class="photo-placeholder">[Foto: {{ $photo->original_name ?? ($photo->label ?? 'Foto') }}]</div>
            @endif
            <div class="photo-caption">{{ $photo->label ?: ($photo->original_name ?? 'Foto') }}</div>
            <div class="photo-paraf">Paraf: _______________</div>
        </div>
        @endforeach
        @if($commissioningImages->isEmpty())
        <p class="text-muted">Belum ada foto commissioning test.</p>
        @endif
    </div>
</div>

<div class="page-break">
    <h3 class="text-center">BAB 2.1: LAMPIRAN FOTO BILL OF QUANTITY</h3>
    <table class="photo-info-table">
        @foreach($projectMeta as $row)
        <tr>
            <td style="width: 150px; font-weight: bold;">{{ $row[0] }}</td>
            <td>: {{ $row[1] }}</td>
        </tr>
        @endforeach
    </table>
    
    <h4>2.1.1 Dokumentasi BOQ</h4>
    <div class="photo-grid">
        @foreach($boqPhotos ?? [] as $photo)
        <div class="photo-cell">
            @php
                $path = storage_path('app/public/' . $photo->file_path);
                $path = str_replace('\\', '/', $path);
            @endphp
            @if(file_exists($path))
                <div class="photo-frame"><img src="file:///{{ $path }}" alt="{{ $photo->label ?: $photo->original_name ?? 'Foto' }}"></div>
            @else
                <div class="photo-placeholder">[Foto: {{ $photo->original_name ?? ($photo->label ?? 'Foto') }}]</div>
            @endif
            <div class="photo-caption">{{ $photo->label ?: ($photo->original_name ?? 'Foto') }}</div>
            <div class="photo-paraf">Paraf: _______________</div>
        </div>
        @endforeach
        @if(empty($boqPhotos) || (is_countable($boqPhotos) && count($boqPhotos) === 0))
        <p class="text-muted">Tidak ada foto BOQ.</p>
        @endif
    </div>
</div>

<div class="page-break">
    <h3 class="text-center">BAB 3: LAMPIRAN EVIDENCE PEKERJAAN</h3>
    <table class="photo-info-table">
        @foreach($projectMeta as $row)
        <tr>
            <td style="width: 150px; font-weight: bold;">{{ $row[0] }}</td>
            <td>: {{ $row[1] }}</td>
        </tr>
        @endforeach
    </table>
    
    <h4>3.1 Penarikan Kabel</h4>
    <div class="photo-grid">
        @foreach($evidencePenarikan ?? [] as $photo)
        <div class="photo-cell">
            @php
                $path = storage_path('app/public/' . $photo->file_path);
                $path = str_replace('\\', '/', $path);
            @endphp
            @if(file_exists($path))
                <div class="photo-frame"><img src="file:///{{ $path }}" alt="{{ $photo->label ?: $photo->original_name ?? 'Foto' }}"></div>
            @else
                <div class="photo-placeholder">[Foto: {{ $photo->original_name ?? ($photo->label ?? 'Foto') }}]</div>
            @endif
            <div class="photo-caption">{{ $photo->label ?: ($photo->original_name ?? 'Foto') }}</div>
            <div class="photo-paraf">Paraf: _______________</div>
        </div>
        @endforeach
        @if(empty($evidencePenarikan))
        <p class="text-muted">Belum ada foto penarikan kabel.</p>
        @endif
    </div>
    
    <h4>3.2 Instalasi Aksesoris</h4>
    <div class="photo-grid">
        @foreach($evidenceAksesoris ?? [] as $photo)
        <div class="photo-cell">
            @php
                $path = storage_path('app/public/' . $photo->file_path);
                $path = str_replace('\\', '/', $path);
            @endphp
            @if(file_exists($path))
                <div class="photo-frame"><img src="file:///{{ $path }}" alt="{{ $photo->label ?: $photo->original_name ?? 'Foto' }}"></div>
            @else
                <div class="photo-placeholder">[Foto: {{ $photo->original_name ?? ($photo->label ?? 'Foto') }}]</div>
            @endif
            <div class="photo-caption">{{ $photo->label ?: ($photo->original_name ?? 'Foto') }}</div>
            <div class="photo-paraf">Paraf: _______________</div>
        </div>
        @endforeach
        @if(empty($evidenceAksesoris))
        <p class="text-muted">Belum ada foto instalasi aksesoris.</p>
        @endif
    </div>
</div>

<div class="page-break">
    <h3 class="text-center">BAB 4: LAMPIRAN MARKING KABEL</h3>
    <table class="photo-info-table">
        @foreach($projectMeta as $row)
        <tr>
            <td style="width: 150px; font-weight: bold;">{{ $row[0] }}</td>
            <td>: {{ $row[1] }}</td>
        </tr>
        @endforeach
    </table>
    
    <h4>4.1 Marking Kabel</h4>
    <div class="photo-grid">
        @foreach($markingPhotos ?? [] as $photo)
        <div class="photo-cell">
            @php
                $path = storage_path('app/public/' . $photo->file_path);
                $path = str_replace('\\', '/', $path);
            @endphp
            @if(file_exists($path))
                <div class="photo-frame"><img src="file:///{{ $path }}" alt="{{ $photo->label ?: $photo->original_name ?? 'Foto' }}"></div>
            @else
                <div class="photo-placeholder">[Foto: {{ $photo->original_name ?? ($photo->label ?? 'Foto') }}]</div>
            @endif
            <div class="photo-caption">{{ $photo->label ?: ($photo->original_name ?? 'Foto') }}</div>
            <div class="photo-paraf">Paraf: _______________</div>
        </div>
        @endforeach
        @if(empty($markingPhotos))
        <p class="text-muted">Belum ada foto marking kabel.</p>
        @endif
    </div>
</div>

<div class="page-break">
    <h3 class="text-center">BAB 5: LAMPIRAN EVIDENCE ODP</h3>
    <table class="photo-info-table">
        @foreach($projectMeta as $row)
        <tr>
            <td style="width: 150px; font-weight: bold;">{{ $row[0] }}</td>
            <td>: {{ $row[1] }}</td>
        </tr>
        @endforeach
    </table>
    
    <h4>5.1 Evidence ODP</h4>
    <div class="photo-grid">
        @foreach($evidenceOdp ?? [] as $photo)
        <div class="photo-cell">
            @php
                $path = storage_path('app/public/' . $photo->file_path);
                $path = str_replace('\\', '/', $path);
            @endphp
            @if(file_exists($path))
                <div class="photo-frame"><img src="file:///{{ $path }}" alt="{{ $photo->label ?: $photo->original_name ?? 'Foto' }}"></div>
            @else
                <div class="photo-placeholder">[Foto: {{ $photo->original_name ?? ($photo->label ?? 'Foto') }}]</div>
            @endif
            <div class="photo-caption">{{ $photo->label ?: ($photo->original_name ?? 'Foto') }}</div>
            <div class="photo-paraf">Paraf: _______________</div>
        </div>
        @endforeach
        @if(empty($evidenceOdp))
        <p class="text-muted">Belum ada foto evidence ODP.</p>
        @endif
    </div>
</div>

<div class="page-break">
    <h3 class="text-center">BAB 6: LAMPIRAN EVIDENCE AKSESORIS</h3>
    <table class="photo-info-table">
        @foreach($projectMeta as $row)
        <tr>
            <td style="width: 150px; font-weight: bold;">{{ $row[0] }}</td>
            <td>: {{ $row[1] }}</td>
        </tr>
        @endforeach
    </table>
    
    <h4>6.1 Evidence Aksesoris (PU-AS-HL & PU-AS-SC)</h4>
    <div class="photo-grid">
        @foreach($evidenceAksesorisDetail ?? [] as $photo)
        <div class="photo-cell">
            @php
                $path = storage_path('app/public/' . $photo->file_path);
                $path = str_replace('\\', '/', $path);
            @endphp
            @if(file_exists($path))
                <div class="photo-frame"><img src="file:///{{ $path }}" alt="{{ $photo->label ?: $photo->original_name ?? 'Foto' }}"></div>
            @else
                <div class="photo-placeholder">[Foto: {{ $photo->original_name ?? ($photo->label ?? 'Foto') }}]</div>
            @endif
            <div class="photo-caption">{{ $photo->label ?: ($photo->original_name ?? 'Foto') }}</div>
            <div class="photo-paraf">Paraf: _______________</div>
        </div>
        @endforeach
        @if(empty($evidenceAksesorisDetail))
        <p class="text-muted">Belum ada foto evidence aksesoris.</p>
        @endif
    </div>
</div>

<div class="page-break">
    <h3 class="text-center">BAB 7: LAMPIRAN EVIDENCE CLOSURE & SPLITTER 1:4</h3>
    <table class="photo-info-table">
        @foreach($projectMeta as $row)
        <tr>
            <td style="width: 150px; font-weight: bold;">{{ $row[0] }}</td>
            <td>: {{ $row[1] }}</td>
        </tr>
        @endforeach
    </table>
    
    <h4>7.1 Instalasi & Penyambungan Closure</h4>
    <div class="photo-grid">
        @foreach($evidenceClosure ?? [] as $photo)
        <div class="photo-cell">
            @php
                $path = storage_path('app/public/' . $photo->file_path);
                $path = str_replace('\\', '/', $path);
            @endphp
            @if(file_exists($path))
                <div class="photo-frame"><img src="file:///{{ $path }}" alt="{{ $photo->label ?: $photo->original_name ?? 'Foto' }}"></div>
            @else
                <div class="photo-placeholder">[Foto: {{ $photo->original_name ?? ($photo->label ?? 'Foto') }}]</div>
            @endif
            <div class="photo-caption">{{ $photo->label ?: ($photo->original_name ?? 'Foto') }}</div>
            <div class="photo-paraf">Paraf: _______________</div>
        </div>
        @endforeach
        @if(empty($evidenceClosure))
        <p class="text-muted">Belum ada foto evidence closure.</p>
        @endif
    </div>
    
    <h4>7.2 Splitter 1:4</h4>
    <div class="photo-grid">
        @foreach($evidenceSplitter ?? [] as $photo)
        <div class="photo-cell">
            @php
                $path = storage_path('app/public/' . $photo->file_path);
                $path = str_replace('\\', '/', $path);
            @endphp
            @if(file_exists($path))
                <div class="photo-frame"><img src="file:///{{ $path }}" alt="{{ $photo->label ?: $photo->original_name ?? 'Foto' }}"></div>
            @else
                <div class="photo-placeholder">[Foto: {{ $photo->original_name ?? ($photo->label ?? 'Foto') }}]</div>
            @endif
            <div class="photo-caption">{{ $photo->label ?: ($photo->original_name ?? 'Foto') }}</div>
            <div class="photo-paraf">Paraf: _______________</div>
        </div>
        @endforeach
        @if(empty($evidenceSplitter))
        <p class="text-muted">Belum ada foto splitter 1:4.</p>
        @endif
    </div>
</div>

<div class="page-break">
    <h3 class="text-center">BAB 8: LAMPIRAN EVIDENCE HASIL UKUR OPM</h3>
    <table class="photo-info-table">
        @foreach($projectMeta as $row)
        <tr>
            <td style="width: 150px; font-weight: bold;">{{ $row[0] }}</td>
            <td>: {{ $row[1] }}</td>
        </tr>
        @endforeach
    </table>
    
    <h4>8.1 Hasil Ukur OPM</h4>
    <div class="photo-grid">
        @foreach($evidenceOpm ?? [] as $photo)
        <div class="photo-cell">
            @php
                $path = storage_path('app/public/' . $photo->file_path);
                $path = str_replace('\\', '/', $path);
            @endphp
            @if(file_exists($path))
                <div class="photo-frame"><img src="file:///{{ $path }}" alt="{{ $photo->label ?: $photo->original_name ?? 'Foto' }}"></div>
            @else
                <div class="photo-placeholder">[Foto: {{ $photo->original_name ?? ($photo->label ?? 'Foto') }}]</div>
            @endif
            <div class="photo-caption">{{ $photo->label ?: ($photo->original_name ?? 'Foto') }}</div>
            <div class="photo-paraf">Paraf: _______________</div>
        </div>
        @endforeach
        @if(empty($evidenceOpm))
        <p class="text-muted">Belum ada foto hasil ukur OPM.</p>
        @endif
    </div>
</div>

<div class="page-break">
    <h3 class="text-center">BAB 9: LAMPIRAN DATA PENGUKURAN OPM PROJECT OUTSIDE PLANT FIBER OPTIC</h3>
    <table class="photo-info-table">
        @foreach($projectMeta as $row)
        <tr>
            <td style="width: 150px; font-weight: bold;">{{ $row[0] }}</td>
            <td>: {{ $row[1] }}</td>
        </tr>
        @endforeach
    </table>
    
    <h4>9.1 Data Pengukuran ODP-PAT-FW/114</h4>
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
    
    <h4>9.2 Data Pengukuran ODP-PAT-FW/115</h4>
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
    
    <div class="photo-paraf mt-3">Paraf Waspang: _______________</div>
</div>

<div class="page-break">
    <h3 class="text-center">BAB 10: LAMPIRAN HASIL UKUR OTDR ODP-PAT-FW/114</h3>
    <table class="photo-info-table">
        @foreach($projectMeta as $row)
        <tr>
            <td style="width: 150px; font-weight: bold;">{{ $row[0] }}</td>
            <td>: {{ $row[1] }}</td>
        </tr>
        @endforeach
    </table>
    
    <h4>10.1 Grafik OTDR ODP-PAT-FW/114</h4>
    @php $files114 = $otdrFiles->filter(fn($f) => str_contains(strtolower($f->nama_file ?? ''), '114')); @endphp
    @if($files114->count() > 0)
        @foreach($files114 as $file)
        <div class="photo-placeholder" style="height: 250px; margin-bottom: 10px;">
            [Grafik OTDR 114: {{ $file->nama_file }}]
        </div>
        @endforeach
    @else
        <div class="photo-placeholder" style="height: 250px;">
            [Screenshot Alat Ukur OTDR - ODP-PAT-FW/114]
        </div>
    @endif
    <div class="photo-paraf">Paraf: _______________</div>
</div>

<div class="page-break">
    <h3 class="text-center">BAB 11: LAMPIRAN HASIL UKUR OTDR ODP-PAT-FW/115</h3>
    <table class="photo-info-table">
        @foreach($projectMeta as $row)
        <tr>
            <td style="width: 150px; font-weight: bold;">{{ $row[0] }}</td>
            <td>: {{ $row[1] }}</td>
        </tr>
        @endforeach
    </table>
    
    <h4>11.1 Grafik OTDR ODP-PAT-FW/115</h4>
    @php $files115 = $otdrFiles->filter(fn($f) => str_contains(strtolower($f->nama_file ?? ''), '115')); @endphp
    @if($files115->count() > 0)
        @foreach($files115 as $file)
        <div class="photo-placeholder" style="height: 250px; margin-bottom: 10px;">
            [Grafik OTDR 115: {{ $file->nama_file }}]
        </div>
        @endforeach
    @else
        <div class="photo-placeholder" style="height: 250px;">
            [Screenshot Alat Ukur OTDR - ODP-PAT-FW/115]
        </div>
    @endif
    <div class="photo-paraf">Paraf: _______________</div>
</div>

<div class="page-break">
    <h3 class="text-center">BAB 12: LAMPIRAN MANCORE</h3>
    <table class="photo-info-table">
        @foreach($projectMeta as $row)
        <tr>
            <td style="width: 150px; font-weight: bold;">{{ $row[0] }}</td>
            <td>: {{ $row[1] }}</td>
        </tr>
        @endforeach
    </table>
    
    <h4>12.1 Data Penyambungan Core di Closure</h4>
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
    
    <div class="photo-paraf mt-3">Paraf: _______________</div>
</div>

<div class="page-break">
    <h3 class="text-center">BAB 13: LAMPIRAN EVIDENCE AS BUILD DRAWING (ABD)</h3>
    <table class="photo-info-table">
        @foreach($projectMeta as $row)
        <tr>
            <td style="width: 150px; font-weight: bold;">{{ $row[0] }}</td>
            <td>: {{ $row[1] }}</td>
        </tr>
        @endforeach
    </table>
    
    <h4>13.1 As Build Drawing</h4>
    <div class="photo-grid">
        @foreach($evidenceAbd ?? [] as $photo)
        <div class="photo-cell">
            @php
                $path = storage_path('app/public/' . $photo->file_path);
                $path = str_replace('\\', '/', $path);
            @endphp
            @if(file_exists($path))
                <div class="photo-frame"><img src="file:///{{ $path }}" alt="{{ $photo->label ?: $photo->original_name ?? 'Foto' }}"></div>
            @else
                <div class="photo-placeholder">[Foto: {{ $photo->original_name ?? ($photo->label ?? 'Foto') }}]</div>
            @endif
            <div class="photo-caption">{{ $photo->label ?: ($photo->original_name ?? 'Foto') }}</div>
            <div class="photo-paraf">Paraf: _______________</div>
        </div>
        @endforeach
        @if(empty($evidenceAbd))
        <p class="text-muted">Belum ada foto as build drawing.</p>
        @endif
    </div>
</div>

<style>
.page-break { page-break-after: always; }
.photo-info-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 16px;
    font-size: 9.5pt;
}
.photo-info-table td { padding: 3px 4px; vertical-align: top; }
.photo-grid { display: table; width: 100%; }
.photo-cell {
    display: table-cell;
    width: 33%;
    padding: 10px;
    text-align: center;
    vertical-align: top;
}
.photo-frame {
    border: 1px solid #ccc;
    padding: 4px;
    min-height: 150px;
}
.photo-frame img {
    width: 100%;
    max-height: 180px;
    object-fit: contain;
}
.photo-placeholder {
    border: 1px dashed #999;
    min-height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #999;
}
.photo-caption { font-size: 9pt; margin-top: 5px; text-align: center; }
.photo-paraf { font-size: 9pt; margin-top: 8px; text-align: center; font-weight: bold; }
.opm-table th { background-color: #e8f4f8; }
</style>