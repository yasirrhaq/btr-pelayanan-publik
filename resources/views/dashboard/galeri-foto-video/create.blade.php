@extends('dashboard.layouts.main')

@php
    $type = request('tab', $activeTab ?? 'foto');
    $normalizedType = $type === 'video' ? 'video' : ($type === 'dokumen' ? 'dokumen' : 'foto');
    $dbType = $normalizedType === 'foto' ? 'image' : $normalizedType;
    $label = $normalizedType === 'foto' ? 'Foto' : ($normalizedType === 'video' ? 'Video' : 'Dokumen');
    $accept = $normalizedType === 'foto' ? 'image/*' : ($normalizedType === 'video' ? 'video/mp4,video/quicktime,video/x-msvideo,video/webm' : '.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx');
    $isVideo = $normalizedType === 'video';
    $selectedSourceType = old('source_type', 'upload');
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

            @if ($isVideo)
                <div class="btr-form-group">
                    <label class="btr-label" for="category">Kategori Video</label>
                    <select class="btr-select" id="category" name="category" required>
                        <option value="">Pilih kategori</option>
                        @foreach ($videoCategories as $videoCategory)
                            <option value="{{ $videoCategory }}" @selected(old('category') === $videoCategory)>{{ $videoCategory }}</option>
                        @endforeach
                    </select>
                    @error('category') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
                </div>

                <div class="btr-form-group">
                    <label class="btr-label" for="source_type">Sumber Video</label>
                    <select class="btr-select" id="source_type" name="source_type" onchange="btrToggleVideoSource()" required>
                        <option value="upload" @selected($selectedSourceType === 'upload')>Upload Video</option>
                        <option value="youtube" @selected($selectedSourceType === 'youtube')>YouTube URL</option>
                    </select>
                    @error('source_type') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
                </div>
            @endif

            <div class="btr-form-group">
                <label class="btr-label">{{ $isVideo ? 'Media Video' : ('File ' . $label) }}</label>
                <div id="galeri-preview-wrap" style="display:none;position:relative;max-width:320px;margin-bottom:10px;">
                    <div id="galeri-preview-card" style="display:flex;align-items:center;gap:12px;padding:12px 14px;border:1px solid var(--border-soft);border-radius:12px;background:#fff;"></div>
                    <button type="button" onclick="btrClearGaleriFile()" style="position:absolute;top:8px;right:8px;width:28px;height:28px;border:none;border-radius:999px;background:rgba(15,23,42,.75);color:#fff;cursor:pointer;font-size:16px;line-height:1;">&times;</button>
                </div>
                <div id="video-upload-field" style="{{ $isVideo && $selectedSourceType === 'youtube' ? 'display:none;' : '' }}">
                    <div class="btr-file-row">
                        <label class="btr-file-pill">
                            <span class="btr-file-icon">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16V8m0 0l-3 3m3-3l3 3"/></svg>
                            </span>
                            <input type="file" id="path_image" name="path_image" accept="{{ $accept }}" onchange="btrPreviewGaleri(this,'{{ $normalizedType }}')" {{ !$isVideo || $selectedSourceType === 'upload' ? 'required' : '' }}>
                        </label>
                    </div>
                    @if ($isVideo)
                        <small style="color:var(--text-muted)">Format upload: MP4, MOV, AVI, atau WEBM.</small>
                    @endif
                </div>

                @if ($isVideo)
                    <div id="video-youtube-field" style="{{ $selectedSourceType === 'youtube' ? '' : 'display:none;' }}">
                        <input
                            type="url"
                            class="btr-input"
                            id="source_url"
                            name="source_url"
                            value="{{ old('source_url') }}"
                            placeholder="https://www.youtube.com/watch?v=..."
                            {{ $selectedSourceType === 'youtube' ? 'required' : '' }}
                        >
                        <small style="display:block;margin-top:8px;color:var(--text-muted)">Simpan dulu videonya, lalu admin bisa pakai tombol <strong>Copy Embed</strong> atau <strong>Copy URL</strong> untuk ditempel ke Jodit berita/pengumuman.</small>
                    </div>
                @endif

                @error('path_image') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
                @error('source_url') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
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

        function btrToggleVideoSource() {
            var sourceSelect = document.getElementById('source_type');
            if (!sourceSelect) return;

            var uploadWrap = document.getElementById('video-upload-field');
            var youtubeWrap = document.getElementById('video-youtube-field');
            var fileInput = document.getElementById('path_image');
            var urlInput = document.getElementById('source_url');
            var isYoutube = sourceSelect.value === 'youtube';

            if (uploadWrap) uploadWrap.style.display = isYoutube ? 'none' : '';
            if (youtubeWrap) youtubeWrap.style.display = isYoutube ? '' : 'none';

            if (fileInput) {
                fileInput.required = !isYoutube;
                if (isYoutube) {
                    fileInput.value = '';
                    btrClearGaleriFile();
                }
            }

            if (urlInput) {
                urlInput.required = isYoutube;
            }
        }

        btrToggleVideoSource();
    </script>
@endsection
