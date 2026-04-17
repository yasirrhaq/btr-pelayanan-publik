@extends('pelanggan.layouts.main')

@section('container')
    <style>
        .btr-form-shell {
            max-width: 760px;
        }
        .btr-form-card {
            background: #fff;
            border-radius: 24px;
            box-shadow: var(--shadow-card);
            padding: 28px;
        }
        .btr-form-heading {
            margin: 0 0 24px;
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
        }
        .btr-form-grid {
            display: grid;
            gap: 18px;
        }
        .btr-form-error {
            margin-top: 8px;
            font-size: 12px;
            color: var(--danger-red);
        }
        @media (max-width: 900px) {
            .btr-form-card {
                padding: 22px 18px;
            }
        }
    </style>

    <div class="btr-form-shell">
        <h1 class="btr-page-title">Ganti Password</h1>

        <div class="btr-form-card">
            <h2 class="btr-form-heading">Perbarui Password Akun</h2>

            <form method="POST" action="{{ route('pelanggan.profil.password.update') }}">
                @csrf
                <div class="btr-form-grid">
                    <div class="btr-form-group">
                        <label for="current_password" class="btr-label">Password Saat Ini</label>
                        <input id="current_password" type="password" class="btr-input @error('current_password') is-invalid @enderror" name="current_password" autocomplete="current-password" required>
                        @error('current_password')
                            <div class="btr-form-error">Password saat ini tidak cocok.</div>
                        @enderror
                    </div>

                    <div class="btr-form-group">
                        <label for="new_password" class="btr-label">Password Baru</label>
                        <input id="new_password" type="password" class="btr-input @error('new_password') is-invalid @enderror" name="new_password" autocomplete="new-password" required>
                        @error('new_password')
                            <div class="btr-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="btr-form-group">
                        <label for="new_confirm_password" class="btr-label">Konfirmasi Password Baru</label>
                        <input id="new_confirm_password" type="password" class="btr-input @error('new_confirm_password') is-invalid @enderror" name="new_confirm_password" autocomplete="new-password" required>
                        @error('new_confirm_password')
                            <div class="btr-form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="btr-form-actions">
                    <a href="{{ route('pelanggan.profil') }}" class="btr-btn btr-btn-outline">Batal</a>
                    <button type="submit" class="btr-btn">Update Password</button>
                </div>
            </form>
        </div>
    </div>
@endsection
