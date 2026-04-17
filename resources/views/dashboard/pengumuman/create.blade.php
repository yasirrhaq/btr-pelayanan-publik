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
                <div id="lampiran-preview-wrap" style="display:none;position:relative;max-width:320px;margin-bottom:10px;">
                    <div id="lampiran-preview-card" style="display:flex;align-items:center;gap:12px;padding:12px 14px;border:1px solid var(--border-soft);border-radius:12px;background:#fff;"></div>
                    <button type="button" onclick="btrClearLampiran('#lampiran','#lampiran-preview-wrap','#lampiran-preview-card')" style="position:absolute;top:8px;right:8px;width:28px;height:28px;border:none;border-radius:999px;background:rgba(15,23,42,.75);color:#fff;cursor:pointer;font-size:16px;line-height:1;">&times;</button>
                </div>
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

    <script>
        function btrRenderLampiranPreview(file, wrapSel, cardSel) {
            var wrap = document.querySelector(wrapSel);
            var card = document.querySelector(cardSel);
            if (!wrap || !card || !file) return;

            var ext = (file.name.split('.').pop() || '').toLowerCase();
            var isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext);

            if (isImage) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    card.innerHTML = '<img src="' + e.target.result + '" alt="Lampiran" style="width:64px;height:64px;object-fit:cover;border-radius:10px;border:1px solid var(--border-soft);flex-shrink:0;"><div style="min-width:0;flex:1;"><div style="font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + file.name + '</div><div style="font-size:12px;color:var(--text-muted);">Pratinjau gambar</div></div>';
                    wrap.style.display = 'block';
                };
                reader.readAsDataURL(file);
                return;
            }

            card.innerHTML = '<div style="width:64px;height:64px;border-radius:10px;background:#EFF6FF;color:var(--info-blue);display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;">FILE</div><div style="min-width:0;flex:1;"><div style="font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + file.name + '</div><div style="font-size:12px;color:var(--text-muted);">Lampiran dokumen</div></div>';
            wrap.style.display = 'block';
        }

        function btrClearLampiran(inputSel, wrapSel, cardSel) {
            var input = document.querySelector(inputSel);
            var wrap = document.querySelector(wrapSel);
            var card = document.querySelector(cardSel);
            if (input) input.value = '';
            if (card) card.innerHTML = '';
            if (wrap) wrap.style.display = 'none';
        }

        document.getElementById('lampiran')?.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                btrRenderLampiranPreview(this.files[0], '#lampiran-preview-wrap', '#lampiran-preview-card');
            }
        });
    </script>
@endsection
