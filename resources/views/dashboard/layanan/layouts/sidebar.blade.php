@php
    use App\Models\JenisLayanan;

    $is = function ($pattern) {
        return request()->is($pattern) ? 'active' : '';
    };

    $user = auth()->user();

    $can = function ($permission) use ($user) {
        return $user && ($user->hasRole('admin-master') || $user->can($permission));
    };

    $canAny = function (array $permissions) use ($can) {
        foreach ($permissions as $permission) {
            if ($can($permission)) {
                return true;
            }
        }

        return false;
    };

    $layananMap = JenisLayanan::query()
        ->whereIn('name', ['Advis Teknis', 'Pengujian Laboratorium', 'Permohonan Data', 'Layanan Lainnya'])
        ->get()
        ->mapWithKeys(fn ($jenis) => [$jenis->name => $jenis->id])
        ->all();

    $serviceLinks = [
        ['label' => 'Advis Teknik', 'name' => 'Advis Teknis'],
        ['label' => 'Laboratorium', 'name' => 'Pengujian Laboratorium'],
        ['label' => 'Data dan Informasi', 'name' => 'Permohonan Data'],
        ['label' => 'Layanan Lainnya', 'name' => 'Layanan Lainnya'],
    ];

    $canServiceModules = $canAny([
        'manage-permohonan',
        'manage-billing',
        'manage-survei',
    ]);
    $canWorkflowInbox = $canAny([
        'view-all-permohonan',
        'verifikasi-permohonan',
        'assign-tim',
        'manage-dokumen-final',
        'pelaksanaan-teknis',
        'analisis-teknis',
        'evaluasi-teknis',
    ]);
    $canDokumenFinal = $can('manage-dokumen-final');
    $canDataPelanggan = $canAny([
        'manage-permohonan',
        'manage-billing',
        'manage-survei',
    ]);
    $canSurvei = $can('manage-survei');
    $permohonanActive = request()->is('dashboard/layanan') || request()->is('dashboard/layanan/*');
@endphp

<aside class="btr-sidebar">
    <a href="{{ route('admin.layanan.dashboard') }}" class="btr-logo">
        <span class="btr-logo-mark">
            <img src="{{ imageExists('assets/logo.png') }}" alt="Balai Teknik Rawa">
        </span>
        <span class="btr-logo-text">BALAI TEKNIK RAWA</span>
    </a>

    <ul class="btr-nav">
        @if($can('access-dashboard'))
            <li class="btr-nav-item">
                <a class="btr-nav-link {{ $is('dashboard') }}" href="{{ url('dashboard') }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10h14V10" /></svg>
                    Dashboard
                </a>
            </li>
        @endif

        @if($canServiceModules)
            @foreach($serviceLinks as $service)
                @php
                    $serviceId = $layananMap[$service['name']] ?? null;
                    $active = $permohonanActive && (string) request('jenis_layanan_id') === (string) $serviceId ? 'active' : '';
                @endphp
                @if($serviceId)
                    <li class="btr-nav-item">
                        <a class="btr-nav-link {{ $active }}" href="{{ route('admin.layanan.permohonan.index', ['jenis_layanan_id' => $serviceId]) }}">
                            @if($service['label'] === 'Advis Teknik')
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2l3 7 7 3-7 3-3 7-3-7-7-3 7-3 3-7z" /></svg>
                            @elseif($service['label'] === 'Laboratorium')
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 2v6l-5 9a2 2 0 0 0 1.7 3h10.6a2 2 0 0 0 1.7-3l-5-9V2" /><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8" /></svg>
                            @elseif($service['label'] === 'Data dan Informasi')
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10" /></svg>
                            @else
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16" /></svg>
                            @endif
                            {{ $service['label'] }}
                        </a>
                    </li>
                @endif
            @endforeach
        @elseif($canWorkflowInbox)
            <li class="btr-nav-item">
                <a class="btr-nav-link {{ $permohonanActive ? 'active' : '' }}" href="{{ route('admin.layanan.permohonan.index') }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2" /></svg>
                    Permohonan
                </a>
            </li>
        @endif

        @if($canSurvei)
            <li class="btr-nav-item">
                <a class="btr-nav-link {{ $is('dashboard/layanan/survei-analytics') }}" href="{{ route('admin.layanan.surveiAnalytics') }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 19h16M7 16V9M12 16V5M17 16v-3" /></svg>
                    Survei Kepuasan
                </a>
            </li>
        @endif

        @if($canDataPelanggan)
            <li class="btr-nav-item">
                <a class="btr-nav-link {{ $is('dashboard/layanan/data-pelanggan') }}" href="{{ route('admin.layanan.dataPelanggan') }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" /><circle cx="10" cy="7" r="4" /><path stroke-linecap="round" stroke-linejoin="round" d="M22 21v-2a4 4 0 0 0-3-3.87" /><path stroke-linecap="round" stroke-linejoin="round" d="M16 3.13a4 4 0 0 1 0 7.75" /></svg>
                    Data Pelanggan
                </a>
            </li>
        @endif

        @if($canDokumenFinal)
            <li class="btr-nav-item">
                <a class="btr-nav-link {{ $permohonanActive && request()->filled('has_dokumen_final') ? 'active' : '' }}" href="{{ route('admin.layanan.permohonan.index', ['has_dokumen_final' => 1]) }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" /><path stroke-linecap="round" stroke-linejoin="round" d="M14 2v6h6" /><path stroke-linecap="round" stroke-linejoin="round" d="M9 15h6M9 11h6M9 19h4" /></svg>
                    Dokumen Final
                </a>
            </li>
        @endif
    </ul>

    <div class="btr-logout">
        <form action="{{ url('') }}/logout" method="post">
            @csrf
            <button type="submit" class="btr-logout-btn">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v9" /><path stroke-linecap="round" stroke-linejoin="round" d="M8.5 5.5a8 8 0 1 0 7 0" /></svg>
                Logout
            </button>
        </form>
    </div>
</aside>
