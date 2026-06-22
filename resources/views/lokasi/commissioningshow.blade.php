@extends('layouts.app')

@section('title', 'Commissioning Test - ' . $lokasi->code)

@section('content')
<div class="detail-header">
    <h2>Commissioning Test - {{ $lokasi->code }} - {{ $lokasi->name }}</h2>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('lokasi.index') }}" class="btn-soft-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>
</div>

<div class="detail-card mb-4">
    <div class="detail-card-body">
        <table class="info-table">
            <tr><th>Kode Lokasi</th><td>{{ $lokasi->code }}</td></tr>
            <tr><th>Nama Lokasi</th><td>{{ $lokasi->name }}</td></tr>
            <tr><th>Branch</th><td>{{ $lokasi->branch->name ?? '-' }}</td></tr>
            <tr><th>Status</th><td>{{ ucfirst($lokasi->status) }}</td></tr>
        </table>
    </div>
</div>

@if($ct)
    <div class="detail-card">
        <div class="detail-card-header">
            <h5>Data Commissioning Test</h5>
        </div>
        <div class="detail-card-body">
            <form method="POST" action="{{ route('commissioning-test.update', $lokasi) }}">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label-soft">WASPANG</label>
                        <select name="personel_id" class="form-select-soft" required>
                            <option value="">-- Pilih --</option>
                            @foreach($personelList as $p)
                            <option value="{{ $p->id }}" {{ old('personel_id', $ct->personel_id ?? '') == $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ $p->nik }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label-soft">Tanggal Commissioning</label>
                        <input type="date" name="tanggal" class="form-control-soft" required value="{{ old('tanggal', $ct->tanggal ?? '') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label-soft">Kota TTD</label>
                        <input type="text" name="kota_ttd" class="form-control-soft" required value="{{ old('kota_ttd', $ct->kota_ttd ?? '') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label-soft">Status Pekerjaan</label>
                        <div>
                            <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="status_pekerjaan" value="telah" {{ old('status_pekerjaan', $ct->status_pekerjaan ?? '') == 'telah' ? 'checked' : '' }} required><label class="form-check-label">Telah</label></div>
                            <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="status_pekerjaan" value="belum" {{ old('status_pekerjaan', $ct->status_pekerjaan ?? '') == 'belum' ? 'checked' : '' }}><label class="form-check-label">Belum</label></div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label-soft">Hasil Pekerjaan</label>
                        <div>
                            <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="status_hasil" value="dapat" {{ old('status_hasil', $ct->status_hasil ?? '') == 'dapat' ? 'checked' : '' }} required><label class="form-check-label">Dapat</label></div>
                            <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="status_hasil" value="tidak_dapat" {{ old('status_hasil', $ct->status_hasil ?? '') == 'tidak_dapat' ? 'checked' : '' }}><label class="form-check-label">Tidak Dapat</label></div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label-soft">Kelayakan UT</label>
                        <div>
                            <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="status_kelayakan" value="layak" {{ old('status_kelayakan', $ct->status_kelayakan ?? '') == 'layak' ? 'checked' : '' }} required><label class="form-check-label">Layak</label></div>
                            <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="status_kelayakan" value="tidak_layak" {{ old('status_kelayakan', $ct->status_kelayakan ?? '') == 'tidak_layak' ? 'checked' : '' }}><label class="form-check-label">Tidak Layak</label></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn-primary-gradient">Update Commissioning Test</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@else
    <div class="detail-card">
        <div class="detail-card-body">
            <form method="POST" action="{{ route('commissioning-test.store', $lokasi) }}">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label-soft">WASPANG</label>
                        <select name="personel_id" class="form-select-soft" required>
                            <option value="">-- Pilih --</option>
                            @foreach($personelList as $p)
                            <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->nik }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label-soft">Tanggal Commissioning</label>
                        <input type="date" name="tanggal" class="form-control-soft" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label-soft">Kota TTD</label>
                        <input type="text" name="kota_ttd" class="form-control-soft" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label-soft">Status Pekerjaan</label>
                        <div>
                            <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="status_pekerjaan" value="telah" required><label class="form-check-label">Telah</label></div>
                            <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="status_pekerjaan" value="belum"><label class="form-check-label">Belum</label></div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label-soft">Hasil Pekerjaan</label>
                        <div>
                            <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="status_hasil" value="dapat" required><label class="form-check-label">Dapat</label></div>
                            <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="status_hasil" value="tidak_dapat"><label class="form-check-label">Tidak Dapat</label></div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label-soft">Kelayakan UT</label>
                        <div>
                            <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="status_kelayakan" value="layak" required><label class="form-check-label">Layak</label></div>
                            <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="status_kelayakan" value="tidak_layak"><label class="form-check-label">Tidak Layak</label></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn-primary-gradient">Simpan Commissioning Test</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endif
@endsection
