@extends('dashboard.layanan.layouts.main')

@section('container')
    <h1 class="btr-page-title">Daftar Permohonan</h1>

    {{-- Filters --}}
    <div class="btr-card" style="padding:16px 24px;">
        <form method="GET" action="{{ route('admin.layanan.permohonan.index') }}" style="display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
            <select name="jenis_layanan_id" class="btr-select" style="width:auto; min-width:180px;">
                <option value="">Semua Layanan</option>
                @foreach($jenisLayanan as $jl)
                    <option value="{{ $jl->id }}" {{ request('jenis_layanan_id') == $jl->id ? 'selected' : '' }}>{{ $jl->nama }}</option>
                @endforeach
            </select>

            <select name="status" class="btr-select" style="width:auto; min-width:160px;">
                <option value="">Semua Status</option>
                @foreach($statusList as $key => $label)
                    <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <div class="btr-search" style="flex:1; min-width:200px;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor PL, perihal, atau nama...">
                <button type="submit">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
                </button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="btr-card">
        <div class="btr-table-wrap">
            <table class="btr-table">
                <thead>
                    <tr>
                        <th>No. PL</th>
                        <th>Pelanggan</th>
                        <th>Jenis Layanan</th>
                        <th>Perihal</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Tim</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permohonan as $item)
                        <tr>
                            <td>{{ $item->nomor_pl }}</td>
                            <td>{{ $item->user->name ?? '-' }}</td>
                            <td>{{ $item->jenisLayanan->nama ?? '-' }}</td>
                            <td style="text-align:left;">{{ \Illuminate\Support\Str::limit($item->perihal, 35) }}</td>
                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                            <td>
                                <span style="font-weight:600; font-size:12px; padding:4px 12px; border-radius:999px;
                                    @if($item->status === 'selesai') background:#D1FAE5; color:#047857;
                                    @elseif($item->status === 'ditolak') background:#FEE2E2; color:#B91C1C;
                                    @elseif(in_array($item->status, ['baru','verifikasi'])) background:#DBEAFE; color:#1E40AF;
                                    @else background:#FEF3C7; color:#92400E;
                                    @endif
                                ">{{ \App\Models\Permohonan::STATUS_LABELS[$item->status] ?? $item->status }}</span>
                            </td>
                            <td>{{ $item->tim->nama ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.layanan.permohonan.show', $item) }}" class="btr-action view" title="Detail">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" style="color:var(--text-muted);">Tidak ada permohonan ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($permohonan->hasPages())
            <div style="margin-top:20px; display:flex; justify-content:center;">
                {{ $permohonan->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection
