{{-- Variables: $lokasi, $sectionCategories (array of {value, label}) --}}
@php
$catValues = array_column($sectionCategories, 'value');
$catMap    = array_combine($catValues, array_column($sectionCategories, 'label'));
$fotos     = $lokasi->fotoLampiran->filter(fn($f) => in_array($f->kategori, $catValues));
$single    = count($sectionCategories) === 1;
@endphp

<form method="POST" action="{{ route('foto.store', $lokasi) }}" enctype="multipart/form-data"
    class="row g-2 mb-4 p-3" style="background:#f9fafb;border:1px dashed #d1d5db;border-radius:8px;">
    @csrf
    @if($single)
        <input type="hidden" name="kategori" value="{{ $sectionCategories[0]['value'] }}">
    @else
    <div class="col-md-3">
        <select name="kategori" class="form-select-soft" required>
            <option value="">-- Sub Kategori --</option>
            @foreach($sectionCategories as $cat)
            <option value="{{ $cat['value'] }}">{{ $cat['label'] }}</option>
            @endforeach
        </select>
    </div>
    @endif
    <div class="{{ $single ? 'col-md-5' : 'col-md-4' }}">
        <input type="text" name="label" class="form-control-soft" placeholder="Label (opsional)">
    </div>
    <div class="{{ $single ? 'col-md-5' : 'col-md-3' }}">
        <input type="file" name="fotos[]" class="form-control-soft" multiple accept="image/*" required>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn-primary-gradient w-100">
            <i class="bi bi-upload"></i> Upload
        </button>
    </div>
</form>

@if($fotos->isEmpty())
<div class="empty-state" style="padding:1.5rem 0;">
    <i class="bi bi-image"></i>
    <p>Belum ada foto di bagian ini.</p>
</div>
@else
@foreach($fotos->groupBy('kategori') as $kat => $katFotos)
@if(!$single)
<p style="font-size:0.7rem;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.08em;margin-bottom:.5rem;margin-top:.75rem;">
    {{ $catMap[$kat] ?? str_replace('_',' ',ucfirst($kat)) }}
</p>
@endif
<div class="row g-2 mb-2">
    @foreach($katFotos as $foto)
    <div class="col-6 col-md-3">
        <div style="border:1px solid #e5e7eb;border-radius:8px;overflow:hidden;background:white;">
            <div style="position:relative;">
                <img id="foto-img-{{ $foto->id }}" src="{{ asset('storage/' . $foto->file_path) }}" alt="{{ $foto->label }}"
                    style="width:100%;height:110px;object-fit:cover;display:block;">
                <input type="file" id="foto-replace-{{ $foto->id }}" accept="image/*" style="display:none;"
                    onchange="replaceFoto({{ $foto->id }}, this)">
                <button type="button" onclick="document.getElementById('foto-replace-{{ $foto->id }}').click()"
                    title="Ganti foto"
                    style="position:absolute;top:4px;right:28px;width:22px;height:22px;border-radius:50%;border:none;background:rgba(59,130,246,0.85);color:#fff;font-size:0.65rem;cursor:pointer;line-height:22px;text-align:center;">
                    <i class="bi bi-camera"></i>
                </button>
                <button type="button" onclick="removeFoto({{ $foto->id }})"
                    style="position:absolute;top:4px;right:4px;width:22px;height:22px;border-radius:50%;border:none;background:rgba(220,38,38,0.85);color:#fff;font-size:0.75rem;cursor:pointer;line-height:22px;text-align:center;">×</button>
            </div>
            <div style="padding:0.35rem 0.5rem;border-top:1px solid #f3f4f6;">
                <input type="text"
                    value="{{ $foto->label }}"
                    placeholder="Tambah label..."
                    onblur="updateFotoLabel({{ $foto->id }}, this.value)"
                    style="width:100%;border:none;background:transparent;font-size:0.75rem;color:#374151;outline:none;padding:0;">
            </div>
        </div>
    </div>
    @endforeach
</div>
@endforeach
@endif
