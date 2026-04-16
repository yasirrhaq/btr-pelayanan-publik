@extends('dashboard.layanan.layouts.main')

@section('container')
    <h1 class="btr-page-title">Survei Kepuasan Masyarakat (SKM)</h1>

    {{-- Summary --}}
    <div class="btr-dashboard-grid" style="grid-template-columns:repeat(3,1fr); margin-bottom:24px;">
        <div class="btr-stat blue">
            <div>
                <div class="label">Total Responden</div>
                <div class="value">{{ $totalSurvei }}</div>
            </div>
            <div class="icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0z"/></svg>
            </div>
        </div>
        @php
            $overallAvg = count($avgPerUnsur) > 0 ? collect($avgPerUnsur)->avg('avg') : 0;
            $ikm = $overallAvg * 25; // Convert 1-4 scale to 0-100
        @endphp
        <div class="btr-stat cyan">
            <div>
                <div class="label">Rata-rata Nilai</div>
                <div class="value">{{ number_format($overallAvg, 2) }}/4</div>
            </div>
            <div class="icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.563.563 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.563.563 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5z"/></svg>
            </div>
        </div>
        <div class="btr-stat {{ $ikm >= 75 ? 'blue' : ($ikm >= 50 ? 'yellow' : 'pink') }}">
            <div>
                <div class="label">Indeks Kepuasan (IKM)</div>
                <div class="value">{{ number_format($ikm, 1) }}</div>
            </div>
            <div class="icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125z"/></svg>
            </div>
        </div>
    </div>

    {{-- Per-Unsur Breakdown --}}
    <div class="btr-card">
        <h3 style="font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 20px;">Nilai Per Unsur Pelayanan</h3>
        <div class="btr-table-wrap">
            <table class="btr-table">
                <thead>
                    <tr>
                        <th style="width:40px;">No</th>
                        <th style="text-align:left;">Unsur Pelayanan</th>
                        <th style="width:120px;">Rata-rata</th>
                        <th style="width:200px;">Visualisasi</th>
                        <th style="width:100px;">Kualitas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($avgPerUnsur as $idx => $data)
                        @php
                            $pct = ($data['avg'] / 4) * 100;
                            $quality = $data['avg'] >= 3.5 ? 'Sangat Baik' : ($data['avg'] >= 2.5 ? 'Baik' : ($data['avg'] >= 1.5 ? 'Kurang' : 'Tidak Baik'));
                            $color = $data['avg'] >= 3.5 ? '#10B981' : ($data['avg'] >= 2.5 ? '#F59E0B' : '#DC2626');
                            $barStyle = 'height:100%; width:' . $pct . '%; background:' . $color . '; border-radius:6px;';
                            $qualityStyle = 'color:' . $color . '; font-weight:600; font-size:12px;';
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td style="text-align:left;">{{ $data['pertanyaan'] }}</td>
                            <td><strong>{{ number_format($data['avg'], 2) }}</strong></td>
                            <td>
                                <div style="height:12px; background:#E5E7EB; border-radius:6px; overflow:hidden;">
                                    <div style="{{ $barStyle }}"></div>
                                </div>
                            </td>
                            <td style="{{ $qualityStyle }}">{{ $quality }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Recent Responses --}}
    <div class="btr-card">
        <h3 style="font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 16px;">Respons Terbaru</h3>
        <div class="btr-table-wrap">
            <table class="btr-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>No. PL</th>
                        <th>Layanan</th>
                        <th>Avg Nilai</th>
                        <th>Saran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentSurvei as $survei)
                        @php
                            $avg = $survei->jawaban->avg('nilai');
                            $avgColor = $avg >= 3 ? 'var(--success-green)' : ($avg >= 2 ? 'var(--warning-amber)' : 'var(--danger-red)');
                            $avgStyle = 'color:' . $avgColor . ';';
                        @endphp
                        <tr>
                            <td>{{ $survei->created_at->format('d/m/Y') }}</td>
                            <td>{{ $survei->user->name ?? '-' }}</td>
                            <td>{{ $survei->permohonan->nomor_pl ?? '-' }}</td>
                            <td>{{ $survei->permohonan->jenisLayanan->nama ?? '-' }}</td>
                            <td>
                                <strong style="{{ $avgStyle }}">
                                    {{ number_format($avg, 1) }}
                                </strong>
                            </td>
                            <td style="text-align:left; max-width:200px;">{{ \Illuminate\Support\Str::limit($survei->saran, 50) ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="color:var(--text-muted);">Belum ada survei.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
