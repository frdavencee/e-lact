@extends('layouts.app')

@section('title', 'Daftar Waspang')

@section('content')
<div class="page-header-modern">
    <h2>Master Personel</h2>
    <a href="{{ route('waspang.create') }}" class="btn-primary-gradient">
        <i class="bi bi-plus-lg"></i> Tambah Waspang
    </a>
</div>

<div class="data-table-wrapper">
    <div class="card-body" style="padding: 1.25rem;">
        <form method="GET" action="{{ route('waspang.index') }}" class="row g-3 mb-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control-soft" placeholder="Cari nama atau NIK..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn-primary-gradient w-100">
                    <i class="bi bi-funnel"></i> Cari
                </button>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Jabatan</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($personelList as $p)
                <tr>
                    <td>{{ $p->nama }}</td>
                    <td>{{ $p->nik ?? '-' }}</td>
                    <td>{{ $p->jabatan ?? '-' }}</td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('waspang.edit', $p) }}" class="action-icon-btn btn-edit" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('waspang.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="action-icon-btn btn-delete" title="Hapus"><i class="bi bi-trash"></i></button></form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <i class="bi bi-person-x"></i>
                            <p>Belum ada data waspang</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($personelList->hasPages())
<div class="pagination-soft">
    {{ $personelList->links() }}
</div>
@endif
@endsection