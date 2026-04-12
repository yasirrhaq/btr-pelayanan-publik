@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Profil - SDM (Sumber Daya Manusia)</h1>

    <div class="btr-tabs">
        <a href="{{ url('dashboard/struktur-organisasi') }}" class="btr-tab active">Struktur Organisasi</a>
        <a href="{{ url('dashboard/info-pegawai') }}" class="btr-tab">Pegawai</a>
    </div>

    <div class="btr-tab-panel">
        <div class="btr-toolbar">
            <a href="{{ url('dashboard/struktur-organisasi/create') }}" class="btr-btn">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Struktur Organisasi
            </a>
        </div>

        <div class="btr-table-wrap">
            <table class="btr-table">
                <thead>
                    <tr>
                        <th style="width:60px">No</th>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th style="width:140px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($strukturOrganisasi as $items)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if ($items->path_image)
                                    <img src="{{ asset($items->path_image) }}" class="thumb" alt="">
                                @else
                                    <div class="thumb" style="background:#E9ECF3"></div>
                                @endif
                            </td>
                            <td style="text-align:left">{{ $items->title }}</td>
                            <td>
                                <div class="btr-actions">
                                    <a href="{{ url('dashboard/struktur-organisasi/' . $items->id) }}" class="btr-action view" title="Lihat">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <a href="{{ url('dashboard/struktur-organisasi/' . $items->id . '/edit') }}" class="btr-action edit" title="Edit">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <form action="{{ url('dashboard/struktur-organisasi/' . $items->id) }}" method="post" class="btr-action-form" onsubmit="return confirm('Yakin hapus data?')">
                                        @csrf
                                        @method('delete')
                                        <button class="btr-action delete" type="submit" title="Hapus">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6h14z"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="color:var(--text-muted);padding:28px">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
