<h5>Data Commissioning Test</h5>
@php $ct = $lokasi->commissioningTest; @endphp

<form method="POST" action="{{ $ct ? route('commissioning-test.update', $lokasi) : route('commissioning-test.store', $lokasi) }}" enctype="multipart/form-data">
    @csrf
    @if($ct) @method('PUT') @endif
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label-soft">WASPANG</label>
            <select name="personel_id" class="form-select-soft" required>
                <option value="">-- Pilih WASPANG --</option>
                @foreach($personelList as $p)
                <option value="{{ $p->id }}" {{ old('personel_id', $ct->personel_id ?? '') == $p->id ? 'selected' : '' }}>
                    {{ $p->nama }} ({{ $p->nik }})
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label-soft">Tanggal Commissioning</label>
            <input type="date" name="tanggal" class="form-control-soft" required
                value="{{ old('tanggal', isset($ct) && $ct ? \Carbon\Carbon::parse($ct->tanggal)->format('Y-m-d') : '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label-soft">Kota TTD</label>
            <input type="text" name="kota_ttd" class="form-control-soft" required
                value="{{ old('kota_ttd', $ct->kota_ttd ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label-soft">Status Pekerjaan</label>
            <select name="status_pekerjaan" class="form-select-soft" required>
                <option value="">-- Pilih --</option>
                <option value="telah" {{ old('status_pekerjaan', $ct->status_pekerjaan ?? '') == 'telah' ? 'selected' : '' }}>Telah</option>
                <option value="belum" {{ old('status_pekerjaan', $ct->status_pekerjaan ?? '') == 'belum' ? 'selected' : '' }}>Belum</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label-soft">Hasil Pekerjaan</label>
            <select name="status_hasil" class="form-select-soft" required>
                <option value="">-- Pilih --</option>
                <option value="dapat" {{ old('status_hasil', $ct->status_hasil ?? '') == 'dapat' ? 'selected' : '' }}>Dapat</option>
                <option value="tidak_dapat" {{ old('status_hasil', $ct->status_hasil ?? '') == 'tidak_dapat' ? 'selected' : '' }}>Tidak Dapat</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label-soft">Kelayakan UT</label>
            <select name="status_kelayakan" class="form-select-soft" required>
                <option value="">-- Pilih --</option>
                <option value="layak" {{ old('status_kelayakan', $ct->status_kelayakan ?? '') == 'layak' ? 'selected' : '' }}>Layak</option>
                <option value="tidak_layak" {{ old('status_kelayakan', $ct->status_kelayakan ?? '') == 'tidak_layak' ? 'selected' : '' }}>Tidak Layak</option>
            </select>
        </div>

        <div class="col-12">
            <hr style="border-color:#e5e7eb;">
            <h6 style="font-weight:600;margin-bottom:1rem;">Upload Tanda Tangan / Dokumentasi</h6>

            @if($ct && $ct->images->count() > 0)
            <div class="row g-2 mb-3">
                @foreach($ct->images as $img)
                <div class="col-6 col-md-3">
                    <div class="photo-tile-modern">
                        <img src="{{ asset('storage/' . $img->file_path) }}" alt="{{ $img->label }}" style="width:100%;height:130px;object-fit:contain;background:#f8f8f8;">
                        <div class="photo-overlay-modern">
                            <small style="color:#fff;font-size:0.7rem;">{{ $img->label }}</small>
                        </div>
                        <form action="{{ route('commissioning-test.image.destroy', [$lokasi, $img]) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus gambar?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="photo-remove-btn">×</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <div id="image-uploads">
                <div class="image-upload-row mb-3 p-3" style="border:1px solid #e5e7eb;border-radius:8px;">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label-soft">Gambar</label>
                            <input type="file" name="images[]" class="form-control-soft" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-soft">Label / Keterangan</label>
                            <input type="text" name="image_labels[]" class="form-control-soft" placeholder="Contoh: Tanda Tangan Waspang">
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn-soft-secondary btn-sm" onclick="addImageUpload()">
                <i class="bi bi-plus"></i> Tambah Gambar
            </button>
        </div>

        <div class="col-12">
            <button type="submit" class="btn-primary-gradient">
                <i class="bi bi-save"></i> Simpan Data CT
            </button>
        </div>
    </div>
</form>

@push('scripts')
<script>
function addImageUpload() {
    const container = document.getElementById('image-uploads');
    const row = document.createElement('div');
    row.className = 'image-upload-row mb-3 p-3';
    row.style.cssText = 'border:1px solid #e5e7eb;border-radius:8px;';
    row.innerHTML = `
        <div class="row g-2">
            <div class="col-md-6">
                <label class="form-label-soft">Gambar</label>
                <input type="file" name="images[]" class="form-control-soft" accept="image/*">
            </div>
            <div class="col-md-6">
                <label class="form-label-soft">Label / Keterangan</label>
                <input type="text" name="image_labels[]" class="form-control-soft" placeholder="Contoh: Dokumentasi Penarikan Kabel">
            </div>
        </div>
        <button type="button" class="btn-danger-sm mt-2" onclick="this.closest('.image-upload-row').remove()">Hapus</button>
    `;
    container.appendChild(row);
}
</script>
@endpush
