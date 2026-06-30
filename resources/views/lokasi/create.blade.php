@extends('layouts.app')

@section('title', 'Tambah Lokasi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="detail-card">
            <div class="detail-card-header">
                <h5>Tambah Lokasi Baru</h5>
            </div>
            <div class="detail-card-body">
                <form method="POST" action="{{ route('lokasi.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label-soft">Branch</label>
                            <select name="branch_id" id="branchSelect" class="form-select-soft">
                                <option value="">-- Pilih Branch --</option>
                                @foreach($branchList as $b)
                                <option value="{{ $b->id }}" {{ old('branch_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-soft">Kode Lokasi <span class="text-danger">*</span></label>
                            <select name="kode_lokasi" id="kodeLokasiSelect" class="form-select-soft" required>
                                <option value="">-- Pilih Kode Lokasi --</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-soft">Nama Lokasi <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lokasi" id="namaLokasiInput" class="form-control-soft" required value="{{ old('nama_lokasi') }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label-soft">Status</label>
                            <select name="status" class="form-select-soft">
                                @foreach(['belum','draft','siap','generated'] as $st)
                                <option value="{{ $st }}" {{ old('status', 'belum') == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('lokasi.index') }}" class="btn-soft-secondary">Batal</a>
                        <button type="submit" class="btn-primary-gradient">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const branchData = {!! json_encode($branchData) !!};

document.getElementById('branchSelect').addEventListener('change', function () {
    const bid = this.value;
    const kodeSelect = document.getElementById('kodeLokasiSelect');
    kodeSelect.innerHTML = '<option value="">-- Pilih Kode Lokasi --</option>';
    document.getElementById('namaLokasiInput').value = '';

    if (bid && branchData[bid]) {
        branchData[bid].forEach(lok => {
            const opt = document.createElement('option');
            opt.value = lok.code;
            opt.textContent = lok.code;
            opt.dataset.name = lok.name;
            kodeSelect.appendChild(opt);
        });
    }
});

document.getElementById('kodeLokasiSelect').addEventListener('change', function () {
    const opt = this.options[this.selectedIndex];
    document.getElementById('namaLokasiInput').value = opt.dataset.name || '';
});
</script>
@endpush
