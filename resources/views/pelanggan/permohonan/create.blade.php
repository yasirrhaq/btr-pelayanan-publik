@extends('pelanggan.layouts.main')

@section('container')
    <h1 class="btr-page-title">Ajukan Permohonan</h1>

    {{-- Wizard Steps --}}
    <div class="btr-wizard" id="wizard-steps">
        <span class="btr-wizard-step active" data-step="1">1. Pilih Layanan</span>
        <span class="btr-wizard-step" data-step="2">2. Data Pelanggan</span>
        <span class="btr-wizard-step" data-step="3">3. Detail Permohonan</span>
        <span class="btr-wizard-step" data-step="4">4. Selesai</span>
    </div>

    <form action="{{ route('pelanggan.permohonan.store') }}" method="POST" enctype="multipart/form-data" id="permohonan-form">
        @csrf

        {{-- Step 1: Pilih Layanan --}}
        <div class="btr-card wizard-panel" id="step-1">
            <h3 style="font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 20px;">Pilih Jenis Layanan</h3>

            <div class="btr-service-grid">
                @foreach($jenisLayanan as $jl)
                    <label class="btr-service-card" data-service="{{ $jl->id }}">
                        <input type="radio" name="jenis_layanan_id" value="{{ $jl->id }}" style="display:none;" {{ old('jenis_layanan_id') == $jl->id ? 'checked' : '' }}>
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            @if(str_contains(strtolower($jl->nama), 'advis'))
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
                            @elseif(str_contains(strtolower($jl->nama), 'lab'))
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c.251.023.501.05.75.082M9.75 3.104a49.656 49.656 0 0 0-3.5 0m7.5 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c-.251.023-.501.05-.75.082m.75-.082a49.656 49.656 0 0 1 3.5 0m-3.5 0V1.5m0 0h3.75M14.25 1.5H10.5m8.25 12.75v3a2.25 2.25 0 0 1-2.25 2.25H7.5a2.25 2.25 0 0 1-2.25-2.25v-3"/>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75"/>
                            @endif
                        </svg>
                        <div class="title">{{ $jl->nama }}</div>
                    </label>
                @endforeach
            </div>

            @error('jenis_layanan_id')
                <p style="color:var(--danger-red); font-size:13px;">{{ $message }}</p>
            @enderror

            <div class="btr-form-actions">
                <button type="button" class="btr-btn btr-btn-yellow" onclick="wizardNext(2)">PILIH</button>
            </div>
        </div>

        {{-- Step 2: Data Pelanggan --}}
        <div class="btr-card wizard-panel" id="step-2" style="display:none;">
            <h3 style="font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 20px;">Konfirmasi Data Pelanggan</h3>

            <dl class="btr-data-list">
                <dt>Nama Pelanggan</dt>
                <dd>{{ $user->name }}</dd>

                <dt>Kategori Instansi</dt>
                <dd>{{ $user->kategoriInstansi->nama ?? '-' }}</dd>

                <dt>Alamat</dt>
                <dd>{{ $user->alamat ?? '-' }}</dd>

                <dt>No. Telp (WA)</dt>
                <dd>{{ $user->no_hp ?? '-' }}</dd>

                <dt>Email</dt>
                <dd>{{ $user->email }}</dd>
            </dl>

            <p style="font-size:14px; font-weight:600; color:var(--text-primary); margin:20px 0 12px;">Apakah data sudah benar?</p>

            <div class="btr-form-actions" style="justify-content:center; gap:16px;">
                <button type="button" class="btr-btn btr-btn-yellow" onclick="wizardNext(3)">BENAR</button>
                <a href="{{ route('pelanggan.profil') }}" class="btr-btn btr-btn-outline">EDIT</a>
            </div>
        </div>

        {{-- Step 3: Detail Permohonan --}}
        <div class="btr-card wizard-panel" id="step-3" style="display:none;">
            <h3 style="font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 20px;">Detail Permohonan</h3>

            <div class="btr-form-group">
                <label class="btr-label" for="perihal">Perihal / Keterangan Khusus</label>
                <textarea name="perihal" id="perihal" class="btr-textarea" placeholder="Jelaskan kebutuhan layanan Anda..." required>{{ old('perihal') }}</textarea>
                @error('perihal')
                    <p style="color:var(--danger-red); font-size:13px; margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="deskripsi">Keterangan Tambahan (opsional)</label>
                <textarea name="deskripsi" id="deskripsi" class="btr-textarea" style="min-height:80px;" placeholder="Keterangan tambahan...">{{ old('deskripsi') }}</textarea>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                <div class="btr-form-group">
                    <label class="btr-label">Unggah Surat Pengantar</label>
                    <p style="font-size:12px; color:var(--text-muted); margin-bottom:8px;">*pdf</p>
                    <label class="btr-upload-area" for="dokumen-surat">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/></svg>
                        <p>Pilih file atau drag & drop</p>
                        <input type="file" name="dokumen[]" id="dokumen-surat" accept=".pdf">
                    </label>
                </div>
                <div class="btr-form-group">
                    <label class="btr-label">Unggah Dokumen Pendukung Lainnya (opsional)</label>
                    <p style="font-size:12px; color:var(--text-muted); margin-bottom:8px;">*pdf / *jpeg / *rar / *zip</p>
                    <label class="btr-upload-area" for="dokumen-pendukung">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/></svg>
                        <p>Pilih file atau drag & drop</p>
                        <input type="file" name="dokumen[]" id="dokumen-pendukung" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                    </label>
                </div>
            </div>

            @error('dokumen.*')
                <p style="color:var(--danger-red); font-size:13px;">{{ $message }}</p>
            @enderror

            <div style="margin-top:16px;">
                <label class="btr-checkbox-label">
                    <input type="checkbox" required>
                    Saya menyetujui data yang saya isi adalah benar.
                </label>
            </div>
            <div style="margin-top:8px;">
                <label class="btr-checkbox-label">
                    <input type="checkbox" required>
                    Saya tidak akan memberikan gratifikasi dan/atau suap sehubungan dengan pelayanan kepada personil Balai Teknik Rawa, dan akan menerima sanksi apabila melanggar.
                </label>
            </div>

            <div class="btr-form-actions">
                <button type="button" class="btr-btn btr-btn-outline" onclick="wizardNext(2)">Kembali</button>
                <button type="submit" class="btr-btn btr-btn-yellow">SUBMIT</button>
            </div>
        </div>
    </form>
