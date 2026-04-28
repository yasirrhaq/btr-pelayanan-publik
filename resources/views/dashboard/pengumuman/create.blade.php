@extends('dashboard.layouts.main')

@push('head')
    <style>
        .pengumuman-editor-wrap textarea.pengumuman-jodit {
            min-height: 320px;
            resize: none;
        }

        .pengumuman-editor-wrap .jodit-container:not(.jodit_inline) {
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid var(--border-soft);
            background: #fff;
        }

        .pengumuman-editor-wrap .jodit-toolbar__box,
        .pengumuman-editor-wrap .jodit-status-bar {
            background: #f8fafc;
        }

        .pengumuman-editor-wrap .jodit-wysiwyg,
        .pengumuman-editor-wrap .jodit-workplace {
            min-height: 320px !important;
        }

        .pengumuman-editor-wrap .jodit-container:focus-within {
            border-color: #355caa;
            box-shadow: 0 0 0 3px rgba(53, 92, 170, 0.12);
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jodit@4.6.2/es2021/jodit.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/jodit@4.6.2/es2021/jodit.min.js"></script>
@endpush

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
                <div class="pengumuman-editor-wrap">
                    <textarea name="isi" id="isi" class="pengumuman-jodit" required>{{ old('isi') }}</textarea>
                </div>
                @error('isi')
                    <p style="color:var(--danger-red); font-size:13px; margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="thumbnail">Thumbnail (opsional)</label>
                <div id="thumbnail-preview-wrap" style="display:none;position:relative;max-width:320px;margin-bottom:10px;">
                    <div id="thumbnail-preview-card" style="display:flex;align-items:center;gap:12px;padding:12px 14px;border:1px solid var(--border-soft);border-radius:12px;background:#fff;"></div>
                    <button type="button" onclick="btrClearFile('#thumbnail','#thumbnail-preview-wrap','#thumbnail-preview-card')" style="position:absolute;top:8px;right:8px;width:28px;height:28px;border:none;border-radius:999px;background:rgba(15,23,42,.75);color:#fff;cursor:pointer;font-size:16px;line-height:1;">&times;</button>
                </div>
                <input type="file" name="thumbnail" id="thumbnail" class="btr-input" accept=".jpg,.jpeg,.png,.webp">
                @error('thumbnail')
                    <p style="color:var(--danger-red); font-size:13px; margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="lampiran">Lampiran (opsional)</label>
                <div id="lampiran-preview-wrap" style="display:none;position:relative;max-width:320px;margin-bottom:10px;">
                    <div id="lampiran-preview-card" style="display:flex;align-items:center;gap:12px;padding:12px 14px;border:1px solid var(--border-soft);border-radius:12px;background:#fff;"></div>
                    <button type="button" onclick="btrClearFile('#lampiran','#lampiran-preview-wrap','#lampiran-preview-card')" style="position:absolute;top:8px;right:8px;width:28px;height:28px;border:none;border-radius:999px;background:rgba(15,23,42,.75);color:#fff;cursor:pointer;font-size:16px;line-height:1;">&times;</button>
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
        document.querySelectorAll('.pengumuman-jodit').forEach(function (element) {
            Jodit.make(element, {
                height: 420,
                toolbarAdaptive: false,
                askBeforePasteHTML: false,
                askBeforePasteFromWord: false,
                beautifyHTML: false,
                showCharsCounter: true,
                showWordsCounter: true,
                showXPathInStatusbar: false,
                buttons: [
                    'source', '|',
                    'paragraph', 'font', 'fontsize', '|',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'brush', 'ul', 'ol', '|',
                    'outdent', 'indent', '|',
                    'align', '|',
                    'image', 'table', 'link', 'hr', '|',
                    'undo', 'redo', '|',
                    'fullsize'
                ],
                controls: {
                    font: {
                        list: {
                            'Arial,Helvetica,sans-serif': 'Arial',
                            'Tahoma,Geneva,sans-serif': 'Tahoma',
                            'Times New Roman,Times,serif': 'Times New Roman',
                            'Georgia,serif': 'Georgia',
                            'Verdana,Geneva,sans-serif': 'Verdana'
                        }
                    }
                },
                uploader: {
                    url: '{{ route('admin.pengumuman.attachment') }}',
                    format: 'json',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                    },
                    filesVariableName: function () {
                        return 'file';
                    },
                    isSuccess: function (resp) {
                        return !!resp.url;
                    },
                    getMessage: function (resp) {
                        return resp.message || (resp.url ? 'Upload berhasil' : 'Upload gagal');
                    },
                    process: function (resp) {
                        return {
                            files: resp.url ? [resp.url] : [],
                            path: '',
                            baseurl: '',
                            error: resp.url ? 0 : 1,
                            msg: resp.message || ''
                        };
                    },
                    defaultHandlerSuccess: function (data) {
                        if (data.files && data.files.length) {
                            this.s.insertImage(data.files[0]);
                        }
                    },
                    error: function (e) {
                        this.j.message.error(e?.message || e || 'Upload gagal');
                    }
                },
                imageDefaultWidth: 300
            });
        });

        function btrRenderFilePreview(file, wrapSel, cardSel) {
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

        function btrClearFile(inputSel, wrapSel, cardSel) {
            var input = document.querySelector(inputSel);
            var wrap = document.querySelector(wrapSel);
            var card = document.querySelector(cardSel);
            if (input) input.value = '';
            if (card) card.innerHTML = '';
            if (wrap) wrap.style.display = 'none';
        }

        document.getElementById('thumbnail')?.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                btrRenderFilePreview(this.files[0], '#thumbnail-preview-wrap', '#thumbnail-preview-card');
            }
        });

        document.getElementById('lampiran')?.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                btrRenderFilePreview(this.files[0], '#lampiran-preview-wrap', '#lampiran-preview-card');
            }
        });
    </script>
@endsection
