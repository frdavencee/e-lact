@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label-soft">Nama Lengkap</label>
        <input type="text" name="name" class="form-control-soft" required autofocus value="{{ old('name') }}" placeholder="Nama Lengkap">
        @error('name')<div class="form-error">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label-soft">Email</label>
        <input type="email" name="email" class="form-control-soft" required value="{{ old('email') }}" placeholder="email@telkom.co.id">
        @error('email')<div class="form-error">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label-soft">Password</label>
        <input type="password" name="password" class="form-control-soft" required placeholder="••••••••">
        @error('password')<div class="form-error">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label-soft">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control-soft" required placeholder="••••••••">
        @error('password_confirmation')<div class="form-error">{{ $message }}</div>@enderror
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <a href="{{ route('login') }}" style="font-size: 0.875rem; color: #6b7280;">Sudah punya akun?</a>
        <button type="submit" class="btn-primary-gradient">Daftar</button>
    </div>
</form>
@endsection