@endsection

@push('js')
<script>
    // Wizard navigation
    function wizardNext(step) {
        document.querySelectorAll('.wizard-panel').forEach(function(p) { p.style.display = 'none'; });
        document.getElementById('step-' + step).style.display = 'block';

        document.querySelectorAll('.btr-wizard-step').forEach(function(s) {
            var sStep = parseInt(s.getAttribute('data-step'));
            s.classList.remove('active', 'done');
            if (sStep < step) s.classList.add('done');
            if (sStep === step) s.classList.add('active');
        });
    }

    // Service card selection
    document.querySelectorAll('.btr-service-card').forEach(function(card) {
        card.addEventListener('click', function() {
            document.querySelectorAll('.btr-service-card').forEach(function(c) { c.classList.remove('selected'); });
            card.classList.add('selected');
            card.querySelector('input[type="radio"]').checked = true;
        });
        if (card.querySelector('input[type="radio"]').checked) {
            card.classList.add('selected');
        }
    });

    // File upload label update
    document.querySelectorAll('.btr-upload-area input[type="file"]').forEach(function(input) {
        input.addEventListener('change', function() {
            var label = input.closest('.btr-upload-area');
            var p = label.querySelector('p');
            if (input.files.length > 0) {
                p.textContent = input.files[0].name;
            }
        });
    });
</script>
@endpush
