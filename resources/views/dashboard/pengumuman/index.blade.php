@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Manajemen Pengumuman</h1>

    <div class="btr-toolbar">
        <a href="{{ route('admin.pengumuman.create') }}" class="btr-btn btr-btn-yellow">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Pengumuman
        </a>
    </div>

    <div class="btr-card">
        <div class="btr-table-wrap">
            <table class="btr-table">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Lampiran</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengumuman as $p)
                        <tr>
                            <td style="text-align:left; font-weight:500;">{{ \Illuminate\Support\Str::limit($p->judul, 60) }}</td>
                            <td>
                                @if($p->is_active)
                                    <span class="btr-status aktif">Aktif</span>
                                @else
                                    <span class="btr-status tidak-aktif">Non-aktif</span>
                                @endif
                            </td>
                            <td>
                                @if($p->lampiran_path)
                                    @php
                                        $attachmentUrl = asset('storage/' . $p->lampiran_path);
                                        $extension = strtolower(pathinfo($p->lampiran_path, PATHINFO_EXTENSION));
                                    @endphp
                                    <button
                                        type="button"
                                        class="pengumuman-preview-trigger"
                                        data-title='@json($p->judul)'
                                        data-url='@json($attachmentUrl)'
                                        data-extension='@json($extension)'
                                        data-filename='@json(basename($p->lampiran_path))'
                                        style="color:var(--info-blue); font-size:12px; font-weight:600; background:none; border:none; cursor:pointer;"
                                    >Lihat</button>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $p->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btr-actions">
                                    <a href="{{ route('admin.pengumuman.edit', $p) }}" class="btr-action edit" title="Edit">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-1.414-9.414a2 2 0 1 1 2.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.pengumuman.destroy', $p) }}" method="POST" class="btr-action-form" onsubmit="return confirm('Yakin hapus pengumuman ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btr-action delete" title="Hapus">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="color:var(--text-muted);">Belum ada pengumuman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pengumuman->hasPages())
            <div style="margin-top:20px; display:flex; justify-content:center;">
                {{ $pengumuman->links() }}
            </div>
        @endif

        <div id="pengumuman-preview-modal" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,.72); align-items:center; justify-content:center; padding:24px; z-index:9999;">
            <div data-close-preview style="position:absolute; inset:0;"></div>
            <div style="position:relative; width:min(960px, 100%); max-height:90vh; background:#fff; border-radius:20px; box-shadow:0 20px 60px rgba(15,23,42,.28); overflow:hidden; z-index:1; display:flex; flex-direction:column;">
                <div style="display:flex; align-items:center; justify-content:space-between; gap:16px; padding:18px 22px; border-bottom:1px solid #E5E7EB;">
                    <div>
                        <h3 id="pengumuman-preview-title" style="margin:0; font-size:18px; font-weight:700; color:var(--text-primary);">Lampiran Pengumuman</h3>
                        <p id="pengumuman-preview-filename" style="margin:4px 0 0; font-size:12px; color:var(--text-muted);"></p>
                    </div>
                    <button type="button" data-close-preview style="width:40px; height:40px; border:none; border-radius:999px; background:#F3F4F6; color:#334155; cursor:pointer; font-size:18px;">&times;</button>
                </div>

                <div style="padding:22px; overflow:auto;">
                    <img id="pengumuman-preview-image" alt="Lampiran Pengumuman" style="display:none; width:100%; max-height:70vh; object-fit:contain; border-radius:14px; background:#F8FAFC;">
                    <iframe id="pengumuman-preview-pdf" title="Preview lampiran pengumuman" style="display:none; width:100%; height:70vh; border:none; border-radius:14px; background:#F8FAFC;"></iframe>
                    <div id="pengumuman-preview-download-only" style="display:none; border:1px dashed #CBD5E1; border-radius:16px; padding:32px 24px; text-align:center; background:#F8FAFC;">
                        <div style="width:64px; height:64px; margin:0 auto 16px; border-radius:999px; background:#FEF3C7; color:#B45309; display:flex; align-items:center; justify-content:center; font-size:24px;">
                            <i class="fas fa-paperclip"></i>
                        </div>
                        <h4 style="margin:0 0 8px; font-size:18px; font-weight:700; color:#0F172A;">File tidak bisa dipratinjau langsung</h4>
                        <p style="margin:0; font-size:14px; color:#64748B;">Silakan buka atau unduh lampiran untuk melihat isinya.</p>
                    </div>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:12px; padding:18px 22px; border-top:1px solid #E5E7EB; background:#F8FAFC;">
                    <a id="pengumuman-preview-link" href="#" target="_blank" rel="noopener noreferrer" style="display:inline-flex; align-items:center; gap:8px; background:var(--info-blue); color:#fff; padding:10px 16px; border-radius:10px; text-decoration:none; font-size:13px; font-weight:600;">
                        <i class="fas fa-arrow-up-right-from-square"></i>
                        Buka File
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var modal = document.getElementById('pengumuman-preview-modal');
            if (!modal) return;

            var title = document.getElementById('pengumuman-preview-title');
            var filename = document.getElementById('pengumuman-preview-filename');
            var image = document.getElementById('pengumuman-preview-image');
            var pdf = document.getElementById('pengumuman-preview-pdf');
            var downloadOnly = document.getElementById('pengumuman-preview-download-only');
            var link = document.getElementById('pengumuman-preview-link');

            function resetPreview() {
                image.style.display = 'none';
                image.removeAttribute('src');
                pdf.style.display = 'none';
                pdf.removeAttribute('src');
                downloadOnly.style.display = 'none';
            }

            function closePreview() {
                modal.style.display = 'none';
                document.body.style.overflow = '';
                resetPreview();
            }

            document.querySelectorAll('.pengumuman-preview-trigger').forEach(function (button) {
                button.addEventListener('click', function () {
                    var data = button.dataset;
                    var extension = (data.extension || '').toLowerCase();
                    title.textContent = data.title || 'Lampiran Pengumuman';
                    filename.textContent = data.filename || '';
                    link.href = data.url || '#';
                    resetPreview();

                    if (['jpg', 'jpeg', 'png'].includes(extension)) {
                        image.src = data.url;
                        image.style.display = 'block';
                    } else if (extension === 'pdf') {
                        pdf.src = data.url;
                        pdf.style.display = 'block';
                    } else {
                        downloadOnly.style.display = 'block';
                    }

                    modal.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                });
            });

            modal.querySelectorAll('[data-close-preview]').forEach(function (element) {
                element.addEventListener('click', closePreview);
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && modal.style.display === 'flex') {
                    closePreview();
                }
            });
        })();
    </script>
@endsection
