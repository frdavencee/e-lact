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
        <div class="photo-tile-modern">
            <img src="{{ asset('storage/' . $foto->file_path) }}" alt="{{ $foto->label }}">
            <div class="photo-overlay-modern" style="opacity:1;background:rgba(0,0,0,0.45);">
                <input type="text"
                    class="photo-label-input"
                    value="{{ $foto->label }}"
                    placeholder="Tambah label..."
                    onblur="updateFotoLabel({{ $foto->id }}, this.value)"
                    onclick="event.stopPropagation()">
            </div>
            <button type="button" onclick="removeFoto({{ $foto->id }})" class="photo-remove-btn">×</button>
        </div>
    </div>
    @endforeach
</div>
@endforeach
@endif
