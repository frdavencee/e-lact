@extends('layouts.app')

@section('title', 'Approval')

@section('content')
<div class="page-header">
    <h2>Approval Management</h2>
</div>

<div class="filter-section">
    <form method="GET" action="{{ route('approvals.index') }}" class="row g-3">
        <div class="col-md-3">
            <select name="status" class="form-select-soft">
                <option value="">Semua Status</option>
                <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Menunggu Review</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn-primary-gradient w-100">
                <i class="bi bi-funnel"></i> Filter
            </button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('approvals.index') }}" class="btn-soft-secondary w-100">
                <i class="bi bi-arrow-counterclockwise"></i> Reset
            </a>
        </div>
    </form>
</div>

<div class="data-table-wrapper">
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Nama Proyek</th>
                    <th>Pemohon</th>
                    <th>Status</th>
                    <th>Tanggal Submit</th>
                    <th>Reviewer</th>
                    <th>Catatan</th>
                    <th width="200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($approvals as $approval)
                <tr>
                    <td><strong>{{ $approval->project->nama_proyek ?? 'Project #' . $approval->project_id }}</strong></td>
                    <td>{{ $approval->requester->name ?? '-' }}</td>
                    <td>
                        @php
                            $badgeClass = match($approval->status) {
                                'submitted' => 'badge-warning',
                                'approved' => 'badge-success',
                                'rejected' => 'badge-danger',
                                default => 'badge-secondary'
                            };
                            $label = match($approval->status) {
                                'submitted' => 'Menunggu Review',
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                                default => ucfirst($approval->status)
                            };
                        @endphp
                        <span class="badge-modern {{ $badgeClass }}">{{ $label }}</span>
                    </td>
                    <td>{{ $approval->submitted_at?->format('d M Y H:i') ?? '-' }}</td>
                    <td>{{ $approval->reviewer->name ?? '-' }}</td>
                    <td>{{ $approval->notes ?? '-' }}</td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('approvals.show', $approval) }}" class="action-icon-btn btn-view" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if($approval->status === 'submitted' && Auth::user()->hasRole('waspang'))
                            <a href="{{ route('approvals.show', $approval) }}?action=approve" class="action-icon-btn btn-edit" title="Approve" style="color: #10b981;">
                                <i class="bi bi-check-lg"></i>
                            </a>
                            <a href="{{ route('approvals.show', $approval) }}?action=reject" class="action-icon-btn btn-delete" title="Reject" style="color: #ef4444;">
                                <i class="bi bi-x-lg"></i>
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="bi bi-folder2-open"></i>
                            <p>Tidak ada data approval</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($approvals->hasPages())
<div class="pagination-soft">
    {{ $approvals->links() }}
</div>
@endif
@endsection
