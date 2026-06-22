@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')
<div class="detail-header">
    <div>
        <h2>{{ $report->title }}</h2>
        <p class="text-muted mb-0">Laporan {{ ucfirst($report->type) }} &middot; {{ $report->reportDateFormatted }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('reports.edit', $report) }}" class="btn-edit">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('reports.index') }}" class="btn-soft-secondary">Kembali</a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="detail-card mb-3">
            <div class="detail-card-header">
                <h5>Informasi Umum</h5>
            </div>
            <div class="detail-card-body">
                <table class="info-table">
                    <tr>
                        <th>Proyek</th>
                        <td>{{ $report->project->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Dibuat Oleh</th>
                        <td>{{ $report->user->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Laporan</th>
                        <td>{{ $report->reportDateFormatted }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi</th>
                        <td>{{ $report->location ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Staff PD</th>
                        <td>{{ $report->pd_staff ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $report->description ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="detail-card mb-3">
            <div class="detail-card-header">
                <h5>Temuan</h5>
            </div>
            <div class="detail-card-body">
                @if($report->findings)
                    <div class="content-area-pdf">{!! nl2br(e($report->findings)) !!}</div>
                @else
                    <p class="text-muted">-</p>
                @endif
            </div>
        </div>

        <div class="detail-card mb-3">
            <div class="detail-card-header">
                <h5>Rekomendasi</h5>
            </div>
            <div class="detail-card-body">
                @if($report->recommendations)
                    <div class="content-area-pdf">{!! nl2br(e($report->recommendations)) !!}</div>
                @else
                    <p class="text-muted">-</p>
                @endif
            </div>
        </div>

        <div class="detail-card mb-3">
            <div class="detail-card-header">
                <h5>Rencana Tindak Lanjut</h5>
            </div>
            <div class="detail-card-body">
                @if($report->action_plan)
                    <div class="content-area-pdf">{!! nl2br(e($report->action_plan)) !!}</div>
                @else
                    <p class="text-muted">-</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="detail-card">
            <div class="detail-card-header">
                <h5>Status</h5>
            </div>
            <div class="detail-card-body">
                <table class="info-table">
                    <tr>
                        <th>Dibuat</th>
                        <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Diupdate</th>
                        <td>{{ $report->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
