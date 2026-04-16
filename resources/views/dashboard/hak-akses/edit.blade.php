@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Edit Hak Akses — {{ $user->name }}</h1>

    <div class="btr-card" style="max-width:600px;">
        <div style="margin-bottom:20px;">
            <p style="font-size:14px; color:var(--text-body);"><strong>Email:</strong> {{ $user->email }}</p>
            <p style="font-size:14px; color:var(--text-body);"><strong>Terdaftar:</strong> {{ $user->created_at->format('d F Y') }}</p>
        </div>

        <form action="{{ route('admin.hak-akses.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="btr-form-group">
                <label class="btr-label">Pilih Role</label>
                <div style="display:flex; flex-direction:column; gap:10px;">
                    @foreach($roles as $role)
                        <label style="display:flex; align-items:center; gap:10px; padding:10px 16px; border:1.5px solid var(--border-soft); border-radius:10px; cursor:pointer; transition:border-color 0.15s ease;">
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                {{ in_array($role->name, $userRoles) ? 'checked' : '' }}
                                style="accent-color:var(--sidebar-bg);">
                            <span style="font-size:14px; font-weight:500; color:var(--text-body);">{{ $role->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('roles')
                    <p style="color:var(--danger-red); font-size:13px; margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            <div class="btr-form-actions">
                <a href="{{ route('admin.hak-akses.index') }}" class="btr-btn btr-btn-outline">Batal</a>
                <button type="submit" class="btr-btn btr-btn-yellow">Simpan</button>
            </div>
        </form>
    </div>
@endsection
