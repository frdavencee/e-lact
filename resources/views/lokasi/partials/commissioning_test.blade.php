<h5>Data Commissioning Test</h5>
@php $ct = $lokasi->commissioningTest; @endphp
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
            <input type="date" name="tanggal" class="form-control-soft" required value="{{ old('tanggal', $ct->tanggal ?? '') }}">
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
            <h6>Upload Dokumentasi Gambar</h6>
            <div id="image-uploads">
                @if($ct && $ct->images->count() > 0)
                    @foreach($ct->images as $img)
                    <div class="image-upload-row mb-3 p-3 border rounded">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label-soft">Gambar</label>
                                <input type="file" name="images[]" class="form-control-soft" accept="image/*">
                                @if($img->file_path)
                                    <small class="text-muted d-block mt-1">
                                        Gambar saat ini: <a href="{{ asset('storage/' . $img->file_path) }}" target="_blank">Lihat</a>
                                    </small>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-soft">Label/Keterangan</label>
                                <input type="text" name="image_labels[]" class="form-control-soft" placeholder="Contoh: Dokumentasi Penarikan Kabel" value="{{ $img->label }}">
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
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
