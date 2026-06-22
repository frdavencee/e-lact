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
        <div class="detail-card mt-3">
            <div class="detail-card-header">
                <h5>Tambah Data OPM</h5>
            </div>
            <div class="detail-card-body">
                <form method="POST" action="{{ route('opm.store', $lokasi) }}" class="row g-2">
                    @csrf
                    <div class="col-md-3">
                        <label class="form-label-soft">Nama ODP</label>
                        <input type="text" name="odp_name" class="form-control-soft input-mono" placeholder="ODP-PAT-FW/114" required>
                    </div>
                    @for($p = 1; $p <= 8; $p++)
                    <div class="col-md-1">
                        <label class="form-label-soft">Port {{ $p }}</label>
                        <input type="number" step="0.01" name="port_{{ $p }}" class="form-control-soft input-mono" placeholder="-15.00">
                    </div>
                    @endfor
                    <div class="col-md-2">
                        <label class="form-label-soft">Catatan</label>
                        <input type="text" name="notes" class="form-control-soft" placeholder="Opsional">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn-primary-gradient"><i class="bi bi-plus"></i> Tambah OPM</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="detail-card mt-3">
            <div class="detail-card-header">
                <h5>Data Pengukuran OPM</h5>
                <span class="badge-modern badge-info">{{ $opmRecords->count() }} pengukuran</span>
            </div>
            <div class="detail-card-body">
                <div class="table-responsive">
                    <table class="table-modern">
                        <thead>
                            <tr>
                                <th>ODP Name</th>
                                <th>Port 1</th><th>Port 2</th><th>Port 3</th><th>Port 4</th>
                                <th>Port 5</th><th>Port 6</th><th>Port 7</th><th>Port 8</th>
                                <th>Catatan</th>
                                <th width="60"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($opmRecords as $opm)
                            <tr>
                                <td><strong>{{ $opm->odp_name }}</strong></td>
                                <td>{{ $opm->port_1 ?? '-' }}</td>
                                <td>{{ $opm->port_2 ?? '-' }}</td>
                                <td>{{ $opm->port_3 ?? '-' }}</td>
                                <td>{{ $opm->port_4 ?? '-' }}</td>
                                <td>{{ $opm->port_5 ?? '-' }}</td>
                                <td>{{ $opm->port_6 ?? '-' }}</td>
                                <td>{{ $opm->port_7 ?? '-' }}</td>
                                <td>{{ $opm->port_8 ?? '-' }}</td>
                                <td>{{ $opm->notes ?? '-' }}</td>
                                <td>
                                    <form action="{{ route('opm.destroy', [$lokasi, $opm]) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                        @csrf @method('DELETE')
                                        <button class="action-icon-btn btn-delete"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="11"><div class="empty-state"><i class="bi bi-bar-chart"></i><p>Belum ada data OPM.</p></div></td></tr>
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
