@extends('pelanggan.layouts.main')

@section('container')
    <h1 class="btr-page-title">Dashboard</h1>

    <div class="btr-hero">
        <div class="btr-welcome">
            <div class="btr-welcome-avatar">
                <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="40" cy="40" r="40" fill="#E5E7EB"/>
                    <circle cx="40" cy="32" r="14" fill="#9CA3AF"/>
                    <ellipse cx="40" cy="62" rx="22" ry="14" fill="#9CA3AF"/>
                </svg>
            </div>
            <div>
                <h2>Selamat Datang, {{ auth()->user()->name }}</h2>
                <p>Kelola layanan Anda dari dashboard pelanggan Balai Teknik Rawa.</p>
            </div>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="btr-stat-grid">
        <div class="btr-stat-card blue">
            <div class="label">Proses Verifikasi</div>
            <div class="value">{{ $counts['aktif'] }}</div>
        </div>
        <div class="btr-stat-card yellow">
            <div class="label">Menunggu Pembayaran</div>
            <div class="value">{{ $terbaru->where('status', 'pembayaran')->count() }}</div>
        </div>
        <div class="btr-stat-card cyan">
            <div class="label">Tahap Pelaksanaan</div>
            <div class="value">{{ $terbaru->whereIn('status', ['pelaksanaan', 'analisis', 'evaluasi'])->count() }}</div>
        </div>
        <div class="btr-stat-card green">
            <div class="label">Selesai</div>
            <div class="value">{{ $counts['selesai'] }}</div>
        </div>
    </div>

    {{-- Active Permohonan Table --}}
    <div class="btr-card">
        <div class="btr-section-heading">
            <div>
                <h3>Daftar Permohonan Aktif</h3>
                <p>Permohonan terbaru yang masih berjalan atau menunggu proses lanjutan.</p>
            </div>
            <a href="{{ route('pelanggan.permohonan.index') }}" class="btr-btn btr-btn-outline btr-btn-sm">Lihat Semua</a>
        </div>
        <div class="btr-table-wrap">
            <table class="btr-table">
                <thead>
                    <tr>
                        <th>No. PL</th>
                        <th>Jenis Layanan</th>
                        <th>Perihal</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Estimasi Selesai</th>
                        <th>Status Saat Ini</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($terbaru as $item)
                        <tr>
                            <td>
                                <a href="{{ route('pelanggan.permohonan.show', $item) }}" style="color:var(--info-blue); text-decoration:none; font-weight:500;">
                                    {{ $item->nomor_pl }}
                                </a>
                            </td>
                            <td>{{ $item->jenisLayanan->nama ?? '-' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($item->perihal, 40) }}</td>
                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                            <td>{{ $item->deadline ? $item->deadline->format('d/m/Y') : '-' }}</td>
                            <td><span class="btr-status-badge {{ $item->status }}">{{ \App\Models\Permohonan::STATUS_LABELS[$item->status] ?? $item->status }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="color:var(--text-muted);">Belum ada permohonan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Survey invitation --}}
    <div class="btr-card btr-card-survey">
        <h3>Survei Kepuasan Pelanggan</h3>
        <p>
            Terimakasih telah menjadi pelanggan Balai Teknik Rawa. Dalam rangka meningkatkan kualitas
            penyelenggaraan pelayan publik di Balai Teknik Rawa, maka dimohon kesediaan Bapak/Ibu
            meluangkan waktu untuk mengisi Survei ini dan memberikan saran pada tempat yang disediakan.
        </p>
        <p class="btr-card-survey-signoff">
            Salam hangat,<br>
            <strong>#DariRawaUntukIndonesia</strong>
        </p>
    </div>
@endsection
