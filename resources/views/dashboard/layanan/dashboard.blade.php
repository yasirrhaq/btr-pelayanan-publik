@extends('dashboard.layanan.layouts.main')

@section('container')
    <h1 class="btr-page-title">Dashboard Layanan</h1>

    {{-- Stat cards --}}
    <div class="btr-dashboard-grid" style="grid-template-columns:repeat(4,1fr);">
        @php
            $totalPermohonan = $jenisLayanan->sum('permohonan_count');
            $totalAntri = $jenisLayanan->sum('antri_count');
            $totalProses = $jenisLayanan->sum('proses_count');
            $totalSelesai = $jenisLayanan->sum('selesai_count');
        @endphp
        <div class="btr-stat blue">
            <div>
                <div class="label">Total Permohonan</div>
                <div class="value">{{ $totalPermohonan }}</div>
            </div>
            <div class="icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08"/></svg>
            </div>
        </div>
        <div class="btr-stat yellow">
            <div>
                <div class="label">Antrian</div>
                <div class="value">{{ $totalAntri }}</div>
            </div>
            <div class="icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>
            </div>
        </div>
        <div class="btr-stat cyan">
            <div>
                <div class="label">Dalam Proses</div>
                <div class="value">{{ $totalProses }}</div>
            </div>
            <div class="icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182"/></svg>
            </div>
        </div>
        <div class="btr-stat gray">
            <div>
                <div class="label">Selesai</div>
                <div class="value">{{ $totalSelesai }}</div>
            </div>
            <div class="icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>
            </div>
        </div>
    </div>

    {{-- Per-layanan breakdown --}}
    <div class="btr-card">
        <h3 style="font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 16px;">Statistik Per Jenis Layanan</h3>
        <div class="btr-table-wrap">
            <table class="btr-table">
                <thead>
                    <tr>
                        <th>Jenis Layanan</th>
                        <th>Total</th>
                        <th>Antrian</th>
                        <th>Proses</th>
                        <th>Selesai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jenisLayanan as $jl)
                        <tr>
                            <td style="text-align:left; font-weight:500;">{{ $jl->nama }}</td>
                            <td>{{ $jl->permohonan_count }}</td>
                            <td>{{ $jl->antri_count }}</td>
                            <td>{{ $jl->proses_count }}</td>
                            <td>{{ $jl->selesai_count }}</td>
                            <td>
                                <a href="{{ route('admin.layanan.permohonan.index', ['jenis_layanan_id' => $jl->id]) }}" class="btr-btn btr-btn-sm btr-btn-outline">Kelola</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Recent Permohonan --}}
    <div class="btr-card">
        <h3 style="font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 16px;">Permohonan Terbaru</h3>
        <div class="btr-table-wrap">
            <table class="btr-table">
                <thead>
                    <tr>
                        <th>No. PL</th>
                        <th>Pelanggan</th>
                        <th>Jenis Layanan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentPermohonan as $item)
                        <tr>
                            <td>{{ $item->nomor_pl }}</td>
                            <td>{{ $item->user->name ?? '-' }}</td>
                            <td>{{ $item->jenisLayanan->nama ?? '-' }}</td>
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
                            <td>
                                <a href="{{ route('admin.layanan.permohonan.show', $item) }}" class="btr-action view" title="Detail">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
