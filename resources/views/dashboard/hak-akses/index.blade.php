@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Manajemen Hak Akses</h1>

    <div class="btr-card" style="padding:16px 24px;">
        <form method="GET" action="{{ route('admin.hak-akses.index') }}" style="display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
            <select name="role" class="btr-select" style="width:auto; min-width:180px;">
                <option value="">Semua Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ request('role') === $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
            <div class="btr-search" style="flex:1; min-width:200px;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email...">
                <button type="submit">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
                </button>
            </div>
        </form>
    </div>

    <div class="btr-card">
        <div class="btr-table-wrap">
            <table class="btr-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Admin</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td style="text-align:left; font-weight:500;">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span style="display:inline-block; padding:2px 10px; border-radius:999px; font-size:11px; font-weight:600; background:#DBEAFE; color:#1E40AF; margin:2px;">{{ $role->name }}</span>
                                @endforeach
                                @if($user->roles->isEmpty())
                                    <span style="color:var(--text-muted); font-size:12px;">-</span>
                                @endif
                            </td>
                            <td>
                                @if($user->is_admin)
                                    <span style="color:var(--success-green); font-weight:600;">Ya</span>
                                @else
                                    <span style="color:var(--text-muted);">Tidak</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.hak-akses.edit', $user) }}" class="btr-action edit" title="Edit Role">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-1.414-9.414a2 2 0 1 1 2.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="color:var(--text-muted);">Tidak ada user ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div style="margin-top:20px; display:flex; justify-content:center;">
                {{ $users->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection
