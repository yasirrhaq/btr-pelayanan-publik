@extends('pelanggan.layouts.main')

@section('container')
    <h1 class="btr-page-title">Tracking Layanan</h1>

    {{-- Search Bar --}}
    <div class="btr-card">
        <form method="GET" action="{{ route('pelanggan.tracking') }}" class="btr-search" style="max-width:600px;">
            <input type="text" name="nomor" value="{{ request('nomor') }}" placeholder="Masukkan Nomor Permohonan Layanan Anda (PL)">
            <button type="submit">LACAK</button>
        </form>
    </div>

    @php
        $result = null;
        if (request('nomor')) {
            $result = \App\Models\Permohonan::where('nomor_pl', request('nomor'))
                ->where('user_id', auth()->id())
                ->with(['jenisLayanan', 'workflowLogs.actor'])
                ->first();
        }
    @endphp

    @if(request('nomor') && !$result)
        <div class="btr-alert btr-alert-error">Permohonan dengan nomor "{{ request('nomor') }}" tidak ditemukan.</div>
    @endif

    @if($result)
        <div class="btr-card">
            <h3 style="font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 16px;">{{ $result->jenisLayanan->nama ?? 'Layanan' }}</h3>

            <div style="display:grid; grid-template-columns:120px 1fr; gap:8px 16px; font-size:14px; margin-bottom:20px;">
                <span style="color:var(--text-muted);">No. PL</span>
                <span><strong>{{ $result->nomor_pl }}</strong></span>

                <span style="color:var(--text-muted);">Layanan</span>
                <span>{{ $result->jenisLayanan->nama ?? '-' }}</span>

                <span style="color:var(--text-muted);">Keterangan</span>
                <span>{{ $result->perihal }}</span>

                <span style="color:var(--text-muted);">Tgl Pengajuan</span>
                <span>{{ $result->created_at->format('d F Y') }}</span>

                <span style="color:var(--text-muted);">Status</span>
                <span>
                    <div class="btr-progress" style="max-width:300px;">
                        <div class="btr-progress-bar" style="width:{{ $result->progress }}%;">{{ $result->progress }}%</div>
                    </div>
                </span>
            </div>

            {{-- Timeline --}}
            @php
                $allStatuses = ['baru', 'verifikasi', 'penugasan', 'pembayaran', 'pelaksanaan', 'analisis', 'evaluasi', 'finalisasi', 'selesai'];
                $currentIndex = array_search($result->status, $allStatuses);
                if ($currentIndex === false) $currentIndex = -1;
            @endphp

            <div class="btr-timeline">
                @foreach($result->workflowLogs as $log)
                    <div class="btr-timeline-item done">
                        <div class="title">{{ \App\Models\Permohonan::STATUS_LABELS[$log->ke_status] ?? $log->ke_status }}</div>
                        <div class="meta">{{ $log->created_at->format('d M Y - H:i') }}</div>
                        @if($log->catatan)
                            <div class="note">{{ $log->catatan }}</div>
                        @endif
                    </div>
                @endforeach

                @foreach($allStatuses as $idx => $status)
                    @if($idx > $currentIndex && $result->status !== 'ditolak')
                        <div class="btr-timeline-item pending">
                            <div class="title">{{ \App\Models\Permohonan::STATUS_LABELS[$status] ?? $status }}</div>
                        </div>
                    @endif
                @endforeach
            </div>

            @if($result->sla_hari_kerja)
                <div class="btr-catatan" style="margin-top:16px;">
                    <strong>Estimasi Pengerjaan:</strong> {{ $result->sla_hari_kerja }} Hari Kerja
                </div>
            @endif
        </div>
    @endif
@endsection
