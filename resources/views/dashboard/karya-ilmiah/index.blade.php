@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Publikasi - Karya Ilmiah</h1>

    <div class="btr-card">
        <div class="btr-toolbar">
            <a href="{{ url('dashboard/karya-ilmiah/create') }}" class="btr-btn">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Karya Ilmiah
            </a>
            <div class="spacer"></div>
            <div class="btr-search">
                <input type="text" placeholder="Cari karya ilmiah...">
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
                        <th>Penerbit</th>
                        <th>Tanggal Terbit</th>
                        <th>ISSN Online</th>
                        <th>ISSN Cetak</th>
                        <th style="width:140px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($karyaIlmiah as $karya)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td style="text-align:left">{{ $karya->title }}</td>
                            <td>{{ $karya->penerbit }}</td>
                            <td>{{ $karya->tanggal_terbit }}</td>
                            <td>{{ $karya->issn_online }}</td>
                            <td>{{ $karya->issn_cetak }}</td>
                            <td>
                                <div class="btr-actions">
                                    <a href="{{ url('dashboard/karya-ilmiah/' . $karya->slug . '/edit') }}" class="btr-action edit" title="Edit">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <form action="{{ url('dashboard/karya-ilmiah/' . $karya->slug) }}" method="post" class="btr-action-form" onsubmit="return confirm('Yakin hapus data?')">
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
                        <tr><td colspan="7" style="color:var(--text-muted);padding:28px">Belum ada karya ilmiah.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
