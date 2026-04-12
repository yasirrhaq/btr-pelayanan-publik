@extends('dashboard.layouts.main')

@php
    use App\Models\Post;
    use App\Models\User;
    use App\Models\GaleriFoto;
    use App\Models\KaryaIlmiah;

    $totalAdminWeb = User::where('is_admin', 1)->count();
    $totalAdminLayanan = User::where('is_admin', 1)->count();
    $totalBerita = Post::count();
    $totalPengumuman = KaryaIlmiah::count();
    $totalGaleri = GaleriFoto::count();
@endphp

@section('container')
    <h1 class="btr-page-title">Dashboard</h1>

    <div class="btr-dashboard-grid">
        <div class="btr-mascot">
            <img src="{{ url('/img/mascot.png') }}" alt="Maskot" onerror="this.style.display='none';this.parentNode.innerHTML='<div style=\'font-size:48px\'>🦊</div>';">
        </div>

        <div class="btr-stat blue">
            <div>
                <div class="label">Total Admin Web</div>
                <div class="value">{{ $totalAdminWeb }}</div>
            </div>
            <div class="icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 0 0-3-3.87M9 20H4v-2a4 4 0 0 1 3-3.87m6-5.13a4 4 0 1 1-8 0 4 4 0 0 1 8 0zm6 0a4 4 0 1 1-8 0 4 4 0 0 1 8 0z"/></svg>
            </div>
        </div>

        <div class="btr-stat pink">
            <div>
                <div class="label">Total Admin Layanan</div>
                <div class="value">{{ $totalAdminLayanan }}</div>
            </div>
            <div class="icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
            </div>
        </div>

        <div class="btr-stat cyan">
            <div>
                <div class="label">Total Berita</div>
                <div class="value">{{ $totalBerita }}</div>
            </div>
            <div class="icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/></svg>
            </div>
        </div>

        <div class="btr-stat yellow">
            <div>
                <div class="label">Total Pengumuman</div>
                <div class="value">{{ $totalPengumuman }}</div>
            </div>
            <div class="icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 0 1-3.417.592l-2.147-6.15M18 13a3 3 0 1 0 0-6M5.436 13.683A4.001 4.001 0 0 1 7 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 0 1-1.564-.317z"/></svg>
            </div>
        </div>

        <div class="btr-stat gray">
            <div>
                <div class="label">Total Galeri</div>
                <div class="value">{{ $totalGaleri }}</div>
            </div>
            <div class="icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 15l-5-5L5 21"/></svg>
            </div>
        </div>
    </div>

    <div class="btr-chart-card">
        <div class="btr-chart-head">
            <div class="btr-chart-title">Grafik Pengunjung Situs Web Balai Teknik Rawa</div>
            <div class="btr-chart-controls">
                <label>Tahun:</label>
                <select id="btr-year"><option>{{ date('Y') }}</option></select>
                <span>Total: <strong id="btr-total-visitor">0</strong> visitor</span>
            </div>
        </div>
        <canvas id="btr-visitor-chart" height="90"></canvas>
    </div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    (function () {
        var ctx = document.getElementById('btr-visitor-chart');
        if (!ctx) return;
        var months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Aug','Sept','Okt','Nov','Des'];
        var data = [3, 6, 8, 9, 12, 18, 22, 26, 30, 33, 24, 14];
        var total = data.reduce(function(a,b){return a+b;}, 0);
        var totalEl = document.getElementById('btr-total-visitor');
        if (totalEl) totalEl.textContent = total;
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Pengunjung',
                    data: data,
                    borderColor: '#1E3A6B',
                    backgroundColor: 'rgba(253, 195, 0, 0.15)',
                    tension: 0.35,
                    fill: true,
                    pointBackgroundColor: '#FDC300',
                    pointBorderColor: '#1E3A6B',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 5 } }
                }
            }
        });
    })();
</script>
@endpush
