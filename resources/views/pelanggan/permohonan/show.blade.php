@extends('pelanggan.layouts.main')

@section('container')
    <h1 class="btr-page-title">Detail Permohonan</h1>

    {{-- Permohonan Info --}}
    <div class="btr-card">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
            <div>
                <dl class="btr-data-list">
                    <dt>No. PL</dt>
                    <dd><strong>{{ $permohonan->nomor_pl }}</strong></dd>

                    <dt>Layanan</dt>
                    <dd>{{ $permohonan->jenisLayanan->nama ?? '-' }}</dd>

                    <dt>Perihal</dt>
                    <dd>{{ $permohonan->perihal }}</dd>

                    <dt>Tgl Pengajuan</dt>
                    <dd>{{ $permohonan->created_at->format('d F Y') }}</dd>
                </dl>
            </div>
            <div>
                <dl class="btr-data-list">
                    <dt>Status</dt>
                    <dd><span class="btr-status-badge {{ $permohonan->status }}">{{ \App\Models\Permohonan::STATUS_LABELS[$permohonan->status] ?? $permohonan->status }}</span></dd>

                    <dt>Estimasi Selesai</dt>
                    <dd>{{ $permohonan->deadline ? $permohonan->deadline->format('d F Y') : '-' }}</dd>

                    @if($permohonan->deskripsi)
                        <dt>Keterangan</dt>
                        <dd>{{ $permohonan->deskripsi }}</dd>
                    @endif
                </dl>
            </div>
        </div>

        {{-- Progress bar --}}
        <div style="margin-top:8px;">
            <div class="btr-progress">
                <div class="btr-progress-bar" style="width: {{ $permohonan->progress }}%;">{{ $permohonan->progress }}%</div>
            </div>
        </div>
    </div>

    {{-- Timeline --}}
    <div class="btr-card">
        <h3 style="font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 20px;">Riwayat Status</h3>

        @php
            $allStatuses = ['baru', 'verifikasi', 'penugasan', 'pembayaran', 'pelaksanaan', 'analisis', 'evaluasi', 'finalisasi', 'selesai'];
            $currentIndex = array_search($permohonan->status, $allStatuses);
            if ($currentIndex === false) $currentIndex = -1;
        @endphp

        <div class="btr-timeline">
            @foreach($permohonan->workflowLogs as $log)
                <div class="btr-timeline-item done">
                    <div class="title">{{ \App\Models\Permohonan::STATUS_LABELS[$log->ke_status] ?? $log->ke_status }}</div>
                    <div class="meta">{{ $log->created_at->format('d M Y - H:i') }}</div>
                    @if($log->catatan)
                        <div class="note">{{ $log->catatan }}</div>
                    @endif
                </div>
            @endforeach

            @foreach($allStatuses as $idx => $status)
                @if($idx > $currentIndex && $permohonan->status !== 'ditolak')
                    <div class="btr-timeline-item pending">
                        <div class="title">{{ \App\Models\Permohonan::STATUS_LABELS[$status] ?? $status }}</div>
                    </div>
                @endif
            @endforeach
        </div>

        @if($permohonan->status === 'ditolak')
            <div class="btr-catatan" style="margin-top:16px;">
                <strong>Catatan:</strong> Permohonan ditolak.
            </div>
        @endif
    </div>

    {{-- Dokumen --}}
    @if($permohonan->dokumen->count() > 0)
        <div class="btr-card">
            <h3 style="font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 16px;">Dokumen Lampiran</h3>
            <div class="btr-table-wrap">
                <table class="btr-table">
                    <thead>
                        <tr>
                            <th>Nama File</th>
                            <th>Tipe</th>
                            <th>Ukuran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permohonan->dokumen as $dok)
                            <tr>
                                <td>{{ $dok->nama_file }}</td>
                                <td>{{ $dok->tipe }}</td>
                                <td>{{ number_format($dok->ukuran / 1024, 1) }} KB</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- Pembayaran --}}
    @if($permohonan->pembayaran)
        <div class="btr-card">
            <h3 style="font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 16px;">Informasi Pembayaran</h3>
            <dl class="btr-data-list">
                <dt>Kode Billing</dt>
                <dd>{{ $permohonan->pembayaran->kode_billing }}</dd>
                <dt>Nominal</dt>
                <dd>Rp {{ number_format($permohonan->pembayaran->nominal, 0, ',', '.') }}</dd>
                <dt>Status</dt>
                <dd><span class="btr-status-badge {{ $permohonan->pembayaran->status === 'sudah_bayar' ? 'selesai' : 'pembayaran' }}">{{ ucfirst(str_replace('_', ' ', $permohonan->pembayaran->status)) }}</span></dd>
            </dl>
            @if($permohonan->pembayaran->status === 'belum_bayar' || $permohonan->pembayaran->status === 'ditolak')
                <a href="{{ route('pelanggan.pembayaran.show', $permohonan) }}" class="btr-btn btr-btn-yellow btr-btn-sm" style="margin-top:8px;">Upload Bukti Pembayaran</a>
            @endif
        </div>
    @endif

    {{-- Dokumen Final --}}
    @if($permohonan->dokumenFinal->count() > 0)
        <div class="btr-card">
            <h3 style="font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 16px;">Dokumen Hasil</h3>
            @if(!$permohonan->sudahSurvei())
                <div class="btr-catatan">
                    <strong>Catatan:</strong> Isi survei kepuasan terlebih dahulu untuk mengunduh dokumen hasil.
                    <a href="{{ route('pelanggan.survei.create', $permohonan) }}" style="color:#92400E; font-weight:600;">Isi Survei</a>
                </div>
            @endif
            <div class="btr-table-wrap" style="margin-top:12px;">
                <table class="btr-table">
                    <thead>
                        <tr><th>Nama Dokumen</th><th>Tanggal</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        @foreach($permohonan->dokumenFinal as $df)
                            <tr>
                                <td>{{ $df->nama_dokumen }}</td>
                                <td>{{ $df->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @if($df->is_downloadable)
                                        <a href="{{ route('pelanggan.dokumen.download', $df) }}" class="btr-action download" title="Download">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        </a>
                                    @else
                                        <span style="color:var(--text-muted); font-size:12px;">Isi survei dulu</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <div style="margin-top:8px;">
        <a href="{{ route('pelanggan.permohonan.index') }}" class="btr-btn btr-btn-outline btr-btn-sm">Kembali ke Daftar</a>
    </div>
@endsection
