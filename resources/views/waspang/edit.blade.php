@extends('layouts.app')

@section('title', 'Edit Waspang')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="detail-card">
            <div class="detail-card-header">
                <h5>Edit Personel</h5>
            </div>
            <div class="detail-card-body">
                <form method="POST" action="{{ route('waspang.update', $personel) }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label-soft">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control-soft" required value="{{ old('nama', $personel->nama) }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label-soft">NIK <span class="text-danger">*</span></label>
                            <input type="text" name="nik" class="form-control-soft" required value="{{ old('nik', $personel->nik) }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label-soft">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control-soft" value="{{ old('jabatan', $personel->jabatan) }}">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('waspang.index') }}" class="btn-soft-secondary">Batal</a>
                        <button type="submit" class="btn-primary-gradient">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection