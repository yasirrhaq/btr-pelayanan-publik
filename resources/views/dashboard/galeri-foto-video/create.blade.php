@extends('dashboard.layouts.main')

@php
    $type = request('tab', $activeTab ?? 'foto');
    $normalizedType = $type === 'video' ? 'video' : ($type === 'dokumen' ? 'dokumen' : 'foto');
    $dbType = $normalizedType === 'foto' ? 'image' : $normalizedType;
    $label = $normalizedType === 'foto' ? 'Foto' : ($normalizedType === 'video' ? 'Video' : 'Dokumen');
    $accept = $normalizedType === 'foto' ? 'image/*' : ($normalizedType === 'video' ? 'video/mp4,video/quicktime,video/x-msvideo,video/webm' : '.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx');
@endphp

@section('container')
    <h1 class="btr-page-title">Publikasi - Galeri <small>Upload {{ $label }}</small></h1>

    <div class="btr-wizard">
        <div class="btr-tabs">
            <a href="{{ url('dashboard/galeri/foto-video/create?tab=foto') }}" class="btr-tab {{ $normalizedType === 'foto' ? 'active' : '' }}">Foto</a>
            <a href="{{ url('dashboard/galeri/foto-video/create?tab=video') }}" class="btr-tab {{ $normalizedType === 'video' ? 'active' : '' }}">Video</a>
            <a href="{{ url('dashboard/galeri/foto-video/create?tab=dokumen') }}" class="btr-tab {{ $normalizedType === 'dokumen' ? 'active' : '' }}">Dokumen</a>
        </div>

        <div class="btr-card">
            <form method="post" action="{{ url('dashboard/galeri/foto-video') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="{{ $dbType }}">

            <div class="btr-form-group">
                <label class="btr-label" for="title">Judul</label>
                <input type="text" class="btr-input" id="title" name="title" required autofocus value="{{ old('title') }}">
                @error('title') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label">File {{ $label }}</label>
                <div id="galeri-preview-wrap" style="display:none;position:relative;max-width:320px;margin-bottom:10px;">
                    <div id="galeri-preview-card" style="display:flex;align-items:center;gap:12px;padding:12px 14px;border:1px solid var(--border-soft);border-radius:12px;background:#fff;"></div>
                    <button type="button" onclick="btrClearGaleriFile()" style="position:absolute;top:8px;right:8px;width:28px;height:28px;border:none;border-radius:999px;background:rgba(15,23,42,.75);color:#fff;cursor:pointer;font-size:16px;line-height:1;">&times;</button>
                </div>
                <div class="btr-file-row">
                    <label class="btr-file-pill">
                        <span class="btr-file-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16V8m0 0l-3 3m3-3l3 3"/></svg>
                        </span>
                        <input type="file" id="path_image" name="path_image" accept="{{ $accept }}" onchange="btrPreviewGaleri(this,'{{ $normalizedType }}')" required>
                    </label>
                </div>
                @error('path_image') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-actions">
                <a href="{{ url('dashboard/galeri/foto-video?tab=' . $normalizedType) }}" class="btr-btn btr-btn-outline">Batal</a>
                <button type="submit" class="btr-btn">Simpan</button>
            </div>
            </form>
        </div>
    </div>

    <script>
        function btrRenderGaleriCard(html) {
            document.getElementById('galeri-preview-card').innerHTML = html;
            document.getElementById('galeri-preview-wrap').style.display = 'block';
        }

        function btrPreviewGaleri(input, type) {
            var file = input.files && input.files[0];
            if (!file) return;

            if (type === 'foto') {
                var reader = new FileReader();
                reader.onload = function (e) {
                    btrRenderGaleriCard('<img src="' + e.target.result + '" alt="Preview" style="width:64px;height:64px;object-fit:cover;border-radius:10px;border:1px solid var(--border-soft);flex-shrink:0;"><div style="min-width:0;flex:1;"><div style="font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + file.name + '</div><div style="font-size:12px;color:var(--text-muted);">Pratinjau gambar</div></div>');
                };
                reader.readAsDataURL(file);
                return;
            }

            var label = type === 'video' ? 'VIDEO' : 'DOC';
            var note = type === 'video' ? 'File video' : 'Dokumen lampiran';
            var bg = type === 'video' ? '#0f172a' : '#EFF6FF';
            var color = type === 'video' ? '#ffffff' : '#2563EB';

            btrRenderGaleriCard('<div style="width:64px;height:64px;border-radius:10px;background:' + bg + ';color:' + color + ';display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;">' + label + '</div><div style="min-width:0;flex:1;"><div style="font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + file.name + '</div><div style="font-size:12px;color:var(--text-muted);">' + note + '</div></div>');
        }

        function btrClearGaleriFile() {
            document.getElementById('path_image').value = '';
            document.getElementById('galeri-preview-card').innerHTML = '';
            document.getElementById('galeri-preview-wrap').style.display = 'none';
        }
    </script>
@endsection
