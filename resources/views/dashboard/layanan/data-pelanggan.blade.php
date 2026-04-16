@extends('dashboard.layanan.layouts.main')

@section('container')
    <h1 class="btr-page-title">Data Pelanggan</h1>

    <div class="btr-card" style="padding:16px 24px;">
        <form method="GET" action="{{ route('admin.layanan.dataPelanggan') }}" style="display:flex; gap:12px; align-items:center;">
            <div class="btr-search" style="flex:1;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email pelanggan...">
                <button type="submit">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
                </button>
            </div>
        </form>
    </div>

    <div class="btr-card">
        <div class="btr-table-wrap">
            <table class="btr-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Kategori Instansi</th>
                        <th>Jumlah Permohonan</th>
                        <th>Terdaftar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggan as $user)
                        <tr>
                            <td style="text-align:left; font-weight:500;">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->no_hp ?? '-' }}</td>
                            <td>{{ $user->kategoriInstansi->nama ?? '-' }}</td>
                            <td>{{ $user->permohonan_count }}</td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="color:var(--text-muted);">Belum ada data pelanggan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pelanggan->hasPages())
            <div style="margin-top:20px; display:flex; justify-content:center;">
                {{ $pelanggan->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection
