<h5>Data Commissioning Test</h5>
@php $ct = $lokasi->commissioningTest; @endphp

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ $ct ? route('commissioning-test.update', $lokasi) : route('commissioning-test.store', $lokasi) }}" enctype="multipart/form-data">
    @csrf
    @if($ct) @method('PUT') @endif
    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label-soft">WASPANG</label>
            <select name="personel_id" class="form-select-soft" required>
                <option value="">-- Pilih --</option>
                @foreach($personelList as $p)
                <option value="{{ $p->id }}" {{ old('personel_id', $ct->personel_id ?? '') == $p->id ? 'selected' : '' }}>{{ $p->nama }} ({{ $p->nik }})</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label-soft">Tanggal Commissioning</label>
            <input type="date" name="tanggal" class="form-control-soft" required value="{{ old('tanggal', isset($ct) && $ct ? \Carbon\Carbon::parse($ct->tanggal)->format('Y-m-d') : '') }}">
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
        <div class="col-12 mb-3">
            <hr>
            <h6>Upload Dokumentasi Gambar (Tanda Tangan)</h6>

            {{-- Gambar yang sudah diupload --}}
            @if($ct && $ct->images->count() > 0)
            <div class="row mb-3">
                @foreach($ct->images as $img)
                <div class="col-md-3 mb-3">
                    <div class="photo-tile-modern">
                        <img src="{{ asset('storage/' . $img->file_path) }}" alt="{{ $img->label }}" style="width:100%; height:150px; object-fit:contain; background:#f8f8f8;">
                        <div class="photo-overlay-modern">
                            <small class="text-muted">{{ $img->label }}</small>
                        </div>
                        <form action="{{ route('commissioning-test.image.destroy', [$lokasi, $img]) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus gambar ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="photo-remove-btn">×</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Form upload gambar baru --}}
            <div id="image-uploads">
                <div class="image-upload-row mb-3 p-3 border rounded">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label-soft">Gambar</label>
                            <input type="file" name="images[]" class="form-control-soft" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-soft">Label/Keterangan</label>
                            <input type="text" name="image_labels[]" class="form-control-soft" placeholder="Contoh: Tanda Tangan Waspang">
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addImageUpload()">+ Tambah Gambar</button>
        </div>
        <div class="col-12">
            <button type="submit" class="btn-primary-gradient">Simpan Data CT</button>
        </div>
    </div>
</form>

<script>
function addImageUpload() {
    const container = document.getElementById('image-uploads');
    const newRow = document.createElement('div');
    newRow.className = 'image-upload-row mb-3 p-3 border rounded';
    newRow.innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <label class="form-label-soft">Gambar</label>
                <input type="file" name="images[]" class="form-control-soft" accept="image/*">
            </div>
            <div class="col-md-6">
                <label class="form-label-soft">Label/Keterangan</label>
                <input type="text" name="image_labels[]" class="form-control-soft" placeholder="Contoh: Dokumentasi Penarikan Kabel">
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="this.parentElement.remove()">Hapus</button>
    `;
    container.appendChild(newRow);
}
</script>
