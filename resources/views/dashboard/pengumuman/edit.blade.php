@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Edit Pengumuman</h1>

    <div class="btr-card" style="max-width:700px;">
        <form action="{{ route('admin.pengumuman.update', $pengumuman) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="btr-form-group">
                <label class="btr-label" for="judul">Judul Pengumuman</label>
                <input type="text" name="judul" id="judul" class="btr-input" value="{{ old('judul', $pengumuman->judul) }}" required>
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="isi">Isi Pengumuman</label>
                <textarea name="isi" id="isi" class="btr-textarea" required>{{ old('isi', $pengumuman->isi) }}</textarea>
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="lampiran">Lampiran (opsional)</label>
                @if($pengumuman->lampiran_path)
                    <p style="font-size:13px; color:var(--text-muted); margin-bottom:8px;">
                        File saat ini: <a href="{{ asset('storage/' . $pengumuman->lampiran_path) }}" target="_blank" style="color:var(--info-blue);">Lihat</a>
                    </p>
                @endif
                <input type="file" name="lampiran" id="lampiran" class="btr-input" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
            </div>

            <div class="btr-form-group">
                <label style="display:flex; align-items:center; gap:8px; font-size:14px; cursor:pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ $pengumuman->is_active ? 'checked' : '' }} style="accent-color:var(--sidebar-bg);">
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
