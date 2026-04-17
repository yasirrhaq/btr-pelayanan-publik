@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Profil - SDM (Sumber Daya Manusia)</h1>

    @push('head')
        <style>
            .info-pegawai-table thead th {
                font-size: 12px;
                letter-spacing: 0.02em;
                white-space: nowrap;
            }

            .info-pegawai-table .col-no,
            .info-pegawai-table .col-foto,
            .info-pegawai-table .col-status,
            .info-pegawai-table .col-aksi {
                text-align: center;
            }

            .info-pegawai-table .col-nama,
            .info-pegawai-table .col-jabatan,
            .info-pegawai-table .col-golongan {
                text-align: left;
            }

            .info-pegawai-table tbody td.col-nama {
                min-width: 280px;
                font-weight: 600;
                color: var(--text-primary);
            }

            .info-pegawai-table tbody td.col-jabatan {
                min-width: 340px;
            }

            .info-pegawai-table tbody td.col-golongan {
                min-width: 170px;
                white-space: nowrap;
            }

            .info-pegawai-table .thumb {
                width: 56px;
                height: 56px;
                border-radius: 14px;
                object-fit: cover;
            }

            .info-pegawai-actions {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
            }

            .info-pegawai-actions .btr-action-form {
                display: inline-flex;
                order: 1;
            }

            .info-pegawai-actions .btr-action.edit {
                order: 2;
            }

            .info-pegawai-actions .btr-action.view {
                order: 3;
            }
        </style>
    @endpush

    <div class="btr-tabs">
        <a href="{{ url('dashboard/struktur-organisasi') }}" class="btr-tab">Struktur Organisasi</a>
        <a href="{{ url('dashboard/info-pegawai') }}" class="btr-tab active">Pegawai</a>
    </div>

    <div class="btr-tab-panel">
        <div class="btr-toolbar">
            <a href="{{ url('dashboard/info-pegawai/create') }}" class="btr-btn">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Tambah Pegawai
            </a>
            <div class="spacer"></div>
            <form method="get" action="{{ url('dashboard/info-pegawai') }}" class="btr-search">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, jabatan, golongan...">
                <button type="submit">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
                </button>
            </form>
        </div>

        <div class="btr-table-wrap">
            <table class="btr-table info-pegawai-table">
                <thead>
                    <tr>
                        <th class="col-no" style="width:72px">No</th>
                        <th class="col-foto" style="width:92px">Foto</th>
                        <th class="col-nama">Nama Pegawai</th>
                        <th class="col-jabatan">Jabatan</th>
                        <th class="col-golongan">Golongan</th>
                        <th class="col-status" style="width:120px">Status</th>
                        <th class="col-aksi" style="width:140px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($infoPegawai as $items)
                        <tr>
                            <td class="col-no">{{ $infoPegawai->firstItem() + $loop->index }}</td>
                            <td class="col-foto">
                                @if ($items->path_image)
                                    <img src="{{ asset($items->path_image) }}" class="thumb" alt="">
                                @else
                                    <div class="thumb" style="background:#E9ECF3"></div>
                                @endif
                            </td>
                            <td class="col-nama">{{ $items->title }}</td>
                            <td class="col-jabatan">{{ $items->jabatan ?: '-' }}</td>
                            <td class="col-golongan">{{ $items->pangkat_golongan ?: '-' }}</td>
                            <td class="col-status"><span class="btr-status publish">{{ $items->jenis_kepegawaian ?: 'PNS' }}</span></td>
                            <td class="col-aksi">
                                <div class="btr-actions info-pegawai-actions">
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

        <div class="btr-pagination-wrap">
            {{ $infoPegawai->onEachSide(1)->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
