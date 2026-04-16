@extends('dashboard.layanan.layouts.main')

@section('container')
    <div style="display:flex; align-items:center; gap:12px; margin-bottom:20px;">
        <a href="{{ route('admin.layanan.permohonan.index') }}" style="color:var(--text-muted); text-decoration:none;">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:20px; height:20px;"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
        </a>
        <h1 class="btr-page-title" style="margin:0;">Detail Permohonan</h1>
    </div>

    <div style="display:grid; grid-template-columns:2fr 1fr; gap:24px;">
        {{-- Left column --}}
        <div>
            {{-- Permohonan Info --}}
            <div class="btr-card">
                <h3 style="font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 16px;">Informasi Permohonan</h3>
                <div style="display:grid; grid-template-columns:160px 1fr; gap:8px 16px; font-size:14px;">
                    <span style="color:var(--text-muted);">No. PL</span>
                    <span><strong>{{ $permohonan->nomor_pl }}</strong></span>

                    <span style="color:var(--text-muted);">Pelanggan</span>
                    <span>{{ $permohonan->user->name ?? '-' }} ({{ $permohonan->user->email ?? '' }})</span>

                    <span style="color:var(--text-muted);">Jenis Layanan</span>
                    <span>{{ $permohonan->jenisLayanan->nama ?? '-' }}</span>

                    <span style="color:var(--text-muted);">Perihal</span>
                    <span>{{ $permohonan->perihal }}</span>

                    @if($permohonan->deskripsi)
                        <span style="color:var(--text-muted);">Keterangan</span>
                        <span>{{ $permohonan->deskripsi }}</span>
                    @endif

                    <span style="color:var(--text-muted);">Tgl Pengajuan</span>
                    <span>{{ $permohonan->created_at->format('d F Y H:i') }}</span>

                    <span style="color:var(--text-muted);">Status</span>
                    <span>
                        <span style="font-weight:600; font-size:12px; padding:4px 12px; border-radius:999px;
                            @if($permohonan->status === 'selesai') background:#D1FAE5; color:#047857;
                            @elseif($permohonan->status === 'ditolak') background:#FEE2E2; color:#B91C1C;
                            @elseif(in_array($permohonan->status, ['baru','verifikasi'])) background:#DBEAFE; color:#1E40AF;
                            @else background:#FEF3C7; color:#92400E;
                            @endif
                        ">{{ \App\Models\Permohonan::STATUS_LABELS[$permohonan->status] ?? $permohonan->status }}</span>
                    </span>

                    <span style="color:var(--text-muted);">Progress</span>
                    <span>
                        <div style="height:16px; background:#E5E7EB; border-radius:8px; overflow:hidden; max-width:200px;">
                            @php($progressStyle = 'height:100%; width:' . $permohonan->progress . '%; background:linear-gradient(90deg,#10B981,#34D399); border-radius:8px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:11px; font-weight:600;')
                            <div style="{{ $progressStyle }}">{{ $permohonan->progress }}%</div>
                        </div>
                    </span>

                    @if($permohonan->tim)
                        <span style="color:var(--text-muted);">Tim</span>
                        <span>{{ $permohonan->tim->nama }}</span>
                    @endif

                    @if($permohonan->deadline)
                        <span style="color:var(--text-muted);">Deadline</span>
                        <span>{{ $permohonan->deadline->format('d F Y') }}</span>
                    @endif
                </div>
            </div>

            {{-- Dokumen --}}
            @if($permohonan->dokumen->count() > 0)
                <div class="btr-card">
                    <h3 style="font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 16px;">Dokumen Lampiran</h3>
                    <div class="btr-table-wrap">
                        <table class="btr-table">
                            <thead><tr><th>Nama File</th><th>Tipe</th><th>Ukuran</th></tr></thead>
                            <tbody>
                                @foreach($permohonan->dokumen as $dok)
                                    <tr>
                                        <td style="text-align:left;">{{ $dok->nama_file }}</td>
                                        <td>{{ $dok->tipe }}</td>
                                        <td>{{ number_format($dok->ukuran / 1024, 1) }} KB</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- Workflow Log --}}
            <div class="btr-card">
                <h3 style="font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 16px;">Riwayat Workflow</h3>
                <div class="btr-table-wrap">
                    <table class="btr-table">
                        <thead><tr><th>Waktu</th><th>Dari</th><th>Ke</th><th>Oleh</th><th>Catatan</th></tr></thead>
                        <tbody>
                            @foreach($permohonan->workflowLogs as $log)
                                <tr>
                                    <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $log->dari_status ? (\App\Models\Permohonan::STATUS_LABELS[$log->dari_status] ?? $log->dari_status) : '-' }}</td>
                                    <td><strong>{{ \App\Models\Permohonan::STATUS_LABELS[$log->ke_status] ?? $log->ke_status }}</strong></td>
                                    <td>{{ $log->actor->name ?? 'System' }}</td>
                                    <td style="text-align:left; max-width:200px;">{{ \Illuminate\Support\Str::limit($log->catatan, 60) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pembayaran --}}
            @if($permohonan->pembayaran)
                <div class="btr-card">
                    <h3 style="font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 16px;">Informasi Pembayaran</h3>
                    <div style="display:grid; grid-template-columns:160px 1fr; gap:8px 16px; font-size:14px;">
                        <span style="color:var(--text-muted);">Kode Billing</span>
                        <span>{{ $permohonan->pembayaran->kode_billing }}</span>
                        <span style="color:var(--text-muted);">Nominal</span>
                        <span>Rp {{ number_format($permohonan->pembayaran->nominal, 0, ',', '.') }}</span>
                        <span style="color:var(--text-muted);">Status</span>
                        <span>{{ ucfirst(str_replace('_', ' ', $permohonan->pembayaran->status)) }}</span>
                        @if($permohonan->pembayaran->bukti_bayar_path)
                            <span style="color:var(--text-muted);">Bukti Bayar</span>
                            <span><a href="{{ asset('storage/' . $permohonan->pembayaran->bukti_bayar_path) }}" target="_blank" style="color:var(--info-blue);">Lihat Bukti</a></span>
                        @endif
                    </div>

                    @if($permohonan->pembayaran->status === 'menunggu_verifikasi')
                        <div style="margin-top:16px; display:flex; gap:8px;">
                            <form action="{{ route('admin.layanan.permohonan.verifyPayment', $permohonan) }}" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="approve">
                                <button type="submit" class="btr-btn btr-btn-sm" style="background:var(--success-green);">Verifikasi OK</button>
                            </form>
                            <form action="{{ route('admin.layanan.permohonan.verifyPayment', $permohonan) }}" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="reject">
                                <button type="submit" class="btr-btn btr-btn-sm btr-btn-danger">Tolak</button>
                            </form>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Survei --}}
            @if($permohonan->surveiKepuasan)
                <div class="btr-card">
                    <h3 style="font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 16px;">Survei Kepuasan</h3>
                    @php($survei = $permohonan->surveiKepuasan)
                        <div class="btr-table-wrap" style="margin-bottom:12px;">
                            <table class="btr-table">
                                <thead><tr><th>Unsur</th><th>Nilai</th></tr></thead>
                                <tbody>
                                    @foreach($survei->jawaban as $jwb)
                                        <tr>
                                            <td style="text-align:left;">{{ $jwb->pertanyaan->pertanyaan ?? '-' }}</td>
                                            <td>{{ $jwb->nilai }}/4</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @if($survei->saran)
                        <p style="font-size:13px; color:var(--text-muted);"><strong>Saran:</strong> {{ $survei->saran }}</p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Right column: Actions --}}
        <div>
            {{-- Update Status --}}
            @if(count($allowedTransitions) > 0)
                <div class="btr-card">
                    <h3 style="font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 16px;">Ubah Status</h3>
                    <form action="{{ route('admin.layanan.permohonan.updateStatus', $permohonan) }}" method="POST">
                        @csrf
                        <div class="btr-form-group">
                            <label class="btr-label">Status Baru</label>
                            <select name="status" class="btr-select" required>
                                @foreach($allowedTransitions as $st)
                                    <option value="{{ $st }}">{{ \App\Models\Permohonan::STATUS_LABELS[$st] ?? $st }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btr-form-group">
                            <label class="btr-label">Catatan (opsional)</label>
                            <textarea name="catatan" class="btr-textarea" style="min-height:80px;" placeholder="Tambahkan catatan..."></textarea>
                        </div>
                        <button type="submit" class="btr-btn btr-btn-yellow" style="width:100%;">Perbarui Status</button>
                    </form>
                </div>
            @endif

            {{-- Assign Tim --}}
            @if(in_array(\App\Models\Permohonan::STATUS_PENUGASAN, $allowedTransitions, true))
                <div class="btr-card">
                    <h3 style="font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 16px;">Tugaskan Tim</h3>
                    <form action="{{ route('admin.layanan.permohonan.assignTim', $permohonan) }}" method="POST">
                        @csrf
                        <div class="btr-form-group">
                            <label class="btr-label">Pilih Tim</label>
                            <select name="tim_id" class="btr-select" required>
                                <option value="">-- Pilih Tim --</option>
                                @foreach($timList as $tim)
                                    <option value="{{ $tim->id }}" {{ $permohonan->tim_id == $tim->id ? 'selected' : '' }}>
                                        {{ $tim->nama }} ({{ $tim->anggota->count() }} anggota)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btr-form-group">
                            <label class="btr-label">SLA (Hari Kerja)</label>
                            <input type="number" name="sla_hari_kerja" class="btr-input" value="{{ $permohonan->sla_hari_kerja ?? 14 }}" min="1" max="365" required>
                        </div>
                        <button type="submit" class="btr-btn" style="width:100%;">Tugaskan</button>
                    </form>
                </div>
            @endif

            {{-- Set Billing --}}
            @if(in_array(\App\Models\Permohonan::STATUS_PEMBAYARAN, $allowedTransitions, true) && !$permohonan->pembayaran)
                <div class="btr-card">
                    <h3 style="font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 16px;">Terbitkan Billing</h3>
                    <form action="{{ route('admin.layanan.permohonan.setBilling', $permohonan) }}" method="POST">
                        @csrf
                        <div class="btr-form-group">
                            <label class="btr-label">Kode Billing</label>
                            <input type="text" name="kode_billing" class="btr-input" required placeholder="Masukkan kode billing...">
                        </div>
                        <div class="btr-form-group">
                            <label class="btr-label">Nominal (Rp)</label>
                            <input type="number" name="nominal" class="btr-input" required min="0" step="1000" placeholder="500000">
                        </div>
                        <button type="submit" class="btr-btn btr-btn-yellow" style="width:100%;">Terbitkan Billing</button>
                    </form>
                </div>
            @endif

            {{-- Upload Dokumen Final --}}
            @if(in_array($permohonan->status, ['finalisasi', 'evaluasi', 'analisis']))
                <div class="btr-card">
                    <h3 style="font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 16px;">Upload Dokumen Hasil</h3>
                    <form action="{{ url('dashboard/layanan/permohonan/' . $permohonan->id . '/dokumen-final') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="btr-form-group">
                            <label class="btr-label">Nama Dokumen</label>
                            <input type="text" name="nama_dokumen" class="btr-input" required placeholder="Nama file hasil...">
                        </div>
                        <div class="btr-form-group">
                            <label class="btr-label">File</label>
                            <input type="file" name="file" class="btr-input" required accept=".pdf,.doc,.docx,.xlsx">
                        </div>
                        <button type="submit" class="btr-btn" style="width:100%;">Upload</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection
