@extends('dashboard.layouts.main')

@section('container')
    @push('head')
        <style>
            .profil-editor-wrap textarea.profil-jodit {
                min-height: 320px;
                resize: none;
            }

            .profil-editor-wrap .jodit-container:not(.jodit_inline) {
                border-radius: 14px;
                overflow: hidden;
                border: 1px solid var(--border-soft);
                background: #fff;
            }

            .profil-editor-wrap .jodit-toolbar__box,
            .profil-editor-wrap .jodit-status-bar {
                background: #f8fafc;
            }

            .profil-editor-wrap .jodit-wysiwyg,
            .profil-editor-wrap .jodit-workplace {
                min-height: 320px !important;
            }

            .profil-editor-wrap .jodit-container:focus-within {
                border-color: #355caa;
                box-shadow: 0 0 0 3px rgba(53, 92, 170, 0.12);
            }
        </style>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jodit@4.6.2/es2021/jodit.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/jodit@4.6.2/es2021/jodit.min.js"></script>
    @endpush

    <h1 class="btr-page-title">Profil <small>Edit {{ $entry->title ?? $entry->name }}</small></h1>

    @php
        $imagePath = $scope === 'url' ? $entry->path_image : $entry->path;
    @endphp

    <div class="btr-card">
        <form method="post" action="{{ url('dashboard/profil-singkat/' . $entry->id) }}" enctype="multipart/form-data">
            @method('put')
            @csrf
            <input type="hidden" name="scope" value="{{ $scope }}">
            <input type="hidden" name="tab" value="{{ $activeTab }}">
            <input type="hidden" id="remove_image" name="remove_image" value="0">

            <div class="btr-form-group">
                <label class="btr-label" for="profil_title">Judul</label>
                <input type="text" class="btr-input" id="profil_title" value="{{ $entry->title ?? $entry->name }}" readonly>
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="deskripsi">Deskripsi</label>
                <div class="profil-editor-wrap">
                    <textarea id="deskripsi" name="deskripsi" class="profil-jodit">{{ old('deskripsi', $entry->deskripsi) }}</textarea>
                </div>
                @error('deskripsi') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="path_image">Unggah Foto</label>
                <div id="profil-edit-preview-wrap" style="{{ $imagePath ? 'display:block;' : 'display:none;' }}position:relative;max-width:420px;margin-bottom:12px;">
                    <div id="profil-edit-preview-card" style="display:flex;align-items:center;gap:14px;padding:14px 16px;border:1px solid var(--border-soft);border-radius:16px;background:#fff;">
                        @if ($imagePath)
                            <img src="{{ asset($imagePath) }}" alt="{{ $entry->title ?? $entry->name }}" style="width:72px;height:72px;object-fit:cover;border-radius:12px;border:1px solid var(--border-soft);flex-shrink:0;">
                            <div style="min-width:0;flex:1;">
                                <div style="font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ basename($imagePath) }}</div>
                                <div style="font-size:12px;color:var(--text-muted);margin-top:4px;">Pratinjau gambar</div>
                                <a href="{{ asset($imagePath) }}" target="_blank" style="font-size:12px;color:var(--info-blue);text-decoration:none;">Lihat file</a>
                            </div>
                        @endif
                    </div>
                    <button type="button" onclick="btrClearProfilEditImage()" style="position:absolute;top:8px;right:8px;width:28px;height:28px;border:none;border-radius:999px;background:rgba(15,23,42,.75);color:#fff;cursor:pointer;font-size:16px;line-height:1;">&times;</button>
                </div>

                <div class="btr-file-row">
                    <label class="btr-file-pill">
                        <span class="btr-file-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16V8m0 0l-3 3m3-3l3 3"/></svg>
                        </span>
                        <input type="file" id="path_image" name="path_image" accept=".jpg,.jpeg,.png,.webp" onchange="btrPreviewProfilEditImage(this)">
                    </label>
                </div>
                @error('path_image') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-actions">
                <a href="{{ url('dashboard/profil-singkat?tab=' . $activeTab) }}" class="btr-btn btr-btn-outline">Batal</a>
                @if ($previewUrl)
                    <a href="{{ $previewUrl }}" target="_blank" class="btr-btn btr-btn-outline">Lihat</a>
                @endif
                <button type="submit" class="btr-btn">Update</button>
            </div>
        </form>
    </div>

    <script>
        Jodit.make('#deskripsi', {
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
                url: '{{ route('admin.profil-singkat.attachment') }}',
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

        function btrPreviewProfilEditImage(input) {
            var file = input.files && input.files[0];
            if (!file) return;

            document.getElementById('remove_image').value = '0';

            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('profil-edit-preview-card').innerHTML = '<img src="' + e.target.result + '" alt="Preview" style="width:72px;height:72px;object-fit:cover;border-radius:12px;border:1px solid var(--border-soft);flex-shrink:0;"><div style="min-width:0;flex:1;"><div style="font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + file.name + '</div><div style="font-size:12px;color:var(--text-muted);margin-top:4px;">Pratinjau gambar</div></div>';
                document.getElementById('profil-edit-preview-wrap').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }

        function btrClearProfilEditImage() {
            document.getElementById('path_image').value = '';
            document.getElementById('remove_image').value = '1';
            document.getElementById('profil-edit-preview-card').innerHTML = '';
            document.getElementById('profil-edit-preview-wrap').style.display = 'none';
        }
    </script>
@endsection
