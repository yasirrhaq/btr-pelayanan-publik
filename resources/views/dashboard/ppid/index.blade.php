@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Publikasi - PPID</h1>

    @push('head')
        <style>
            .ppid-editor-wrap textarea.ppid-ckeditor {
                min-height: 320px;
                resize: none;
            }

            .ppid-editor-wrap .jodit-container:not(.jodit_inline) {
                border-radius: 14px;
                overflow: hidden;
                border: 1px solid var(--border-soft);
                background: #fff;
            }

            .ppid-editor-wrap .jodit-toolbar__box,
            .ppid-editor-wrap .jodit-status-bar {
                background: #f8fafc;
            }

            .ppid-editor-wrap .jodit-wysiwyg,
            .ppid-editor-wrap .jodit-workplace {
                min-height: 320px !important;
            }

            .ppid-editor-wrap .jodit-container:focus-within {
                border-color: #355caa;
                box-shadow: 0 0 0 3px rgba(53, 92, 170, 0.12);
            }
        </style>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jodit@4.6.2/es2021/jodit.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/jodit@4.6.2/es2021/jodit.min.js"></script>
    @endpush

    <div class="btr-wizard">
        <div class="btr-tabs">
            @foreach ($tabMeta as $key => $meta)
                <button type="button"
                    data-ppid-tab-button="{{ $key }}"
                    class="btr-tab {{ $activeTab === $key ? 'active' : '' }}">
                    {{ $meta['label'] }}
                </button>
            @endforeach
        </div>

        @foreach ($tabMeta as $key => $meta)
            @php
                $type = $types[$key];
                $entry = $entries->get($type->id);
                $isImage = $entry && $entry->path && in_array(strtolower(pathinfo($entry->path, PATHINFO_EXTENSION)), ['jpg','jpeg','png','gif','webp']);
                $previewDisplay = $entry && $entry->path ? 'display:block;' : 'display:none;';
                $panelDisplay = $activeTab === $key ? '' : 'display:none;';
            @endphp

            <div data-ppid-panel="{{ $key }}" class="btr-tab-panel" style="{{ $panelDisplay }}">
                <form method="post" action="{{ route('admin.ppid.save') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="ppid_type" value="{{ $key }}">
                    <input type="hidden" id="remove_dokumen_{{ $key }}" name="remove_dokumen" value="0">

                    <div style="display:grid;grid-template-columns:140px minmax(0,1fr);gap:20px;align-items:start;">
                        <label class="btr-label" for="title_{{ $key }}" style="padding-top:12px;">Judul</label>
                        <div>
                            <input type="text" id="title_{{ $key }}" name="title" class="btr-input" value="{{ old('ppid_type') === $key ? old('title') : ($entry->title ?? $meta['type_title']) }}" required>
                        </div>

                        <label class="btr-label" for="deskripsi_{{ $key }}" style="padding-top:12px;">Isi {{ $meta['label'] }}</label>
                        <div class="ppid-editor-wrap">
                            <textarea id="deskripsi_{{ $key }}" name="deskripsi" class="ppid-ckeditor">{{ old('ppid_type') === $key ? old('deskripsi') : ($entry->deskripsi ?? '') }}</textarea>
                        </div>

                        <label class="btr-label" for="dokumen_{{ $key }}" style="padding-top:12px;">Unggah Dokumen</label>
                        <div>
                            <div id="ppid-preview-wrap-{{ $key }}" style="{{ $previewDisplay }}position:relative;max-width:520px;margin-bottom:12px;">
                                <div id="ppid-preview-card-{{ $key }}" style="display:flex;align-items:center;gap:14px;padding:14px 16px;border:1px solid var(--border-soft);border-radius:16px;background:#fff;">
                                    @if ($entry && $entry->path)
                                        @if ($isImage)
                                            <img src="{{ asset($entry->path) }}" alt="Dokumen" style="width:72px;height:72px;object-fit:cover;border-radius:12px;border:1px solid var(--border-soft);flex-shrink:0;">
                                        @else
                                            <div style="width:72px;height:72px;border-radius:12px;background:#EFF6FF;color:#2563EB;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;">FILE</div>
                                        @endif
                                        <div style="min-width:0;flex:1;">
                                            <div style="font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ basename($entry->path) }}</div>
                                            <div style="font-size:12px;color:var(--text-muted);margin-top:4px;">{{ $isImage ? 'Pratinjau gambar' : 'Dokumen terunggah' }}</div>
                                            <a href="{{ asset($entry->path) }}" target="_blank" style="font-size:12px;color:var(--info-blue);text-decoration:none;">Lihat file</a>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" onclick="btrClearPpidFile('{{ $key }}')" style="position:absolute;top:8px;right:8px;width:28px;height:28px;border:none;border-radius:999px;background:rgba(15,23,42,.75);color:#fff;cursor:pointer;font-size:16px;line-height:1;">&times;</button>
                            </div>

                            <div class="btr-file-row">
                                <label class="btr-file-pill">
                                    <span class="btr-file-icon">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16V8m0 0l-3 3m3-3l3 3"/></svg>
                                    </span>
                                    <input type="file" id="dokumen_{{ $key }}" name="dokumen" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.webp" onchange="btrPreviewPpidFile(this,'{{ $key }}')">
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="btr-form-actions" style="margin-top:24px;justify-content:flex-end;">
                        <button type="submit" class="btr-btn">Submit</button>
                    </div>
                </form>
            </div>
        @endforeach
    </div>

    <script>
        document.querySelectorAll('.ppid-ckeditor').forEach(function (element) {
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
                    url: '{{ route('admin.ppid.attachment') }}',
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

        (function () {
            var buttons = document.querySelectorAll('[data-ppid-tab-button]');
            var panels = document.querySelectorAll('[data-ppid-panel]');

            function activateTab(key) {
                buttons.forEach(function (btn) {
                    var active = btn.getAttribute('data-ppid-tab-button') === key;
                    btn.classList.toggle('active', active);
                });

                panels.forEach(function (panel) {
                    panel.style.display = panel.getAttribute('data-ppid-panel') === key ? '' : 'none';
                });
            }

            buttons.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    activateTab(btn.getAttribute('data-ppid-tab-button'));
                });
            });

            activateTab('{{ $activeTab }}');
        })();

        function btrRenderPpidCard(key, html) {
            document.getElementById('ppid-preview-card-' + key).innerHTML = html;
            document.getElementById('ppid-preview-wrap-' + key).style.display = 'block';
        }

        function btrPreviewPpidFile(input, key) {
            var file = input.files && input.files[0];
            if (!file) return;

            document.getElementById('remove_dokumen_' + key).value = '0';

            var ext = (file.name.split('.').pop() || '').toLowerCase();
            var isImage = ['jpg','jpeg','png','gif','webp'].includes(ext);

            if (isImage) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    btrRenderPpidCard(key, '<img src="' + e.target.result + '" alt="Dokumen" style="width:72px;height:72px;object-fit:cover;border-radius:12px;border:1px solid var(--border-soft);flex-shrink:0;"><div style="min-width:0;flex:1;"><div style="font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + file.name + '</div><div style="font-size:12px;color:var(--text-muted);margin-top:4px;">Pratinjau gambar</div></div>');
                };
                reader.readAsDataURL(file);
                return;
            }

            btrRenderPpidCard(key, '<div style="width:72px;height:72px;border-radius:12px;background:#EFF6FF;color:#2563EB;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;">FILE</div><div style="min-width:0;flex:1;"><div style="font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + file.name + '</div><div style="font-size:12px;color:var(--text-muted);margin-top:4px;">Dokumen terunggah</div></div>');
        }

        function btrClearPpidFile(key) {
            document.getElementById('dokumen_' + key).value = '';
            document.getElementById('remove_dokumen_' + key).value = '1';
            document.getElementById('ppid-preview-card-' + key).innerHTML = '';
            document.getElementById('ppid-preview-wrap-' + key).style.display = 'none';
        }
    </script>
@endsection
