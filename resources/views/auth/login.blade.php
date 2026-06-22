@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label-soft">Email</label>
        <input type="email" name="email" class="form-control-soft" required autofocus value="{{ old('email') }}" placeholder="email@telkom.co.id">
        @error('email')<div class="form-error">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label-soft">Password</label>
        <input type="password" name="password" class="form-control-soft" required placeholder="••••••••">
        @error('password')<div class="form-error">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember" name="remember">
        <label class="form-check-label" for="remember">Ingat saya</label>
    </div>
    <button type="submit" class="btn-primary-gradient w-100">Masuk</button>
</form>
<div class="text-center mt-3">
    <small class="text-muted">Demo: admin@telkom.co.id / password</small>
</div>
@endsection
