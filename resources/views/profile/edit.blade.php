@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="detail-card">
            <div class="detail-card-header">
                <h5>Edit Profile</h5>
            </div>
            <div class="detail-card-body">
                @if(session('success'))
                    <div class="alert-custom alert-success-custom">
                        <i class="bi bi-check-circle-fill"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                <div class="text-center mb-4">
                    @if($user->profile_photo)
                        <div class="profile-avatar">
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile">
                        </div>
                    @else
                        <div class="profile-avatar">
                            <i class="bi bi-person"></i>
                        </div>
                    @endif
                </div>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf @method('PATCH')
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label-soft">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control-soft" required value="{{ old('name', $user->name) }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label-soft">NIK</label>
                            <input type="text" name="nik" class="form-control-soft" value="{{ old('nik', $user->nik) }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label-soft">Email</label>
                            <input type="email" class="form-control-soft" value="{{ $user->email }}" disabled style="background: #f9fafb;">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label-soft">Role</label>
                            <input type="text" class="form-control-soft" value="{{ ucfirst($user->role) }}" disabled style="background: #f9fafb;">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label-soft">Foto Profile</label>
                            <input type="file" name="profile_photo" class="form-control-soft" accept="image/*">
                            @if($user->profile_photo)
                                <small style="color: #6b7280; font-size: 0.8rem;">Upload foto baru untuk mengganti yang saat ini</small>
                            @endif
                        </div>
                    </div>

                    <div class="section-divider"></div>
                    <h6 class="section-subtitle">Ganti Password</h6>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label-soft">Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-control-soft">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-soft">Password Baru</label>
                            <input type="password" name="password" class="form-control-soft">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-soft">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control-soft">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('dashboard') }}" class="btn-soft-secondary">Batal</a>
                        <button type="submit" class="btn-primary-gradient">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection