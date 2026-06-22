@extends('layouts.app')

@section('title', 'Daftar BOQ')

@section('content')
<div class="detail-header">
    <h2>Bill of Quantity (BOQ)</h2>
    <div class="d-flex gap-2">
        <a href="{{ route('boq.create') }}" class="btn-primary-gradient">
            <i class="bi bi-plus-circle"></i> Tambah Item BOQ
        </a>
        <a href="{{ route('projects.index') }}" class="btn-soft-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-white">
        <h5 class="mb-0">Filter BOQ</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('boq.index') }}" class="row g-3">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Cari nama material / kode item..." value="{{ old('search', request()->get('search')) }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Cari</button>
            </div>
            <div class="col-md-3">
                <a href="{{ route('boq.index') }}" class="btn btn-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($items->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Kode Item</th>
                        <th>Nama Material</th>
                        <th width="100">Volume</th>
                        <th width="100">Satuan</th>
                        <th>Lokasi</th>
                        <th>Proyek</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $index => $item)
                    <tr>
                        <td>{{ $items->firstItem() + $index }}</td>
                        <td>{{ $item->item_code ?? '-' }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->volume }}</td>
                        <td>{{ $item->unit ?? '-' }}</td>
                        <td>{{ $item->lokasi->name ?? '-' }}</td>
                        <td>{{ $item->project->name ?? '-' }}</td>
                        <td>{{ $item->notes ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $items->links() }}
        </div>
        @else
        <div class="empty-state">
            <i class="bi bi-list-check"></i>
            <p>Belum ada data BOQ.</p>
        </div>
        @endif
    </div>
</div>
@endsection
