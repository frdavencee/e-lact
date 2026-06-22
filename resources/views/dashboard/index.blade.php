@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card-modern">
        <div class="stat-icon-box" style="background: #dbeafe; color: #3b82f6;">
            <i class="bi bi-folder-fill"></i>
        </div>
        <div class="stat-value">{{ $totalLokasi }}</div>
        <div class="stat-label">Total Lokasi</div>
    </div>
    <div class="stat-card-modern">
        <div class="stat-icon-box" style="background: #fef3c7; color: #d97706;">
            <i class="bi bi-clock-fill"></i>
        </div>
        <div class="stat-value">{{ $totalBelum }}</div>
        <div class="stat-label">Belum Dikerjakan</div>
    </div>
    <div class="stat-card-modern">
        <div class="stat-icon-box" style="background: #d1fae5; color: #059669;">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <div class="stat-value">{{ $totalSiap }}</div>
        <div class="stat-label">Siap Generate</div>
    </div>
    <div class="stat-card-modern">
        <div class="stat-icon-box" style="background: #fee2e2; color: #ef4444;">
            <i class="bi bi-file-earmark-word-fill"></i>
        </div>
        <div class="stat-value">{{ $totalGenerated }}</div>
        <div class="stat-label">Sudah Generated</div>
    </div>
</div>

<div class="chart-section">
    <div class="detail-card">
        <div class="detail-card-header">
            <h5>Grafik Proyek per Bulan</h5>
        </div>
        <div class="detail-card-body">
            <canvas id="projectChart" height="80"></canvas>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="detail-card">
            <div class="detail-card-header">
                <h5>Approval Terbaru</h5>
            </div>
            <div class="detail-card-body">
                @forelse($recentApprovals as $approval)
                <div class="list-item">
                    <div>
                        <strong>{{ $approval->project->nama_proyek ?? 'Project #'.$approval->project_id }}</strong>
                        <br><small class="text-muted">{{ $approval->requester->name ?? '-' }} - {{ $approval->submitted_at?->diffForHumans() }}</small>
                    </div>
                    <span class="badge-modern {{ match($approval->status) { 'submitted' => 'badge-warning', 'approved' => 'badge-success', 'rejected' => 'badge-danger', default => 'badge-secondary' } }}">
                        {{ match($approval->status) { 'submitted' => 'Menunggu', 'approved' => 'Disetujui', 'rejected' => 'Ditolak', default => ucfirst($approval->status) } }}
                    </span>
                </div>
                @empty
                <p class="text-muted">Tidak ada approval</p>
                @endforelse
            </div>
        </div>
    </div>

    @if($myPendingApprovals->count() > 0)
    <div class="col-md-6">
        <div class="detail-card">
            <div class="detail-card-header">
                <h5>Menunggu Review Saya (Waspang)</h5>
            </div>
            <div class="detail-card-body">
                @forelse($myPendingApprovals as $approval)
                <div class="list-item">
                    <div>
                        <strong>{{ $approval->project->nama_proyek ?? 'Project #'.$approval->project_id }}</strong>
                        <br><small class="text-muted">Oleh: {{ $approval->requester->name ?? '-' }}</small>
                    </div>
                    <a href="{{ route('approvals.show', $approval) }}" class="btn-primary-gradient btn-sm">Review</a>
                </div>
                @empty
                <p class="text-muted">Tidak ada</p>
                @endforelse
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('projectChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Jumlah Proyek',
                data: {!! json_encode($chartData) !!},
                backgroundColor: 'rgba(227, 0, 15, 0.8)',
                borderColor: 'rgba(227, 0, 15, 1)',
                borderWidth: 1,
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            },
            plugins: { legend: { display: false } }
        }
    });
</script>
@endsection
