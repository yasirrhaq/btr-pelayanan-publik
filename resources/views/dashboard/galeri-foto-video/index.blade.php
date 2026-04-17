@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Publikasi - Galeri</h1>

    <div class="btr-tabs">
        <a href="{{ url('dashboard/galeri/foto-video?tab=foto') }}" class="btr-tab {{ $activeTab === 'foto' ? 'active' : '' }}">Foto</a>
        <a href="{{ url('dashboard/galeri/foto-video?tab=video') }}" class="btr-tab {{ $activeTab === 'video' ? 'active' : '' }}">Video</a>
        <a href="{{ url('dashboard/galeri/foto-video?tab=dokumen') }}" class="btr-tab {{ $activeTab === 'dokumen' ? 'active' : '' }}">Dokumen</a>
    </div>

    <div class="btr-tab-panel">
        <div class="btr-toolbar">
            <a href="{{ url('dashboard/galeri/foto-video/create?tab=' . $activeTab) }}" class="btr-btn">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                {{ $activeTab === 'foto' ? 'Upload Foto' : ($activeTab === 'video' ? 'Upload Video' : 'Upload Dokumen') }}
            </a>
            <div class="spacer"></div>
            <div class="btr-search">
                <input type="text" placeholder="Cari {{ $activeTab }}...">
                <button type="button">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
                </button>
            </div>
        </div>

        <div class="btr-gallery-grid">
            @forelse ($fotoVideo as $items)
                <div class="btr-gallery-card">
                    <div class="tanggal">Tanggal: {{ optional($items->created_at)->format('d/m/Y') }}</div>
                    @if ($items->type === 'video')
                        <div class="thumb" style="display:flex;align-items:center;justify-content:center;background:#0f172a;color:#fff;font-weight:700;">VIDEO</div>
                    @elseif ($items->type === 'dokumen')
                        <div class="thumb" style="display:flex;align-items:center;justify-content:center;background:#EFF6FF;color:#2563EB;font-weight:700;">DOC</div>
                    @elseif ($items->path_image)
                        <img src="{{ asset($items->path_image) }}" class="thumb" alt="">
                    @else
                        <div class="thumb"></div>
                    @endif
                    <div class="judul">{{ $items->title }}</div>
                    <div class="deskripsi">-</div>
                    <div class="footer">
                        <form action="{{ url('dashboard/galeri/foto-video/' . $items->id) }}" method="post" class="btr-action-form" onsubmit="return confirm('Yakin hapus data?')">
                            @csrf
                            @method('delete')
                            <button class="btr-action delete" type="submit" title="Hapus">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6h14z"/></svg>
                            </button>
                        </form>
                        <a href="{{ url('dashboard/galeri/foto-video/' . $items->id . '/edit') }}" class="btr-action edit" title="Edit">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </a>
                        <a href="{{ url('dashboard/galeri/foto-video/' . $items->id) }}" class="btr-action view" title="Lihat">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div style="color:var(--text-muted);grid-column:1/-1;padding:28px;text-align:center">
                    @if ($activeTab === 'foto')
                        Belum ada foto.
                    @elseif ($activeTab === 'video')
                        Belum ada video.
                    @else
                        Belum ada dokumen.
                    @endif
                </div>
            @endforelse
        </div>
    </div>
@endsection
