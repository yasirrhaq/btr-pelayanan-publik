@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Pengaturan <small>Sistem</small></h1>

    <div class="btr-card">
        <form method="POST" enctype="multipart/form-data">
            @csrf

            <div class="btr-form-group">
                <label class="btr-label">Debug Mode</label>
                <label style="display:inline-flex;align-items:center;gap:8px">
                    <input name="debug" type="checkbox" @if (config('app.debug')) checked @endif value="true">
                    <span>Aktifkan Debug</span>
                </label>
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="name">Nama Aplikasi</label>
                <input type="text" class="btr-input" name="name" value="{{ config('app.name') }}">
            </div>

            <div class="btr-form-group">
                <label class="btr-label">Logo <small style="color:var(--text-muted)">(Max 1MB)</small></label>
                <img class="img-preview" src="{{ imageExists(config('app.logo')) }}" alt="" style="display:block;max-width:200px;border-radius:10px;margin-bottom:10px">
                <div class="btr-file-row">
                    <label class="btr-file-pill">
                        <span class="btr-file-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16V8m0 0l-3 3m3-3l3 3"/></svg>
                        </span>
                        <input type="file" id="logo" name="logo" onchange="btrPreview(this,'.img-preview')">
                    </label>
                </div>
            </div>

            <div class="btr-form-group">
                <label class="btr-label">Logo Text <small style="color:var(--text-muted)">(Max 1MB)</small></label>
                <img class="img-preview-logo-text" src="{{ imageExists(config('app.logoText')) }}" alt="" style="display:block;max-width:200px;border-radius:10px;margin-bottom:10px">
                <div class="btr-file-row">
                    <label class="btr-file-pill">
                        <span class="btr-file-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16V8m0 0l-3 3m3-3l3 3"/></svg>
                        </span>
                        <input type="file" id="logoText" name="logoText" onchange="btrPreview(this,'.img-preview-logo-text')">
                    </label>
                </div>
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="timezone">Timezone</label>
                <input type="text" class="btr-input" name="timezone" value="{{ config('app.timezone') }}">
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="custom_format_date">Format Tanggal</label>
                <input type="text" class="btr-input" name="custom_format_date" value="{{ config('app.custom_format_date') }}">
                <small style="color:var(--text-muted)">{{ \Carbon\Carbon::parse(now())->format(config('app.custom_format_date')) }}</small>
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="custom_format_time">Format Waktu</label>
                <input type="text" class="btr-input" name="custom_format_time" value="{{ config('app.custom_format_time') }}">
                <small style="color:var(--text-muted)">{{ \Carbon\Carbon::parse(now())->format(config('app.custom_format_time')) }}</small>
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="mail_host">Mail Host</label>
                <input type="text" class="btr-input" name="mail_host" value="{{ config('app.mail_host') }}">
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="mail_port">Mail Port</label>
                <input type="text" class="btr-input" name="mail_port" value="{{ config('app.mail_port') }}">
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="mail_username">Mail Username</label>
                <input type="text" class="btr-input" name="mail_username" value="{{ config('app.mail_username') }}">
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="mail_password">Mail Password</label>
                <input type="text" class="btr-input" name="mail_password" value="{{ config('app.mail_password') }}">
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="mail_encryption">Mail Encryption</label>
                <input type="text" class="btr-input" name="mail_encryption" value="{{ config('app.mail_encryption') }}">
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="mail_from_address">Mail From Address</label>
                <input type="text" class="btr-input" name="mail_from_address" value="{{ config('app.mail_from_address') }}">
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="mail_from_name">Mail From Name</label>
                <input type="text" class="btr-input" name="mail_from_name" value="{{ config('app.mail_from_name') }}">
            </div>

            <div class="btr-form-actions">
                <button type="submit" class="btr-btn">Simpan</button>
            </div>
        </form>
    </div>

    <script>
        function btrPreview(input, sel) {
            var img = document.querySelector(sel);
            var r = new FileReader();
            r.onload = function (e) { img.src = e.target.result; img.style.display = 'block'; };
            if (input.files[0]) r.readAsDataURL(input.files[0]);
        }
    </script>
@endsection
