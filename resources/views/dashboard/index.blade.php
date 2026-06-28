@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h2 style="font-size:1.25rem;font-weight:700;color:#1f2937;margin-bottom:1.5rem;">Dashboard</h2>

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem;margin-bottom:2rem;">

    <div style="background:white;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,.08);padding:1.25rem;display:flex;align-items:center;gap:1rem;">
        <div style="padding:0.75rem;border-radius:8px;background:#dbeafe;color:#3b82f6;flex-shrink:0;">
            <i class="bi bi-geo-alt-fill" style="font-size:1.3rem;"></i>
        </div>
        <div>
            <p style="font-size:0.75rem;color:#6b7280;margin:0;">Total Lokasi</p>
            <p style="font-size:1.75rem;font-weight:700;color:#1f2937;margin:0;">{{ $totalLokasi }}</p>
        </div>
    </div>

    <div style="background:white;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,.08);padding:1.25rem;display:flex;align-items:center;gap:1rem;">
        <div style="padding:0.75rem;border-radius:8px;background:#dcfce7;color:#22c55e;flex-shrink:0;">
            <i class="bi bi-people-fill" style="font-size:1.3rem;"></i>
        </div>
        <div>
            <p style="font-size:0.75rem;color:#6b7280;margin:0;">Total Personel</p>
            <p style="font-size:1.75rem;font-weight:700;color:#1f2937;margin:0;">{{ $totalPersonel }}</p>
        </div>
    </div>

    <div style="background:white;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,.08);padding:1.25rem;display:flex;align-items:center;gap:1rem;">
        <div style="padding:0.75rem;border-radius:8px;background:#f3e8ff;color:#a855f7;flex-shrink:0;">
            <i class="bi bi-diagram-3-fill" style="font-size:1.3rem;"></i>
        </div>
        <div>
            <p style="font-size:0.75rem;color:#6b7280;margin:0;">Total Branch</p>
            <p style="font-size:1.75rem;font-weight:700;color:#1f2937;margin:0;">{{ $totalBranch }}</p>
        </div>
    </div>

    <div style="background:white;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,.08);padding:1.25rem;display:flex;align-items:center;gap:1rem;">
        <div style="padding:0.75rem;border-radius:8px;background:#fee2e2;color:#E3000F;flex-shrink:0;">
            <i class="bi bi-file-earmark-check-fill" style="font-size:1.3rem;"></i>
        </div>
        <div>
            <p style="font-size:0.75rem;color:#6b7280;margin:0;">Total Generate</p>
            <p style="font-size:1.75rem;font-weight:700;color:#1f2937;margin:0;">{{ $totalGenerated }}</p>
        </div>
    </div>

</div>
@endsection
