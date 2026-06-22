@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="detail-card">
            <div class="detail-card-header">
                <h5>Edit User</h5>
            </div>
            <div class="detail-card-body">
                <form method="POST" action="{{ route('users.update', $user) }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label-soft">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control-soft" required value="{{ old('name', $user->name) }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label-soft">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control-soft" required value="{{ old('email', $user->email) }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label-soft">NIK</label>
                            <input type="text" name="nik" class="form-control-soft" value="{{ old('nik', $user->nik) }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label-soft">Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-select-soft" required>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="waspang" {{ old('role', $user->role) == 'waspang' ? 'selected' : '' }}>Waspang</option>
                                <option value="viewer" {{ old('role', $user->role) == 'viewer' ? 'selected' : '' }}>Viewer</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label-soft">Password Baru (kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" name="password" class="form-control-soft">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label-soft">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control-soft">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label-soft">Foto Profile</label>
                            <input type="file" name="profile_photo" class="form-control-soft" accept="image/*">
                            @if($user->profile_photo)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile" style="border-radius: 50%; width: 80px; height: 80px; object-fit: cover;">
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('users.index') }}" class="btn-soft-secondary">Batal</a>
                        <button type="submit" class="btn-primary-gradient">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection