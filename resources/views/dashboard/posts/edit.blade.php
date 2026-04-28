@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Publikasi - Berita <small>Edit Berita</small></h1>

    @push('head')
        <style>
            .post-editor-wrap textarea.post-jodit {
                min-height: 320px;
                resize: none;
            }

            .post-editor-wrap .jodit-container:not(.jodit_inline) {
                border-radius: 14px;
                overflow: hidden;
                border: 1px solid var(--border-soft);
                background: #fff;
            }

            .post-editor-wrap .jodit-toolbar__box,
            .post-editor-wrap .jodit-status-bar {
                background: #f8fafc;
            }

            .post-editor-wrap .jodit-wysiwyg,
            .post-editor-wrap .jodit-workplace {
                min-height: 320px !important;
            }

            .post-editor-wrap .jodit-container:focus-within {
                border-color: #355caa;
                box-shadow: 0 0 0 3px rgba(53, 92, 170, 0.12);
            }

            .post-attachment-card {
                position: relative;
                display: flex;
                align-items: center;
                gap: 14px;
                max-width: 540px;
                margin-bottom: 12px;
                padding: 14px 16px;
                border: 1px solid #f2dfac;
                border-radius: 16px;
                background: linear-gradient(180deg, #fff8e8 0%, #fff3d1 100%);
            }

            .post-attachment-icon {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 42px;
                height: 42px;
                border-radius: 14px;
                background: #fff;
                color: #c98700;
                box-shadow: 0 6px 16px rgba(201, 135, 0, 0.12);
                flex-shrink: 0;
            }

            .post-attachment-name {
                font-weight: 700;
                color: var(--text-primary);
                line-height: 1.45;
                word-break: break-word;
                padding-right: 40px;
            }

            .post-attachment-link {
                display: inline-block;
                margin-top: 4px;
                font-size: 12px;
                font-weight: 700;
                color: #355caa;
            }

            .post-attachment-remove {
                position: absolute;
                top: 10px;
                right: 10px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 30px;
                height: 30px;
                border: none;
                border-radius: 999px;
                background: rgba(30, 58, 107, 0.08);
                color: #1e3a6b;
                font-size: 18px;
                line-height: 1;
                cursor: pointer;
                transition: background-color .2s ease, color .2s ease;
            }

            .post-attachment-remove:hover {
                background: rgba(220, 38, 38, 0.12);
                color: #dc2626;
            }
        </style>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jodit@4.6.2/es2021/jodit.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/jodit@4.6.2/es2021/jodit.min.js"></script>
    @endpush

    <div class="btr-card">
        <form method="post" action="{{ url('dashboard/posts/' . $post->slug) }}" enctype="multipart/form-data">
            @method('put')
            @csrf

            <div class="btr-form-group">
                <label class="btr-label" for="title">Judul</label>
                <input type="text" class="btr-input" id="title" name="title" required autofocus value="{{ old('title', $post->title) }}">
                @error('title') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="slug">Slug</label>
                <input type="text" class="btr-input" name="slug" id="slug" required value="{{ old('slug', $post->slug) }}">
                @error('slug') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="category_id">Kategori</label>
                <select name="category_id" class="btr-select">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="btr-form-group">
                <label class="btr-label">Gambar Berita <small style="color:var(--text-muted)">(Max 12MB, otomatis dioptimalkan)</small></label>
                <input type="hidden" name="oldImage" value="{{ $post->image }}">
                <input type="hidden" id="remove_image" name="remove_image" value="0">
                @if ($post->image)
                    <div id="post-image-preview-wrap" style="display:block;position:relative;max-width:280px;margin-bottom:10px;">
                        <img src="{{ asset($post->image) }}" class="img-preview" style="display:block;width:100%;border-radius:10px;border:1px solid var(--border-soft)">
                        <button type="button" onclick="btrClearExistingImage()" style="position:absolute;top:8px;right:8px;width:28px;height:28px;border:none;border-radius:999px;background:rgba(15,23,42,.75);color:#fff;cursor:pointer;font-size:16px;line-height:1;">&times;</button>
                    </div>
                @else
                    <div id="post-image-preview-wrap" style="display:none;position:relative;max-width:280px;margin-bottom:10px;">
                        <img class="img-preview" src="" alt="" style="display:block;width:100%;border-radius:10px;border:1px solid var(--border-soft)">
                        <button type="button" onclick="btrClearExistingImage()" style="position:absolute;top:8px;right:8px;width:28px;height:28px;border:none;border-radius:999px;background:rgba(15,23,42,.75);color:#fff;cursor:pointer;font-size:16px;line-height:1;">&times;</button>
                    </div>
                @endif
                <div class="btr-file-row">
                    <label class="btr-file-pill">
                        <span class="btr-file-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16V8m0 0l-3 3m3-3l3 3M17 8v8m0 0l3-3m-3 3l-3-3"/></svg>
                        </span>
                        <input type="file" id="image" name="image" onchange="btrPreview(this,'.img-preview','#post-image-preview-wrap')">
                    </label>
                </div>
                @error('image') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label">Lampiran Berita <small style="color:var(--text-muted)">(Opsional, Max 5MB)</small></label>
                <input type="hidden" id="remove_lampiran" name="remove_lampiran" value="0">
                <div id="post-lampiran-card" class="post-attachment-card" style="{{ $post->lampiran_path ? '' : 'display:none;' }}">
                    <span class="post-attachment-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" d="M21.44 11.05l-8.49 8.49a5.5 5.5 0 0 1-7.78-7.78l8.49-8.48a3.5 3.5 0 0 1 4.95 4.95l-8.49 8.49a1.5 1.5 0 0 1-2.12-2.13l7.78-7.77"/></svg>
                    </span>
                    <div>
                        <div class="post-attachment-name">{{ $post->lampiran_path ? basename($post->lampiran_path) : '' }}</div>
                        @if ($post->lampiran_path)
                            <a id="post-lampiran-link" href="{{ asset('storage/' . $post->lampiran_path) }}" target="_blank" rel="noopener" class="post-attachment-link">Lihat lampiran saat ini</a>
                        @else
                            <a id="post-lampiran-link" href="#" target="_blank" rel="noopener" class="post-attachment-link" style="display:none;">Lihat lampiran saat ini</a>
                        @endif
                    </div>
                    <button type="button" class="post-attachment-remove" onclick="btrClearExistingLampiran()" aria-label="Hapus lampiran">&times;</button>
                </div>
                <div class="btr-file-row">
                    <label class="btr-file-pill">
                        <span class="btr-file-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7H5"/></svg>
                        </span>
                        <input type="file" id="lampiran" name="lampiran" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png">
                    </label>
                    <small id="lampiran-file-name" style="color:var(--text-muted);font-weight:600;"></small>
                </div>
                @error('lampiran') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="body">Deskripsi</label>
                <div class="post-editor-wrap">
                    <textarea id="body" name="body" class="post-jodit">{{ old('body', $post->body) }}</textarea>
                </div>
                @error('body') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-actions">
                <a href="{{ url('dashboard/posts') }}" class="btr-btn btr-btn-outline">Batal</a>
                <button type="submit" class="btr-btn">Update</button>
            </div>
        </form>
    </div>

    <script>
        document.querySelector('#title').addEventListener('change', function () {
            fetch('/dashboard/posts/checkSlug?title=' + this.value)
                .then(r => r.json())
                .then(d => document.querySelector('#slug').value = d.slug);
        });
        document.querySelectorAll('.post-jodit').forEach(function (element) {
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
                    url: '{{ route('admin.posts.attachment') }}',
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
        function btrPreview(input, sel, wrapSel) {
            var img = document.querySelector(sel);
            var wrap = document.querySelector(wrapSel);
            var r = new FileReader();
            r.onload = function (e) {
                img.src = e.target.result;
                if (wrap) wrap.style.display = 'block';
            };
            if (input.files[0]) r.readAsDataURL(input.files[0]);
            document.querySelector('#remove_image').value = '0';
        }
        function btrClearExistingImage() {
            var input = document.querySelector('#image');
            var img = document.querySelector('.img-preview');
            var wrap = document.querySelector('#post-image-preview-wrap');
            var remove = document.querySelector('#remove_image');
            if (input) input.value = '';
            if (img) {
                img.src = '';
            }
            if (wrap) wrap.style.display = 'none';
            if (remove) remove.value = '1';
        }
        document.querySelector('#lampiran')?.addEventListener('change', function () {
            var label = document.querySelector('#lampiran-file-name');
            var remove = document.querySelector('#remove_lampiran');
            if (label) {
                label.textContent = this.files && this.files[0] ? this.files[0].name : '';
            }
            if (remove) {
                remove.value = '0';
            }
        });
        function btrClearExistingLampiran() {
            var input = document.querySelector('#lampiran');
            var card = document.querySelector('#post-lampiran-card');
            var link = document.querySelector('#post-lampiran-link');
            var remove = document.querySelector('#remove_lampiran');
            var label = document.querySelector('#lampiran-file-name');
            if (input) input.value = '';
            if (card) card.style.display = 'none';
            if (link) {
                link.href = '#';
                link.style.display = 'none';
            }
            if (label) label.textContent = '';
            if (remove) remove.value = '1';
        }
    </script>
@endsection
