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

    <h1 class="btr-page-title">Profil <small>Identitas</small></h1>

    <div class="btr-card" style="overflow:hidden;">
        <div style="display:flex;gap:0;flex-wrap:wrap;border-bottom:1px solid var(--border-soft);margin:-28px -28px 24px;padding:0 20px;background:#F8FAFC;">
            @foreach ($tabs as $key => $tab)
                <button type="button"
                    data-profil-tab-button="{{ $key }}"
                    class="{{ $activeTab === $key ? 'bg-white text-[#1E3A6B]' : 'bg-[#FCD34D] text-[#1E3A6B]' }}"
                    style="border:none;padding:16px 20px;font-weight:600;cursor:pointer;border-right:1px solid rgba(30,58,107,.08);">
                    {{ $tab['label'] }}
                </button>
            @endforeach
        </div>

        @php
            $singlePanels = [
                'tentang-kami' => $urlEntries['tentang-kami'],
                'sejarah' => $landingEntries['sejarah'],
                'maskot' => $urlEntries['maskot'],
            ];
        @endphp

        @foreach ($singlePanels as $key => $entry)
            @php
                $imagePath = $key === 'sejarah' ? $entry->path : $entry->path_image;
                $previewDisplay = $imagePath ? 'display:block;' : 'display:none;';
                $panelDisplay = $activeTab === $key ? '' : 'display:none;';
                $scope = $key === 'sejarah' ? 'landing' : 'url';
                $label = $tabs[$key]['label'];
            @endphp

            <div data-profil-panel="{{ $key }}" style="{{ $panelDisplay }}">
                <form method="post" action="{{ url('dashboard/profil-singkat/' . $entry->id) }}" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <input type="hidden" name="scope" value="{{ $scope }}">
                    <input type="hidden" name="tab" value="{{ $key }}">
                    <input type="hidden" id="remove_image_{{ $key }}" name="remove_image" value="0">

                    <div style="display:grid;grid-template-columns:140px minmax(0,1fr);gap:20px;align-items:start;">
                        <label class="btr-label" for="deskripsi_{{ $key }}" style="padding-top:12px;">Deskripsi</label>
                        <div class="profil-editor-wrap">
                            <textarea id="deskripsi_{{ $key }}" name="deskripsi" class="profil-jodit">{{ old('tab') === $key ? old('deskripsi') : $entry->deskripsi }}</textarea>
                        </div>

                        <label class="btr-label" for="path_image_{{ $key }}" style="padding-top:12px;">Unggah Foto</label>
                        <div>
                            <div id="profil-preview-wrap-{{ $key }}" style="{{ $previewDisplay }}position:relative;max-width:520px;margin-bottom:12px;">
                                <div id="profil-preview-card-{{ $key }}" style="display:flex;align-items:center;gap:14px;padding:14px 16px;border:1px solid var(--border-soft);border-radius:16px;background:#fff;">
                                    @if ($imagePath)
                                        <img src="{{ asset($imagePath) }}" alt="{{ $label }}" style="width:72px;height:72px;object-fit:cover;border-radius:12px;border:1px solid var(--border-soft);flex-shrink:0;">
                                        <div style="min-width:0;flex:1;">
                                            <div style="font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ basename($imagePath) }}</div>
                                            <div style="font-size:12px;color:var(--text-muted);margin-top:4px;">Pratinjau gambar</div>
                                            <a href="{{ asset($imagePath) }}" target="_blank" style="font-size:12px;color:var(--info-blue);text-decoration:none;">Lihat file</a>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" onclick="btrClearProfilImage('{{ $key }}')" style="position:absolute;top:8px;right:8px;width:28px;height:28px;border:none;border-radius:999px;background:rgba(15,23,42,.75);color:#fff;cursor:pointer;font-size:16px;line-height:1;">&times;</button>
                            </div>

                            <div class="btr-file-row">
                                <label class="btr-file-pill">
                                    <span class="btr-file-icon">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16V8m0 0l-3 3m3-3l3 3"/></svg>
                                    </span>
                                    <input type="file" id="path_image_{{ $key }}" name="path_image" accept=".jpg,.jpeg,.png,.webp" onchange="btrPreviewProfilImage(this,'{{ $key }}')">
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="btr-form-actions" style="margin-top:24px;justify-content:flex-start;">
                        <button type="submit" class="btr-btn">Submit</button>
                    </div>
                </form>
            </div>
        @endforeach

        <div data-profil-panel="visi-misi" style="{{ $activeTab === 'visi-misi' ? '' : 'display:none;' }}">
            <div class="btr-table-wrap">
                <table class="btr-table">
                    <thead>
                        <tr>
                            <th style="width:120px">Bagian</th>
                            <th style="width:140px">Gambar</th>
                            <th>Deskripsi</th>
                            <th style="width:110px">Status</th>
                            <th style="width:120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (['visi' => $landingEntries['visi'], 'misi' => $landingEntries['misi']] as $item)
                            <tr>
                                <td style="text-align:left;font-weight:600;">{{ $item->title }}</td>
                                <td>
                                    @if ($item->path)
                                        <img src="{{ asset($item->path) }}" class="thumb" alt="{{ $item->title }}">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="text-align:left">{!! \Illuminate\Support\Str::limit(strip_tags($item->deskripsi), 120) !!}</td>
                                <td>{{ (int) $item->status === 1 ? 'Aktif' : 'Nonaktif' }}</td>
                                <td>
                                    <div class="btr-actions">
                                        <a href="{{ url('dashboard/profil-singkat/' . $item->id . '/edit?scope=landing&tab=visi-misi') }}" class="btr-action edit" title="Edit">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </a>
                                        <a href="{{ url('/visi-misi') }}" target="_blank" class="btr-action view" title="Lihat">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div data-profil-panel="tugas-fungsi" style="{{ $activeTab === 'tugas-fungsi' ? '' : 'display:none;' }}">
            <div class="btr-table-wrap">
                <table class="btr-table">
                    <thead>
                        <tr>
                            <th style="width:120px">Bagian</th>
                            <th style="width:140px">Gambar</th>
                            <th>Deskripsi</th>
                            <th style="width:110px">Status</th>
                            <th style="width:120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (['tugas' => $landingEntries['tugas'], 'fungsi' => $landingEntries['fungsi']] as $item)
                            <tr>
                                <td style="text-align:left;font-weight:600;">{{ $item->title }}</td>
                                <td>
                                    @if ($item->path)
                                        <img src="{{ asset($item->path) }}" class="thumb" alt="{{ $item->title }}">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="text-align:left">{!! \Illuminate\Support\Str::limit(strip_tags($item->deskripsi), 120) !!}</td>
                                <td>{{ (int) $item->status === 1 ? 'Aktif' : 'Nonaktif' }}</td>
                                <td>
                                    <div class="btr-actions">
                                        <a href="{{ url('dashboard/profil-singkat/' . $item->id . '/edit?scope=landing&tab=tugas-fungsi') }}" class="btr-action edit" title="Edit">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </a>
                                        <a href="{{ url('/tugas') }}" target="_blank" class="btr-action view" title="Lihat">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.profil-jodit').forEach(function (element) {
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
        });

        (function () {
            var buttons = document.querySelectorAll('[data-profil-tab-button]');
            var panels = document.querySelectorAll('[data-profil-panel]');

            function activateTab(key) {
                buttons.forEach(function (btn) {
                    var active = btn.getAttribute('data-profil-tab-button') === key;
                    btn.style.background = active ? '#ffffff' : '#FCD34D';
                    btn.style.color = '#1E3A6B';
                });

                panels.forEach(function (panel) {
                    panel.style.display = panel.getAttribute('data-profil-panel') === key ? '' : 'none';
                });
            }

            buttons.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    activateTab(btn.getAttribute('data-profil-tab-button'));
                });
            });

            activateTab('{{ $activeTab }}');
        })();

        function btrRenderProfilCard(key, html) {
            document.getElementById('profil-preview-card-' + key).innerHTML = html;
            document.getElementById('profil-preview-wrap-' + key).style.display = 'block';
        }

        function btrPreviewProfilImage(input, key) {
            var file = input.files && input.files[0];
            if (!file) return;

            document.getElementById('remove_image_' + key).value = '0';

            var reader = new FileReader();
            reader.onload = function (e) {
                btrRenderProfilCard(key, '<img src="' + e.target.result + '" alt="Preview" style="width:72px;height:72px;object-fit:cover;border-radius:12px;border:1px solid var(--border-soft);flex-shrink:0;"><div style="min-width:0;flex:1;"><div style="font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + file.name + '</div><div style="font-size:12px;color:var(--text-muted);margin-top:4px;">Pratinjau gambar</div></div>');
            };
            reader.readAsDataURL(file);
        }

        function btrClearProfilImage(key) {
            document.getElementById('path_image_' + key).value = '';
            document.getElementById('remove_image_' + key).value = '1';
            document.getElementById('profil-preview-card-' + key).innerHTML = '';
            document.getElementById('profil-preview-wrap-' + key).style.display = 'none';
        }
    </script>
@endsection
