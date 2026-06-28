@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="page-header-modern">
    <h2>Manajemen User</h2>
    <a href="{{ route('users.create') }}" class="btn-primary-gradient">
        <i class="bi bi-plus-lg"></i> Tambah User
    </a>
</div>

<div class="data-table-wrapper">
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>NIK</th>
                    <th>Role</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        @if($user->profile_photo)
                            <div class="avatar-circle">
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}">
                            </div>
                        @else
                            <div class="avatar-circle">
                                <i class="bi bi-person"></i>
                            </div>
                        @endif
                    </td>
                    <td><strong style="color: #1f2937;">{{ $user->name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->nik ?? '-' }}</td>
                    <td>
                        @php
                            $badgeClass = match($user->role) {
                                'admin' => 'badge-primary',
                                'waspang' => 'badge-warning',
                                'viewer' => 'badge-info',
                                default => 'badge-secondary'
                            };
                        @endphp
                        <span class="badge-modern {{ $badgeClass }}">{{ ucfirst($user->role) }}</span>
                    </td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('users.edit', $user) }}" class="action-icon-btn btn-edit" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus user ini?')">
                                @csrf @method('DELETE')
                                <button class="action-icon-btn btn-delete" title="Hapus"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="bi bi-person-x"></i>
                            <p>Tidak ada data user</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($users->hasPages())
<div class="pagination-soft">
    {{ $users->links() }}
</div>
@endif
@endsection