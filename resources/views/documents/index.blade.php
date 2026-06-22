@extends('layouts.app')

@section('title', 'Dokumen LACT')

@section('content')
<div class="page-header-modern">
    <h2>Dokumen LACT Tergenerate</h2>
</div>

<div class="data-table-wrapper">
    <div class="table-responsive p-3">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Lokasi</th>
                    <th>Kode</th>
                    <th>Versi</th>
                    <th>Di-generate oleh</th>
                    <th>Tanggal Generate</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $doc)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $doc->lokasi->name ?? '-' }}</td>
                    <td><span class="badge-modern-sm" style="background:#f3f4f6;color:#4b5563;">{{ $doc->lokasi->code ?? '-' }}</span></td>
                    <td><span class="badge-modern badge-info">v{{ $doc->versi }}</span></td>
                    <td>{{ $doc->generated_by }}</td>
                    <td>{{ $doc->generated_at ? $doc->generated_at->format('d/m/Y H:i') : '-' }}</td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('documents.show', $doc) }}" class="action-icon-btn btn-view" title="Download">
                                <i class="bi bi-download"></i>
                            </a>
                            <form action="{{ route('documents.destroy', $doc) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus dokumen ini?')">
                                @csrf @method('DELETE')
                                <button class="action-icon-btn btn-delete" title="Hapus"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="bi bi-file-earmark-word"></i>
                            <p>Belum ada dokumen LACT yang digenerate.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-3 pb-3">
        {{ $documents->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
