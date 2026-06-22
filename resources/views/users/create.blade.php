@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="detail-card">
            <div class="detail-card-header">
                <h5>Tambah User Baru</h5>
            </div>
            <div class="detail-card-body">
                <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label-soft">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control-soft" required value="{{ old('name') }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label-soft">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control-soft" required value="{{ old('email') }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label-soft">NIK</label>
                            <input type="text" name="nik" class="form-control-soft" value="{{ old('nik') }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label-soft">Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-select-soft" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="waspang" {{ old('role') == 'waspang' ? 'selected' : '' }}>Waspang</option>
                                <option value="viewer" {{ old('role') == 'viewer' ? 'selected' : '' }}>Viewer</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label-soft">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control-soft" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label-soft">Konfirmasi Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control-soft" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label-soft">Foto Profile</label>
                            <input type="file" name="profile_photo" class="form-control-soft" accept="image/*">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('users.index') }}" class="btn-soft-secondary">Batal</a>
                        <button type="submit" class="btn-primary-gradient">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection