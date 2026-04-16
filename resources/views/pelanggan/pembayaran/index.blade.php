@extends('pelanggan.layouts.main')

@section('container')
    <h1 class="btr-page-title">Pembayaran</h1>

    <div class="btr-card">
        <div class="btr-table-wrap">
            <table class="btr-table">
                <thead>
                    <tr>
                        <th>No. PL</th>
                        <th>Jenis Layanan</th>
                        <th>Kode Billing</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permohonan as $item)
                        <tr>
                            <td>{{ $item->nomor_pl }}</td>
                            <td>{{ $item->jenisLayanan->nama ?? '-' }}</td>
                            <td>{{ $item->pembayaran->kode_billing ?? '-' }}</td>
                            <td>Rp {{ number_format($item->pembayaran->nominal ?? 0, 0, ',', '.') }}</td>
                            <td>
                                @php $ps = $item->pembayaran->status ?? 'belum_bayar'; @endphp
                                <span class="btr-status-badge {{ $ps === 'sudah_bayar' ? 'selesai' : ($ps === 'ditolak' ? 'ditolak' : 'pembayaran') }}">
                                    {{ ucfirst(str_replace('_', ' ', $ps)) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('pelanggan.pembayaran.show', $item) }}" class="btr-action view" title="Detail">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="color:var(--text-muted);">Belum ada tagihan pembayaran.</td></tr>
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
