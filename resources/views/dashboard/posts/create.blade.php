@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Publikasi - Berita <small>Buat Berita Baru</small></h1>

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
        </style>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jodit@4.6.2/es2021/jodit.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/jodit@4.6.2/es2021/jodit.min.js"></script>
    @endpush

    <div class="btr-card">
        <form method="post" action="{{ url('dashboard/posts') }}" enctype="multipart/form-data">
            @csrf

            <div class="btr-form-group">
                <label class="btr-label" for="title">Judul</label>
                <input type="text" class="btr-input" id="title" name="title" required autofocus value="{{ old('title') }}">
                @error('title') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="slug">Slug</label>
                <input type="text" class="btr-input" name="slug" id="slug" required value="{{ old('slug') }}">
                @error('slug') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="category_id">Kategori</label>
                <select name="category_id" class="btr-select">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="btr-form-group">
                <label class="btr-label">Gambar Berita <small style="color:var(--text-muted)">(Max 1MB)</small></label>
                <div id="post-image-preview-wrap" style="display:none;position:relative;max-width:280px;margin-bottom:10px;">
                    <img class="img-preview" src="" alt="" style="display:block;width:100%;border-radius:10px;border:1px solid var(--border-soft)">
                    <button type="button" onclick="btrClearPostPreview('#image','.img-preview','#post-image-preview-wrap')" style="position:absolute;top:8px;right:8px;width:28px;height:28px;border:none;border-radius:999px;background:rgba(15,23,42,.75);color:#fff;cursor:pointer;font-size:16px;line-height:1;">&times;</button>
                </div>
                <div class="btr-file-row">
                    <label class="btr-file-pill">
                        <span class="btr-file-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16V8m0 0l-3 3m3-3l3 3M17 8v8m0 0l3-3m-3 3l-3-3"/></svg>
                        </span>
                        <input type="file" id="image" name="image" onchange="btrPreview(this,'.img-preview','#post-image-preview-wrap')" required>
                    </label>
                </div>
                @error('image') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="body">Deskripsi</label>
                <div class="post-editor-wrap">
                    <textarea id="body" name="body" class="post-jodit">{{ old('body') }}</textarea>
                </div>
                @error('body') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-actions">
                <a href="{{ url('dashboard/posts') }}" class="btr-btn btr-btn-outline">Batal</a>
                <button type="submit" class="btr-btn">Simpan</button>
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
        }
        function btrClearPostPreview(inputSel, previewSel, wrapSel) {
            var input = document.querySelector(inputSel);
            var img = document.querySelector(previewSel);
            var wrap = document.querySelector(wrapSel);
            if (input) input.value = '';
            if (img) {
                img.src = '';
            }
            if (wrap) wrap.style.display = 'none';
        }
    </script>
@endsection
