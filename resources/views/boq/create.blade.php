@extends('layouts.app')

@section('title', 'Laporan Bill of Quantity (BOQ)')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="detail-card">
            <div class="detail-card-header d-flex justify-content-between align-items-center">
                <h5>Laporan Bill of Quantity (BOQ)</h5>
                <a href="{{ route('boq.create') }}" class="btn-primary-gradient">
                    <i class="bi bi-plus-circle"></i> Tambah Item BOQ
                </a>
            </div>
            <div class="detail-card-body">

                <form method="GET" action="{{ route('boq.index') }}" class="row g-3 mb-4">
                    <div class="col-md-5">
                        <label class="form-label-soft">Lokasi</label>
                        <select name="lokasi_id" class="form-select-soft">
                            <option value="">-- Semua Lokasi --</option>
                            @foreach($lokasiList as $lokasi)
                            <option value="{{ $lokasi->id }}" {{ request('lokasi_id') == $lokasi->id ? 'selected' : '' }}>
                                {{ $lokasi->name }} ({{ $lokasi->code }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label-soft">Proyek</label>
                        <select name="project_id" class="form-select-soft">
                            <option value="">-- Semua Proyek --</option>
                            @foreach($projectList as $project)
                            <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn-primary-gradient w-100">Filter</button>
                    </div>
                </form>

                @php
                    $selectedLokasi = null;
                    if (request('lokasi_id')) {
                        $selectedLokasi = \App\Models\Lokasi::with('branch')->find(request('lokasi_id'));
                    }
                    $selectedProject = null;
                    if (request('project_id')) {
                        $selectedProject = \App\Models\Project::find(request('project_id'));
                    }
                    // If no filter selected, try first project + first lokasi combo as default
                    if (!$selectedLokasi && !$selectedProject && $projectList->count() > 0) {
                        $selectedProject = $projectList->first();
                        $selectedLokasi = $selectedProject->location;
                    }
                @endphp

                @if($selectedLokasi || $selectedProject)
                <div class="report-paper">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold text-uppercase">Laporan Bill of Quantity</h4>
                        <hr class="border-dark my-2">
                    </div>

                    <div class="report-info mb-4">
                        <div class="row mb-1">
                            <div class="col-3 fw-bold">PROYEK</div>
                            <div class="col-9">: {{ $selectedProject->name ?? '-' }}</div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3 fw-bold">KONTRAK</div>
                            <div class="col-9">: {{ $selectedProject->contract_number ?? '-' }}</div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3 fw-bold">SURAT PESANAN</div>
                            <div class="col-9">: {{ $selectedProject->purchase_order_number ?? '-' }}</div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3 fw-bold">BRANCH</div>
                            <div class="col-9">: {{ strtoupper($selectedLokasi->branch->name ?? '-') }}</div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3 fw-bold">LOKASI</div>
                            <div class="col-9">: {{ $selectedLokasi->code ?? '-' }} [{{ $selectedLokasi->name ?? '-' }}]</div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3 fw-bold">PELAKSANA</div>
                            <div class="col-9">: {{ $selectedProject->implementer ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="report-signature mb-4">
                        <div class="text-end">
                            <p class="mb-1"><strong>SEMARANG, {{ \Carbon\Carbon::now()->format('d F Y') }}</strong></p>
                            <p class="mb-1">WASPANG</p>
                            <p class="mb-1">PT TELKOM AKSES</p>
                            <br><br>
                            <p class="mb-0 fw-bold">SYAIFIN NIZAR ZULMI</p>
                            <p class="mb-0">NIK : 885776</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5 class="fw-bold mb-3">Daftar Barang/Jasa</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered report-table">
                                <thead>
                                    <tr class="text-center">
                                        <th width="50">No</th>
                                        <th>Uraian Pekerjaan</th>
                                        <th width="100">Volume</th>
                                        <th width="100">Satuan</th>
                                        <th width="150" class="text-end">Harga Satuan (Rp)</th>
                                        <th width="150" class="text-end">Jumlah (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $items = \App\Models\BoqItem::with(['lokasi', 'project'])
                                            ->when($selectedLokasi, fn($q) => $q->where('lokasi_id', $selectedLokasi->id))
                                            ->when($selectedProject, fn($q) => $q->where('project_id', $selectedProject->id))
                                            ->orderBy('id')->get();
                                    @endphp
                                    @forelse($items as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $item->item_code ? $item->item_code . ' - ' : '' }}{{ $item->name }}</td>
                                        <td class="text-center">{{ $item->volume }}</td>
                                        <td class="text-center">{{ $item->unit ?? '-' }}</td>
                                        <td class="text-end">-</td>
                                        <td class="text-end">-</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada data BOQ untuk filter yang dipilih.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="fw-bold text-end">TOTAL</td>
                                        <td class="fw-bold text-end">-</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .report-paper {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 2.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .report-info .row {
        border-bottom: 1px dotted #d1d5db;
        padding: 6px 0;
    }

    .report-table th,
    .report-table td {
        vertical-align: middle;
        font-size: 0.875rem;
    }

    .report-table thead th {
        background: #f9fafb;
        border-bottom: 2px solid #000;
    }

    .report-signature {
        margin-top: 3rem;
    }
</style>
@endsection
