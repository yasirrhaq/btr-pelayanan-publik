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
                <input type="hidden" id="remove_lampiran" name="remove_lampiran" value="0">
                @if($pengumuman->lampiran_path)
                    @php
                        $lampiranName = basename($pengumuman->lampiran_path);
                        $lampiranExt = strtolower(pathinfo($pengumuman->lampiran_path, PATHINFO_EXTENSION));
                        $isLampiranImage = in_array($lampiranExt, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                    @endphp
                    <div id="lampiran-preview-wrap" style="display:block;position:relative;max-width:320px;margin-bottom:10px;">
                        <div id="lampiran-preview-card" style="display:flex;align-items:center;gap:12px;padding:12px 14px;border:1px solid var(--border-soft);border-radius:12px;background:#fff;">
                            @if($isLampiranImage)
                                <img src="{{ asset('storage/' . $pengumuman->lampiran_path) }}" alt="Lampiran" style="width:64px;height:64px;object-fit:cover;border-radius:10px;border:1px solid var(--border-soft);flex-shrink:0;">
                            @else
                                <div style="width:64px;height:64px;border-radius:10px;background:#EFF6FF;color:var(--info-blue);display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;">FILE</div>
                            @endif
                            <div style="min-width:0;flex:1;">
                                <div style="font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $lampiranName }}</div>
                                <div style="font-size:12px;color:var(--text-muted);">{{ $isLampiranImage ? 'Pratinjau gambar' : 'Lampiran dokumen' }}</div>
                                <a href="{{ asset('storage/' . $pengumuman->lampiran_path) }}" target="_blank" style="font-size:12px;color:var(--info-blue);text-decoration:none;">Lihat file</a>
                            </div>
                        </div>
                        <button type="button" onclick="btrClearLampiran()" style="position:absolute;top:8px;right:8px;width:28px;height:28px;border:none;border-radius:999px;background:rgba(15,23,42,.75);color:#fff;cursor:pointer;font-size:16px;line-height:1;">&times;</button>
                    </div>
                @else
                    <div id="lampiran-preview-wrap" style="display:none;position:relative;max-width:320px;margin-bottom:10px;">
                        <div id="lampiran-preview-card" style="display:flex;align-items:center;gap:12px;padding:12px 14px;border:1px solid var(--border-soft);border-radius:12px;background:#fff;"></div>
                        <button type="button" onclick="btrClearLampiran()" style="position:absolute;top:8px;right:8px;width:28px;height:28px;border:none;border-radius:999px;background:rgba(15,23,42,.75);color:#fff;cursor:pointer;font-size:16px;line-height:1;">&times;</button>
                    </div>
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

    <script>
        function btrRenderLampiranPreview(file) {
            var wrap = document.getElementById('lampiran-preview-wrap');
            var card = document.getElementById('lampiran-preview-card');
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

        function btrClearLampiran() {
            var input = document.getElementById('lampiran');
            var remove = document.getElementById('remove_lampiran');
            var wrap = document.getElementById('lampiran-preview-wrap');
            var card = document.getElementById('lampiran-preview-card');
            if (input) input.value = '';
            if (remove) remove.value = '1';
            if (card) card.innerHTML = '';
            if (wrap) wrap.style.display = 'none';
        }

        document.getElementById('lampiran')?.addEventListener('change', function () {
            var remove = document.getElementById('remove_lampiran');
            if (this.files.length) {
                btrRenderLampiranPreview(this.files[0]);
                if (remove) remove.value = '0';
            }
        });
    </script>
@endsection
