@extends('layouts.guest')

@section('title', 'Lupa Password')

@section('content')
<div class="mb-3" style="font-size: 0.875rem; color: #4b5563;">
    Masukkan email Anda untuk menerima link reset password.
</div>

@if(session('status'))
    <div class="alert-custom alert-success-custom" style="margin-bottom: 1rem;">
        <i class="bi bi-check-circle-fill"></i>
        <div>{{ session('status') }}</div>
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label-soft">Email</label>
        <input type="email" name="email" class="form-control-soft" required autofocus value="{{ old('email') }}" placeholder="email@telkom.co.id">
        @error('email')<div class="form-error">{{ $message }}</div>@enderror
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <a href="{{ route('login') }}" style="font-size: 0.875rem; color: #6b7280;"><i class="bi bi-arrow-left"></i> Kembali ke Login</a>
        <button type="submit" class="btn-primary-gradient">Kirim Link Reset</button>
    </div>
</form>
@endsection
