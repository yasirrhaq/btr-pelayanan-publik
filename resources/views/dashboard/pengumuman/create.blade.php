@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Tambah Pengumuman</h1>

    <div class="btr-card" style="max-width:700px;">
        <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="btr-form-group">
                <label class="btr-label" for="judul">Judul Pengumuman</label>
                <input type="text" name="judul" id="judul" class="btr-input" value="{{ old('judul') }}" required>
                @error('judul')
                    <p style="color:var(--danger-red); font-size:13px; margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="isi">Isi Pengumuman</label>
                <textarea name="isi" id="isi" class="btr-textarea" required>{{ old('isi') }}</textarea>
                @error('isi')
                    <p style="color:var(--danger-red); font-size:13px; margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="lampiran">Lampiran (opsional)</label>
                <input type="file" name="lampiran" id="lampiran" class="btr-input" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                @error('lampiran')
                    <p style="color:var(--danger-red); font-size:13px; margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            <div class="btr-form-group">
                <label style="display:flex; align-items:center; gap:8px; font-size:14px; cursor:pointer;">
                    <input type="checkbox" name="is_active" value="1" checked style="accent-color:var(--sidebar-bg);">
                    Aktifkan pengumuman
                </label>
            </div>

            <div class="btr-form-actions">
                <a href="{{ route('admin.pengumuman.index') }}" class="btr-btn btr-btn-outline">Batal</a>
                <button type="submit" class="btr-btn btr-btn-yellow">Simpan</button>
            </div>
        </form>
    </div>
@endsection
