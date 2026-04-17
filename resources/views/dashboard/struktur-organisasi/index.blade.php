@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Profil - Struktur Organisasi</h1>

    <div class="btr-wizard">
        <div class="btr-tabs">
            <a href="{{ url('dashboard/struktur-organisasi') }}" class="btr-tab active">Struktur Organisasi</a>
            <a href="{{ url('dashboard/info-pegawai') }}" class="btr-tab">Pegawai</a>
        </div>

        <div class="btr-tab-panel">
            <div class="btr-toolbar">
                <a href="{{ url('dashboard/struktur-organisasi/create') }}" class="btr-btn">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Tambah Struktur Organisasi
                </a>
            </div>

            <div class="btr-table-wrap">
                <table class="btr-table btr-table-struktur-organisasi">
                    <thead>
                        <tr>
                            <th class="col-no" style="width:60px">No</th>
                            <th class="col-center" style="width:160px">Gambar</th>
                            <th class="col-center" style="width:55%">Judul</th>
                            <th class="col-aksi" style="width:120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($strukturOrganisasi as $items)
                            <tr>
                                <td class="col-no">{{ $loop->iteration }}</td>
                                <td class="col-center">
                                    @if ($items->path_image)
                                        <img src="{{ asset($items->path_image) }}" class="thumb" alt="">
                                    @else
                                        <div class="thumb" style="background:#E9ECF3"></div>
                                    @endif
                                </td>
                                <td class="col-center">{{ $items->title }}</td>
                                <td class="col-aksi">
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
    </div>
@endsection

@push('styles')
    <style>
        .btr-table-struktur-organisasi tbody td:nth-child(3),
        .btr-table-struktur-organisasi thead th:nth-child(3) {
            text-align: center !important;
        }

        .btr-table-struktur-organisasi .btr-actions {
            gap: 6px;
        }
    </style>
@endpush
