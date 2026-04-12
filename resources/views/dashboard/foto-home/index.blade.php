@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Publikasi <small>Banner Slider</small></h1>

    <div class="btr-card">
        <div class="btr-table-wrap">
            <table class="btr-table">
                <thead>
                    <tr>
                        <th style="width:60px">No</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Gambar</th>
                        <th style="width:120px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($fotoHome as $items)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td style="text-align:left">{{ $items->title }}</td>
                            <td style="text-align:left">{{ $items->deskripsi }}</td>
                            <td>
                                @if ($items->path_image)
                                    <img src="{{ asset($items->path_image) }}" class="thumb" alt="">
                                @else
                                    <div class="thumb" style="background:#E9ECF3"></div>
                                @endif
                            </td>
                            <td>
                                <div class="btr-actions">
                                    <a href="{{ url('dashboard/foto-home/' . $items->id . '/edit') }}" class="btr-action edit" title="Edit">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="color:var(--text-muted);padding:28px">Belum ada banner.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
