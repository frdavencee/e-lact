@extends('layouts.app')

@section('title', 'OTDR - ' . $lokasi->code)

@section('content')
<div class="detail-header">
    <h2>OTDR - {{ $lokasi->code }} - {{ $lokasi->name }}</h2>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('lokasi.index') }}" class="btn-soft-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
        <input type="file" id="otdr-upload" style="display:none" onchange="uploadOtdr(this)">
        <button type="button" class="btn-soft-secondary" onclick="document.getElementById('otdr-upload').click()"><i class="bi bi-upload"></i> Upload OTDR</button>
    </div>
</div>

<div class="detail-card mb-4">
    <div class="detail-card-body">
        <table class="info-table">
            <tr><th>Kode Lokasi</th><td>{{ $lokasi->code }}</td></tr>
            <tr><th>Nama Lokasi</th><td>{{ $lokasi->name }}</td></tr>
            <tr><th>Branch</th><td>{{ $lokasi->branch->name ?? '-' }}</td></tr>
            <tr><th>Status</th><td>{{ ucfirst($lokasi->status) }}</td></tr>
            <tr><th>Total File OTDR</th><td>{{ $otdrFiles->count() }} file</td></tr>
        </table>
    </div>
</div>

<div class="detail-card">
    <div class="detail-card-body">
        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr><th>Nama File</th><th>Tipe</th><th>Ukuran</th><th width="80"></th></tr>
                </thead>
                <tbody>
                    @foreach($otdrFiles as $otdr)
                    <tr>
                        <td>{{ $otdr->original_name }}</td>
                        <td><span class="badge-modern-sm" style="background: #f3f4f6; color: #4b5563;">{{ strtoupper(pathinfo($otdr->original_name, PATHINFO_EXTENSION)) }}</span></td>
                        <td>{{ number_format($otdr->size / 1024, 2) }} KB</td>
                        <td><button type="button" class="btn-danger-sm" onclick="removeOtdr({{ $otdr->id }})">×</button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function uploadOtdr(input) {
        if (input.files && input.files[0]) {
            const formData = new FormData();
            formData.append('file', input.files[0]);
            formData.append('_token', '{{ csrf_token() }}');
            
            const lokasiId = '{{ $lokasi->id }}';
            fetch(`/lokasi/${lokasiId}/otdr`, { method: 'POST', body: formData })
                .then(r => r.json())
                .then(data => {
                    if (data.success) location.reload();
                    else alert('Gagal upload OTDR');
                });
        }
    }

    function removeOtdr(id) {
        if (confirm('Hapus file OTDR ini?')) {
            const lokasiId = '{{ $lokasi->id }}';
            fetch(`/lokasi/${lokasiId}/otdr/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            }).then(() => location.reload());
        }
    }
</script>
@endsection
