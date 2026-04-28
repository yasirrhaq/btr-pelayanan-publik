@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Publikasi - Berita</h1>

    <div class="btr-card">
        <div class="btr-toolbar">
            <a href="{{ url('dashboard/posts/create') }}" class="btr-btn">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Buat Berita
            </a>
            <a href="{{ url('dashboard/categories') }}" class="btr-btn">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Kategori Berita
            </a>
            <div class="spacer"></div>
            <div class="btr-search">
                <input type="text" id="btr-post-search" placeholder="Cari berita...">
                <button type="button">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
                </button>
            </div>
        </div>

        <div class="btr-table-wrap">
            <table class="btr-table">
                <thead>
                    <tr>
                        <th style="width:60px">No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Lampiran</th>
                        <th>Tanggal Kegiatan</th>
                        <th>Status</th>
                        <th style="width:140px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td style="text-align:left">{{ $post->title }}</td>
                            <td>{{ $post->category->name ?? '-' }}</td>
                            <td>
                                <span class="btr-status {{ $post->lampiran_path ? 'publish' : 'non-publish' }}">
                                    {{ $post->lampiran_path ? 'Ada' : 'Kosong' }}
                                </span>
                            </td>
                            <td>{{ optional($post->created_at)->format('d/m/Y') }}</td>
                            <td><span class="btr-status publish">Publish</span></td>
                            <td>
                                <div class="btr-actions">
                                    <a href="{{ url('dashboard/posts/' . $post->slug) }}" class="btr-action view" title="Lihat">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <a href="{{ url('dashboard/posts/' . $post->slug . '/edit') }}" class="btr-action edit" title="Edit">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <form action="{{ url('dashboard/posts/' . $post->slug) }}" method="post" class="btr-action-form" onsubmit="return confirm('Yakin hapus data?')">
                                        @csrf
                                        @method('delete')
                                        <button class="btr-action delete" title="Hapus" type="submit">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6h14z"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" style="color:var(--text-muted);padding:28px">Belum ada berita.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
