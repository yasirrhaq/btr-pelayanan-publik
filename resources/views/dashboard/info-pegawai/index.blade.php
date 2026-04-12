@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Profil - SDM (Sumber Daya Manusia)</h1>

    <div class="btr-tabs">
        <a href="{{ url('dashboard/struktur-organisasi') }}" class="btr-tab">Struktur Organisasi</a>
        <a href="{{ url('dashboard/info-pegawai') }}" class="btr-tab active">Pegawai</a>
    </div>

    <div class="btr-tab-panel">
        <div class="btr-toolbar">
            <a href="{{ url('dashboard/info-pegawai/create') }}" class="btr-btn">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Pegawai
            </a>
            <div class="spacer"></div>
            <div class="btr-search">
                <input type="text" placeholder="Cari pegawai...">
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
                        <th>Foto</th>
                        <th>Nama Pegawai</th>
                        <th>Jabatan</th>
                        <th>Golongan</th>
                        <th>Status</th>
                        <th style="width:140px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($infoPegawai as $items)
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
                            <td>-</td>
                            <td>-</td>
                            <td><span class="btr-status publish">PNS</span></td>
                            <td>
                                <div class="btr-actions">
                                    <form action="{{ url('dashboard/info-pegawai/' . $items->id) }}" method="post" class="btr-action-form" onsubmit="return confirm('Yakin hapus data?')">
                                        @csrf
                                        @method('delete')
                                        <button class="btr-action delete" type="submit" title="Hapus">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6h14z"/></svg>
                                        </button>
                                    </form>
                                    <a href="{{ url('dashboard/info-pegawai/' . $items->id . '/edit') }}" class="btr-action edit" title="Edit">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <a href="{{ url('dashboard/info-pegawai/' . $items->id) }}" class="btr-action view" title="Lihat">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" style="color:var(--text-muted);padding:28px">Belum ada data pegawai.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
