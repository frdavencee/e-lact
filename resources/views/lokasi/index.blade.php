@extends('layouts.app')

@section('title', 'Daftar Lokasi')

@section('content')
<div class="page-header-modern">
    <h2>Data Lokasi</h2>
    <a href="{{ route('lokasi.create') }}" class="btn-primary-gradient">
        <i class="bi bi-plus-lg"></i> Tambah Lokasi
    </a>
</div>

<div class="filter-card">
    <div class="card-body">
        <form method="GET" action="{{ route('lokasi.index') }}" class="row g-3">
            <div class="col-md-3">
                <select name="status" class="form-select-soft">
                    <option value="">Semua Status</option>
                    <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum Diisi</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="siap" {{ request('status') == 'siap' ? 'selected' : '' }}>Siap Generate</option>
                    <option value="generated" {{ request('status') == 'generated' ? 'selected' : '' }}>Sudah Generate</option>
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" name="search" class="form-control-soft" placeholder="Cari kode / nama lokasi..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn-primary-gradient w-100">
                    <i class="bi bi-funnel"></i> Filter
                </button>
            </div>
            @if(request('search') || request('status'))
            <div class="col-md-1">
                <a href="{{ route('lokasi.index') }}" class="btn-soft-secondary w-100">Reset</a>
            </div>
            @endif
        </form>
    </div>
</div>

<div class="data-table-wrapper">
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Lokasi</th>
                    <th>Branch</th>
                    <th>Proyek</th>
                    <th>Status</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lokasiList as $lokasi)
                <tr>
                    <td><strong class="input-mono" style="font-size:0.85rem;">{{ $lokasi->code }}</strong></td>
                    <td>{{ $lokasi->name }}</td>
                    <td>{{ $lokasi->branch->name ?? '-' }}</td>
                    <td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                        {{ $lokasi->project->name ?? '-' }}
                    </td>
                    <td>
                        @php
                            $badgeClass = match($lokasi->status) {
                                'belum' => 'badge-secondary',
                                'draft' => 'badge-warning',
                                'siap' => 'badge-info',
                                'generated' => 'badge-success',
                                default => 'badge-secondary'
                            };
                        @endphp
                        <span class="badge-modern {{ $badgeClass }}">{{ ucfirst($lokasi->status) }}</span>
                    </td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('lokasi.show', $lokasi) }}" class="action-icon-btn btn-view" title="Detail"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('lokasi.edit', $lokasi) }}" class="action-icon-btn btn-edit" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('lokasi.destroy', $lokasi) }}" method="POST" onsubmit="return confirm('Hapus lokasi ini?')" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="action-icon-btn btn-delete" type="submit" title="Hapus"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="bi bi-folder2-open"></i>
                            <p>Tidak ada data lokasi</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($lokasiList->hasPages())
<div class="pagination-soft">
    {{ $lokasiList->links() }}
</div>
@endif
@endsection
