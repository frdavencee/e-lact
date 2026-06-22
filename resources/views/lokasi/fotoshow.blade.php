@extends('layouts.app')

@section('title', 'Foto Lampiran - ' . $lokasi->code)

@section('content')
<div class="detail-header">
    <h2>Foto Lampiran - {{ $lokasi->code }} - {{ $lokasi->name }}</h2>
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

<div class="detail-card">
    <div class="detail-card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <select id="evidence_category" class="form-control-soft">
                    <option value="penarikan_kabel">Penarikan Kabel</option>
                    <option value="instalasi_aksesoris">Instalasi Aksesoris</option>
                    <option value="closure">Closure</option>
                    <option value="penyambungan_odp">Penyambungan ODP</option>
                    <option value="marking_kabel">Marking Kabel</option>
                    <option value="odp">ODP</option>
                    <option value="pu_as_hl">PU-AS-HL</option>
                    <option value="pu_as_sc">PU-AS-SC</option>
                    <option value="splitter">Splitter</option>
                    <option value="opm">OPM</option>
                    <option value="otdr">OTDR</option>
                    <option value="mancore">Mancore</option>
                    <option value="as_build_drawing">As Build Drawing</option>
                </select>
            </div>
            <div class="col-md-6">
                <input type="file" id="photo-upload" accept="image/*" style="display:none" onchange="uploadPhoto(this)">
                <button type="button" class="btn-primary-gradient w-100" onclick="document.getElementById('photo-upload').click()">Upload Foto</button>
            </div>
        </div>
        <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1rem;">Total: <strong>{{ $fotos->count() }}</strong> foto</div>
        <div class="photo-grid-modern">
            @foreach($fotos as $photo)
            <div class="photo-tile-modern filled">
                <img src="{{ asset('storage/' . $photo->file_path) }}" alt="{{ $photo->label }}">
                <div class="photo-overlay-modern">
                    <input type="text" class="photo-label-input" value="{{ $photo->label }}" onchange="updatePhotoLabel({{ $photo->id }}, this.value)">
                </div>
                <button type="button" onclick="removePhoto({{ $photo->id }})" class="photo-remove-btn">×</button>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function uploadPhoto(input) {
        if (input.files && input.files[0]) {
            const formData = new FormData();
            formData.append('file', input.files[0]);
            formData.append('kategori', document.getElementById('evidence_category').value);
            formData.append('label', input.files[0].name);
            formData.append('_token', '{{ csrf_token() }}');
            
            const lokasiId = '{{ $lokasi->id }}';
            fetch('/lokasi/' + lokasiId + '/foto', { method: 'POST', body: formData })
                .then(r => r.json())
                .then(data => {
                    if (data.success) location.reload();
                    else alert('Gagal upload foto');
                });
        }
    }

    function removePhoto(id) {
        if (confirm('Hapus foto ini?')) {
            const lokasiId = '{{ $lokasi->id }}';
            fetch('/lokasi/' + lokasiId + '/foto/' + id, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            }).then(() => location.reload());
        }
    }

    function updatePhotoLabel(id, label) {
        const lokasiId = '{{ $lokasi->id }}';
        fetch('/lokasi/' + lokasiId + '/foto/' + id + '/label', {
            method: 'PUT',
            headers: { 
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ label })
        }).then(r => r.json()).then(data => {
            if (data.success) alert('Label berhasil diperbarui');
        });
    }
</script>
@endsection
