@extends('layouts.app')

@section('title', 'Review Approval')

@section('content')
<div class="page-header">
    <h2>Review Approval</h2>
</div>

<div class="detail-card mb-4">
    <div class="detail-card-header">
        <h5>Informasi Approval</h5>
    </div>
    <div class="detail-card-body">
        <table class="info-table">
            <tr><th>Nama Proyek</th><td>{{ $approval->project->nama_proyek ?? 'Project #' . $approval->project_id }}</td></tr>
            <tr><th>Pemohon</th><td>{{ $approval->requester->name ?? '-' }}</td></tr>
            <tr><th>Tanggal Submit</th><td>{{ $approval->submitted_at?->format('d M Y H:i') ?? '-' }}</td></tr>
            <tr><th>Status</th>
                <td>
                    @php
                        $badgeClass = match($approval->status) {
                            'submitted' => 'badge-warning',
                            'approved' => 'badge-success',
                            'rejected' => 'badge-danger',
                            default => 'badge-secondary'
                        };
                    @endphp
                    <span class="badge-modern {{ $badgeClass }}">{{ ucfirst($approval->status) }}</span>
                </td>
            </tr>
            <tr><th>Catatan</th><td>{{ $approval->notes ?? '-' }}</td></tr>
        </table>
    </div>
</div>

@if($approval->status === 'submitted' && Auth::user()->hasRole('waspang'))
<div class="detail-card">
    <div class="detail-card-header">
        <h5>Tindakan Waspang</h5>
    </div>
    <div class="detail-card-body">
        <form id="approvalForm" method="POST" action="">
            @csrf

            <div class="mb-3">
                <label class="form-label-soft">Catatan Review <span class="text-danger">*</span></label>
                <textarea name="notes" class="form-control-soft" rows="4" required placeholder="Berikan catatan untuk staff..."></textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="button" onclick="submitAction('approve')" class="btn-primary-gradient" style="background: #10b981;">
                    <i class="bi bi-check-lg"></i> Approve
                </button>
                <button type="button" onclick="submitAction('reject')" class="btn-soft-secondary" style="background: #ef4444; color: #fff;">
                    <i class="bi bi-x-lg"></i> Reject
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function submitAction(action) {
        const form = document.getElementById('approvalForm');
        const url = action === 'approve'
            ? '{{ route('approvals.approve', $approval) }}'
            : '{{ route('approvals.reject', $approval) }}';
        form.action = url;
        form.submit();
    }
</script>
@endif

<a href="{{ route('approvals.index') }}" class="btn-soft-secondary mt-3">
    <i class="bi bi-arrow-left"></i> Kembali ke Daftar
</a>
@endsection
