@extends('pelanggan.layouts.main')

@section('container')
    <h1 class="btr-page-title">Dokumen</h1>

    <div class="btr-card" style="padding:0;">
        {{-- Tabs --}}
        <div class="btr-tabs" style="padding:24px 24px 0;">
            <span class="btr-tab active">Dokumen Hasil</span>
        </div>

        <div class="btr-tab-panel">
            <div class="btr-table-wrap">
                <table class="btr-table">
                    <thead>
                        <tr>
                            <th>Nama Dokumen</th>
                            <th>Jenis Layanan</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dokumen as $doc)
                            <tr>
                                <td style="text-align:left;">{{ $doc->nama_dokumen }}</td>
                                <td>{{ $doc->permohonan->jenisLayanan->nama ?? '-' }}</td>
                                <td>{{ $doc->created_at->format('d F Y') }}</td>
                                <td>
                                    <div class="btr-actions">
                                        <a href="{{ route('pelanggan.permohonan.show', $doc->permohonan_id) }}" class="btr-action view" title="Lihat">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        @if($doc->is_downloadable)
                                            <a href="{{ route('pelanggan.dokumen.download', $doc) }}" class="btr-action download" title="Download">
                                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" style="color:var(--text-muted);">Belum ada dokumen hasil.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($dokumen->hasPages())
                <div style="margin-top:20px; display:flex; justify-content:center;">
                    {{ $dokumen->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
