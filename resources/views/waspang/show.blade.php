@extends('layouts.app')

@section('title', 'Detail Waspang')

@section('content')
<div class="detail-header">
    <h2>Detail Personel</h2>
    <a href="{{ route('waspang.edit', $personel) }}" class="btn-soft-secondary"><i class="bi bi-pencil"></i> Edit</a>
</div>

<div class="detail-card mb-4">
    <div class="detail-card-body">
        <table class="info-table">
            <tr><th>Nama</th><td>{{ $personel->nama }}</td></tr>
            <tr><th>NIK</th><td>{{ $personel->nik ?? '-' }}</td></tr>
            <tr><th>Jabatan</th><td>{{ $personel->jabatan ?? '-' }}</td></tr>
        </table>
    </div>
</div>

@if($personel->commissioningTests->count() > 0)
<div class="data-table-wrapper">
    <div class="card-body" style="padding: 0;">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Lokasi</th>
                    <th>Tanggal</th>
                    <th>Kota TTD</th>
                </tr>
            </thead>
            <tbody>
                @foreach($personel->commissioningTests as $ct)
                <tr>
                    <td>{{ $ct->lokasi->code ?? '-' }}</td>
                    <td>{{ $ct->tanggal ? $ct->tanggal->format('d/m/Y') : '-' }}</td>
                    <td>{{ $ct->kota_ttd }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection