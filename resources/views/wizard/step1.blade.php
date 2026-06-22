@extends('layouts.app')

@section('title', 'Buat Project Baru - Step 1')

@section('content')
<div class="container">
    <h3>Buat Project LACT Baru</h3>

    <div class="mb-4">
        <div class="progress" style="height: 25px;">
            <div class="progress-bar bg-success" role="progressbar" style="width: 12.5%;">Step 1/8</div>
        </div>
        <div class="d-flex justify-content-between mt-1 small text-muted">
            <span>Data Project</span>
            <span>Commissioning</span>
            <span>BOQ</span>
            <span>Evidence</span>
            <span>Marking</span>
            <span>OPM</span>
            <span>OTDR</span>
            <span>Mancore</span>
        </div>
    </div>

    <form method="POST" action="{{ route('wizard.step1.submit') }}">
        @csrf
        <div class="card mb-3">
            <div class="card-header bg-white fw-bold">Informasi Project</div>
            <div class="card-body">
                <div class="mb-3">
                    <label>Nama Project <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required value="{{ old('name', $data['name'] ?? '') }}" placeholder="Contoh: SP#17 Pengadaan dan Pemasangan OSP FTTH">
                </div>
                <div class="mb-3">
                    <label>Nomor Kontrak</label>
                    <input type="text" name="contract_number" class="form-control" value="{{ old('contract_number', $data['contract_number'] ?? '') }}" placeholder="Contoh: K.TEL.034/HK.810/JIFC-000000/2024">
                </div>
                <div class="mb-3">
                    <label>Nomor Surat Pesanan</label>
                    <input type="text" name="purchase_order_number" class="form-control" value="{{ old('purchase_order_number', $data['purchase_order_number'] ?? '') }}" placeholder="Contoh: K.TEL.093/HK.810/JIFC-0000000/2026">
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header bg-white fw-bold">Lokasi</div>
            <div class="card-body">
                <div class="mb-3">
                    <label>Branch <span class="text-danger">*</span></label>
                    <select name="branch_id" class="form-select" required id="branchSelect">
                        <option value="">-- Pilih Branch --</option>
                        @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ (old('branch_id', $data['branch_id'] ?? '') == $branch->id) ? 'selected' : '' }}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Lokasi <span class="text-danger">*</span></label>
                    <select name="location_id" class="form-select" required id="locationSelect">
                        <option value="">-- Pilih Lokasi --</option>
                        @foreach($lokasiList as $lokasi)
                        <option value="{{ $lokasi->id }}" data-branch="{{ $lokasi->branch_id }}" {{ (old('location_id', $data['location_id'] ?? '') == $lokasi->id) ? 'selected' : '' }}>{{ $lokasi->name }} ({{ $lokasi->code }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header bg-white fw-bold">Pelaksana</div>
            <div class="card-body">
                <div class="mb-3">
                    <label>Nama Perusahaan Pelaksana</label>
                    <input type="text" name="implementer" class="form-control" value="{{ old('implementer', $data['implementer'] ?? 'PT TELKOM AKSES') }}" placeholder="PT TELKOM AKSES">
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Selanjutnya <i class="bi bi-arrow-right"></i></button>
        </div>
    </form>
</div>

<script>
document.getElementById('branchSelect')?.addEventListener('change', function() {
    const branchId = this.value;
    const locationSelect = document.getElementById('locationSelect');
    Array.from(locationSelect.options).forEach(opt => {
        if (!opt.value) return;
        opt.hidden = branchId ? opt.dataset.branch != branchId : false;
    });
    if (branchId) {
        const first = Array.from(locationSelect.options).find(o => !o.hidden && o.value);
        if (first) locationSelect.value = first.value;
    }
});
</script>
@endsection
