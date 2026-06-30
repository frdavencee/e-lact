@extends('layouts.app')

@section('title', 'Manajemen Branch')

@section('content')
<div class="detail-header">
    <h2>Manajemen Branch</h2>
</div>

{{-- Create Form --}}
<div class="detail-card mb-4">
    <div class="detail-card-header"><h5>Tambah Branch Baru</h5></div>
    <div class="detail-card-body">
        <form method="POST" action="{{ route('branch.store') }}" class="row g-3">
            @csrf
            <div class="col-md-5">
                <label class="form-label-soft">Nama Branch</label>
                <input type="text" name="name" class="form-control-soft" value="{{ old('name') }}" placeholder="Branch Semarang" required>
                @error('name')<p style="color:#dc2626;font-size:0.8rem;margin-top:0.25rem;">{{ $message }}</p>@enderror
            </div>
            <div class="col-md-3">
                <label class="form-label-soft">Kode Lokasi</label>
                <input type="text" name="code" class="form-control-soft input-mono" value="{{ old('code') }}" placeholder="SMG" required>
                @error('code')<p style="color:#dc2626;font-size:0.8rem;margin-top:0.25rem;">{{ $message }}</p>@enderror
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn-primary-gradient w-100"><i class="bi bi-plus"></i> Tambah</button>
            </div>
        </form>
    </div>
</div>

{{-- Branch List --}}
<div class="detail-card">
    <div class="detail-card-header">
        <h5>Daftar Branch</h5>
        <span class="badge-modern badge-info">{{ $branches->total() }} branch</span>
    </div>
    <div class="detail-card-body" style="padding:0;">
        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th width="60">#</th>
                        <th>Nama Branch</th>
                        <th width="80">Kode</th>
                        <th>Lokasi</th>
                        <th>Kode Lokasi</th>
                        <th width="80">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($branches as $i => $branch)
                    <tr>
                        <td>{{ $branches->firstItem() + $i }}</td>
                        <td><strong>{{ $branch->name }}</strong></td>
                        <td><span class="badge-modern-sm" style="background:#dbeafe;color:#1e40af;font-family:monospace;">{{ $branch->code }}</span></td>
                        <td>
                            @forelse($branch->lokasi as $lok)
                            <div style="font-size:0.82rem;margin-bottom:2px;">{{ $lok->name }}</div>
                            @empty
                            <span style="color:#9ca3af;font-size:0.82rem;">-</span>
                            @endforelse
                        </td>
                        <td>
                            @forelse($branch->lokasi as $lok)
                            <div style="margin-bottom:2px;">
                                <span class="badge-modern-sm" style="background:#f3f4f6;color:#374151;font-family:monospace;font-size:0.72rem;">{{ $lok->code }}</span>
                            </div>
                            @empty
                            <span style="color:#9ca3af;font-size:0.82rem;">-</span>
                            @endforelse
                        </td>
                        <td>
                            <div class="action-group">
                                <button class="action-icon-btn btn-edit" title="Edit" onclick="openEditModal({{ $branch->id }}, '{{ addslashes($branch->name) }}', '{{ addslashes($branch->code) }}')">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('branch.destroy', $branch) }}" method="POST" onsubmit="return confirm('Hapus branch ini?')" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button class="action-icon-btn btn-delete" type="submit" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state"><i class="bi bi-diagram-3"></i><p>Belum ada data branch.</p></div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($branches->hasPages())
        <div style="padding:1rem 1.5rem;">
            {{ $branches->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:12px;border:1px solid #e5e7eb;">
            <div class="modal-header" style="border-bottom:1px solid #e5e7eb;padding:1.25rem 1.5rem;">
                <h5 class="modal-title" style="font-weight:600;">Edit Branch</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-body" style="padding:1.5rem;">
                    <div class="mb-3">
                        <label class="form-label-soft">Nama Branch</label>
                        <input type="text" name="name" id="editName" class="form-control-soft" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-soft">Kode Lokasi</label>
                        <input type="text" name="code" id="editCode" class="form-control-soft input-mono" required>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid #e5e7eb;padding:1rem 1.5rem;">
                    <button type="button" class="btn-soft-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-primary-gradient">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openEditModal(id, name, code) {
    document.getElementById('editForm').action = '/branch/' + id;
    document.getElementById('editName').value = name;
    document.getElementById('editCode').value = code;
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>
@endpush
