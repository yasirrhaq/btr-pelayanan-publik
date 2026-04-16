@extends('pelanggan.layouts.main')

@section('container')
    <h1 class="btr-page-title">Ajukan Permohonan</h1>

    <div style="display:flex; justify-content:flex-end; margin-bottom:20px;">
        <a href="{{ route('pelanggan.permohonan.create') }}" class="btr-btn btr-btn-yellow">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Ajukan Permohonan Baru
        </a>
    </div>

    <div class="btr-card">
        <div class="btr-table-wrap">
            <table class="btr-table">
                <thead>
                    <tr>
                        <th>No. PL</th>
                        <th>Jenis Layanan</th>
                        <th>Perihal</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permohonan as $item)
                        <tr>
                            <td>{{ $item->nomor_pl }}</td>
                            <td>{{ $item->jenisLayanan->nama ?? '-' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($item->perihal, 40) }}</td>
                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                            <td><span class="btr-status-badge {{ $item->status }}">{{ \App\Models\Permohonan::STATUS_LABELS[$item->status] ?? $item->status }}</span></td>
                            <td>
                                <div class="btr-actions">
                                    <a href="{{ route('pelanggan.permohonan.show', $item) }}" class="btr-action view" title="Lihat Detail">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="color:var(--text-muted);">Belum ada permohonan. Klik tombol di atas untuk membuat permohonan baru.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($permohonan->hasPages())
            <div style="margin-top:20px; display:flex; justify-content:center;">
                {{ $permohonan->links() }}
            </div>
        @endif
    </div>
@endsection
