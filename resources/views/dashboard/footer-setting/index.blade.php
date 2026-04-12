@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Pengaturan <small>Sistem / Footer</small></h1>

    <div class="btr-card">
        <div class="btr-table-wrap">
            <table class="btr-table">
                <thead>
                    <tr>
                        <th style="width:60px">No</th>
                        <th>Nama Kementerian</th>
                        <th>Alamat</th>
                        <th>Nomor Telepon</th>
                        <th>Email</th>
                        <th style="width:120px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($footer_setting as $items)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td style="text-align:left">{{ $items->nama_kementerian }}</td>
                            <td style="text-align:left">{{ $items->alamat }}</td>
                            <td style="text-align:left">{{ $items->no_hp }}</td>
                            <td style="text-align:left">{{ $items->email }}</td>
                            <td>
                                <div class="btr-actions">
                                    <a href="{{ url('dashboard/footer-setting/' . $items->id . '/edit') }}" class="btr-action edit" title="Edit">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="color:var(--text-muted);padding:28px">Belum ada pengaturan footer.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
