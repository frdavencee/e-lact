<form method="POST" action="{{ route('otdr.store', $lokasi) }}" enctype="multipart/form-data" class="row g-2 mb-4 p-3" style="background:#f9fafb;border:1px dashed #d1d5db;border-radius:8px;">
    @csrf
    <div class="col-md-4">
        <label class="form-label-soft">Nama ODP</label>
        <input type="text" name="odp_name" class="form-control-soft input-mono" placeholder="ODP-PAT-FW/114" required>
    </div>
    <div class="col-md-5">
        <label class="form-label-soft">File Gambar OTDR (JPG/PNG)</label>
        <input type="file" name="file" class="form-control-soft" accept="image/*" required>
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <button type="submit" class="btn-primary-gradient w-100"><i class="bi bi-upload"></i> Upload OTDR</button>
    </div>
</form>

@php
    $otdrGrouped = $lokasi->otdrFiles->groupBy('odp_name');
@endphp

@if($otdrGrouped->isEmpty())
<div class="empty-state" style="padding:2rem;">
    <i class="bi bi-file-earmark-bar-graph"></i>
    <p>Belum ada file OTDR yang diupload.</p>
</div>
@else
    @foreach($otdrGrouped as $odpName => $files)
    <div class="mb-4">
        <p style="font-size:0.7rem;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.5rem;">
            {{ $odpName ?? 'Lainnya' }}
        </p>
        <div class="row g-3">
            @foreach($files as $otdr)
            <div class="col-md-4 col-lg-3">
                <div style="position:relative;border:1px solid #e5e7eb;border-radius:8px;overflow:hidden;background:#f9fafb;">
                    @if(in_array(strtolower(pathinfo($otdr->original_name, PATHINFO_EXTENSION)), ['jpg','jpeg','png']))
                    <img src="{{ asset('storage/' . $otdr->file_path) }}" alt="{{ $otdr->odp_name }}"
                        style="width:100%;height:150px;object-fit:contain;padding:0.5rem;">
                    @else
                    <div style="height:100px;display:flex;align-items:center;justify-content:center;background:#f3f4f6;">
                        <i class="bi bi-file-earmark-pdf" style="font-size:2.5rem;color:#9ca3af;"></i>
                    </div>
                    @endif
                    <div style="padding:0.5rem;border-top:1px solid #e5e7eb;display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:0.75rem;color:#6b7280;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:80%;">{{ $otdr->original_name }}</span>
                        <form action="{{ route('otdr.destroy', [$lokasi, $otdr]) }}" method="POST" onsubmit="return confirm('Hapus?')" style="margin:0;">
                            @csrf @method('DELETE')
                            <button class="btn-danger-sm" style="padding:0.2rem 0.4rem;"><i class="bi bi-trash" style="font-size:0.7rem;"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
@endif
