@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Landing Page <small>{{ $title }}</small></h1>

    <div class="btr-card">
        <div class="btr-toolbar">
            <a href="{{ url('dashboard/landing-page/create?type=' . request()->type) }}" class="btr-btn">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Buat Baru
            </a>
            <div class="spacer"></div>
            <div class="btr-search">
                <input type="text" placeholder="Cari...">
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
                        <th>Tipe</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Gambar</th>
                        <th style="width:140px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td style="text-align:left">{{ $item->attr_tipe }}</td>
                            <td style="text-align:left">{!! cutText($item->deskripsi) !!}</td>
                            <td><span class="btr-status publish">{{ $item->status }}</span></td>
                            <td>
                                @if (empty($item->path))
                                    <div class="thumb" style="background:#E9ECF3"></div>
                                @else
                                    <img src="{{ imageExists($item->path) }}" class="thumb" alt="">
                                @endif
                            </td>
                            <td>
                                <div class="btr-actions">
                                    <form action="{{ url('dashboard/landing-page/' . $item->id . '?type=' . request()->type) }}" method="post" class="btr-action-form" onsubmit="return confirm('Yakin hapus data?')">
                                        @csrf
                                        @method('delete')
                                        <button class="btr-action delete" type="submit" title="Hapus">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6h14z"/></svg>
                                        </button>
                                    </form>
                                    <a href="{{ url('dashboard/landing-page/' . $item->id . '/edit?type=' . request()->type) }}" class="btr-action edit" title="Edit">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="color:var(--text-muted);padding:28px">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
