@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Buat Akun Admin</h1>

    <div class="btr-card" style="max-width:760px;">
        <form action="{{ route('admin.hak-akses.store') }}" method="POST">
            @csrf

            <div class="btr-form-group">
                <label class="btr-label" for="name">Nama</label>
                <input id="name" name="name" type="text" class="btr-input" value="{{ old('name') }}" required>
                @error('name') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="username">Username</label>
                <input id="username" name="username" type="text" class="btr-input" value="{{ old('username') }}" required>
                @error('username') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="email">Email</label>
                <input id="email" name="email" type="email" class="btr-input" value="{{ old('email') }}" required>
                @error('email') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="no_id">No ID (ID Pegawai / NIP / No Identitas)</label>
                <input id="no_id" name="no_id" type="text" class="btr-input" value="{{ old('no_id') }}" required>
                @error('no_id') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="instansi">Instansi</label>
                <input id="instansi" name="instansi" type="text" class="btr-input" value="{{ old('instansi', 'Balai Teknik Rawa') }}" required>
                @error('instansi') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="alamat">Alamat</label>
                <input id="alamat" name="alamat" type="text" class="btr-input" value="{{ old('alamat') }}">
                @error('alamat') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label style="display:flex; align-items:center; gap:10px; padding:10px 16px; border:1.5px solid var(--border-soft); border-radius:10px; cursor:pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }} style="accent-color:var(--sidebar-bg);">
                    <span>
                        <span style="display:block; font-size:14px; font-weight:600; color:var(--text-body);">Aktif</span>
                        <span style="display:block; font-size:11px; color:var(--text-muted);">Jika tidak aktif, akun tidak bisa login.</span>
                    </span>
                </label>
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="password">Password</label>
                <input id="password" name="password" type="password" class="btr-input" required>
                @error('password') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="password_confirmation">Konfirmasi Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="btr-input" required>
            </div>

            <div class="btr-form-group">
                <label class="btr-label">Role Admin</label>
                <p style="margin:0 0 10px; font-size:12px; color:var(--text-muted);">
                    Role adalah hak akses dasar. Akun baru akan otomatis mengikuti paket akses bawaan dari role yang dipilih.
                </p>
                <div style="display:flex; flex-direction:column; gap:10px;">
                    @foreach($roles as $role)
                        <label style="display:flex; align-items:flex-start; gap:10px; padding:10px 16px; border:1.5px solid var(--border-soft); border-radius:10px; cursor:pointer;">
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}
                                style="accent-color:var(--sidebar-bg); margin-top:2px;">
                            <span>
                                <span style="display:block; font-size:14px; font-weight:600; color:var(--text-body);">
                                    {{ $roleLabels[$role->name]['label'] ?? $role->name }}
                                </span>
                                <span style="display:block; font-size:11px; color:var(--text-muted);">
                                    {{ $roleLabels[$role->name]['description'] ?? $role->name }}
                                </span>
                            </span>
                        </label>
                    @endforeach
                </div>
                @error('roles') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
                @error('roles.*') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label">Akses Modul</label>
                <p style="margin:0 0 10px; font-size:12px; color:var(--text-muted);">
                    Akses modul di bawah ini adalah tambahan khusus untuk akun ini dan tidak mengubah hak akses dasar pada role.
                </p>
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:16px;">
                    @foreach($permissions as $groupLabel => $items)
                        <div style="border:1px solid var(--border-soft); border-radius:14px; padding:14px 16px; background:#fff;">
                            <div style="font-size:13px; font-weight:700; color:var(--sidebar-bg); margin-bottom:10px;">{{ $groupLabel }}</div>
                            <div style="display:flex; flex-direction:column; gap:10px;">
                                @foreach($items as $permission)
                                    <label style="display:flex; align-items:flex-start; gap:10px; cursor:pointer;">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission['name'] }}"
                                            {{ in_array($permission['name'], old('permissions', [])) ? 'checked' : '' }}
                                            style="accent-color:var(--sidebar-bg); margin-top:2px;">
                                        <div>
                                            <div style="font-size:14px; font-weight:600; color:var(--text-body);">{{ $permission['label'] }}</div>
                                            <div style="font-size:11px; color:var(--text-muted);">{{ $permission['name'] }}</div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                @error('permissions') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
                @error('permissions.*') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
                <small style="display:block; margin-top:8px; color:var(--text-muted);">Role akan otomatis menandai modul terkait, dan Anda tetap bisa menambah modul manual.</small>
            </div>

            <div class="btr-form-actions">
                <a href="{{ route('admin.hak-akses.index') }}" class="btr-btn btr-btn-outline">Batal</a>
                <button type="submit" class="btr-btn btr-btn-yellow">Buat Akun</button>
            </div>
        </form>
    </div>

    <script type="application/json" id="role-permissions-create-data">@json($rolePermissions)</script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form[action="{{ route('admin.hak-akses.store') }}"]');
            const rolePermissions = JSON.parse(document.getElementById('role-permissions-create-data').textContent || '{}');

            if (!form) {
                return;
            }

            const roleInputs = Array.from(form.querySelectorAll('input[name="roles[]"]'));
            const permissionInputs = Array.from(form.querySelectorAll('input[name="permissions[]"]'));
            let manualPermissions = new Set();

            function selectedRoles() {
                return roleInputs.filter((input) => input.checked).map((input) => input.value);
            }

            function derivedPermissions() {
                const permissions = new Set();

                selectedRoles().forEach((roleName) => {
                    (rolePermissions[roleName] || []).forEach((permissionName) => permissions.add(permissionName));
                });

                return permissions;
            }

            function captureManualState() {
                const derived = derivedPermissions();
                manualPermissions = new Set(
                    permissionInputs
                        .filter((input) => input.checked && !derived.has(input.value))
                        .map((input) => input.value)
                );
            }

            function syncPermissions() {
                const derived = derivedPermissions();

                permissionInputs.forEach((input) => {
                    input.checked = derived.has(input.value) || manualPermissions.has(input.value);
                });
            }

            roleInputs.forEach((input) => {
                input.addEventListener('change', function () {
                    syncPermissions();
                });
            });

            permissionInputs.forEach((input) => {
                input.addEventListener('change', function () {
                    captureManualState();
                });
            });

            captureManualState();
            syncPermissions();
        });
    </script>
@endsection
