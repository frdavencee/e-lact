{{-- Form tambah per entri: Jenis Kabel (opsional) + Foto + Panjang Kabel --}}
<form method="POST" action="{{ route('marking-kabel.store', $lokasi) }}" enctype="multipart/form-data"
    class="row g-2 mb-4 p-3" style="background:#f9fafb;border:1px dashed #d1d5db;border-radius:8px;">
    @csrf
    <div class="col-md-4">
        <label class="form-label-soft">Jenis Kabel <span style="color:#9ca3af;font-size:0.72rem;">(opsional)</span></label>
        <input type="text" name="jenis_kabel" class="form-control-soft" placeholder="Contoh: Kabel Drop 2 Core">
    </div>
    <div class="col-md-4">
        <label class="form-label-soft">Foto</label>
        <input type="file" name="foto" class="form-control-soft" accept="image/*">
    </div>
    <div class="col-md-2">
        <label class="form-label-soft">Panjang (m) <span class="text-danger">*</span></label>
        <input type="number" step="0.01" name="panjang_meter" class="form-control-soft input-mono" required>
    </div>
    <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn-primary-gradient w-100"><i class="bi bi-plus"></i> Tambah</button>
    </div>
</form>

{{-- List entri --}}
@php
$mkFotos = $lokasi->fotoLampiran->filter(fn($f) => $f->kategori === 'marking_kabel');
@endphp

@if($lokasi->markingKabel->isEmpty())
<div class="empty-state" style="padding:1.5rem 0;">
    <i class="bi bi-scissors"></i>
    <p>Belum ada data marking kabel.</p>
</div>
@else
<div class="row g-3">
    @foreach($lokasi->markingKabel as $mk)
    @php $mkFoto = $mkFotos->firstWhere('label', $mk->jenis_kabel); @endphp
    <div class="col-6 col-md-4">
        <div style="border:1px solid #e5e7eb;border-radius:8px;overflow:hidden;background:white;">
            @if($mkFoto)
            <img src="{{ asset('storage/' . $mkFoto->file_path) }}" style="width:100%;height:130px;object-fit:cover;">
            @else
            <div style="height:100px;background:#f9fafb;display:flex;align-items:center;justify-content:center;color:#d1d5db;">
                <i class="bi bi-image" style="font-size:1.5rem;"></i>
            </div>
            @endif
            <div style="padding:0.6rem;">
                <input type="text"
                    value="{{ $mk->jenis_kabel ?? '' }}"
                    placeholder="Jenis Kabel (opsional)"
                    onblur="updateMkLabel({{ $mk->id }}, this.value)"
                    style="width:100%;border:none;background:transparent;font-size:0.8rem;font-weight:600;color:#374151;outline:none;padding:0 0 2px;">
                <p style="margin:0;font-size:0.85rem;color:#4b5563;"><i class="bi bi-rulers" style="font-size:0.75rem;"></i> {{ $mk->panjang_meter }} m</p>
                <form action="{{ route('marking-kabel.destroy', [$lokasi, $mk]) }}" method="POST"
                    style="margin-top:0.4rem;" onsubmit="return confirm('Hapus entri ini?')">
                    @csrf @method('DELETE')
                    <button class="btn-danger-sm" type="submit" style="font-size:0.7rem;padding:0.2rem 0.5rem;">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
