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
            <div class="col-md-3">
                <input type="text" name="search" class="form-control-soft" placeholder="Cari..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn-primary-gradient w-100">
                    <i class="bi bi-funnel"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="data-table-wrapper">
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Kode Lokasi</th>
                    <th>Nama Lokasi</th>
                    <th>Status</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lokasiList as $lokasi)
                <tr>
                    <td><strong style="color: #1f2937;">{{ $lokasi->code }}</strong></td>
                    <td>{{ $lokasi->name }}</td>
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
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">
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
