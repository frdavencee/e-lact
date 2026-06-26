@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
<div class="detail-header">
    <h2>Pengaturan</h2>
</div>

<div class="detail-card" style="max-width:520px;">
    <div class="detail-card-header">
        <h5>Logo Perusahaan</h5>
    </div>
    <div class="detail-card-body">
        <p style="font-size:0.85rem;color:#6b7280;margin-bottom:1.25rem;">
            Logo ditampilkan di cover dokumen PDF dan DOCX. Format: PNG, JPG, SVG. Disarankan ukuran 300×150px.
        </p>

        @if($hasLogo)
        <div style="margin-bottom:1.25rem;padding:1rem;border:1px solid #e5e7eb;border-radius:8px;background:#f9fafb;display:inline-block;">
            <img src="{{ asset('images/logo.png') }}?t={{ time() }}" alt="Logo" style="max-height:80px;max-width:280px;object-fit:contain;">
            <p style="font-size:0.75rem;color:#9ca3af;margin-top:0.5rem;text-align:center;">Logo saat ini</p>
        </div>
        @else
        <div style="margin-bottom:1.25rem;padding:1.5rem;border:2px dashed #d1d5db;border-radius:8px;background:#f9fafb;text-align:center;color:#9ca3af;font-size:0.875rem;">
            <i class="bi bi-image" style="font-size:2rem;display:block;margin-bottom:0.5rem;"></i>
            Belum ada logo
        </div>
        @endif

        <form method="POST" action="{{ route('settings.logo') }}" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <div style="margin-bottom:1rem;">
                <label class="form-label-soft">Pilih File Logo</label>
                <input type="file" name="logo" accept="image/png,image/jpeg,image/jpg,image/svg+xml"
                    class="form-control-soft" required>
                @error('logo')
                    <p style="color:#dc2626;font-size:0.8rem;margin-top:0.25rem;">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn-primary-gradient">
                <i class="bi bi-upload"></i>
                {{ $hasLogo ? 'Ganti Logo' : 'Upload Logo' }}
            </button>
        </form>
    </div>
</div>
@endsection
