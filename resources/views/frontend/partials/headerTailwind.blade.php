@php
    $hdr_urls = \App\Models\UrlLayanan::all();
    $hdr_url_advis = $hdr_urls->firstWhere('id', 3);
    $profilMenu = [
        ['label' => 'Visi dan Misi', 'href' => url('/visi-misi')],
        ['label' => 'Sejarah', 'href' => url('/sejarah')],
        ['label' => 'Tugas dan Fungsi', 'href' => url('/tugas')],
        ['label' => 'Maskot Balai Teknik Rawa', 'href' => url('/maskot-balai-teknik-rawa')],
        ['label' => 'Struktur Organisasi', 'href' => url('/struktur-organisasi')],
        ['label' => 'Informasi Pegawai', 'href' => url('/info-pegawai')],
        ['label' => 'Fasilitas Balai', 'href' => url('/fasilitas-balai')],
    ];

    $layananMenu = [
        [
            'label' => 'Informasi Pelayanan',
            'children' => [
                ['label' => 'Maklumat Pelayanan', 'href' => '#'],
                ['label' => 'Standar Pelayanan', 'href' => '#'],
            ],
        ],
        [
            'label' => 'Layanan',
            'children' => [
                ['label' => 'Layanan Advis Teknis', 'href' => url('/advis-teknis')],
                ['label' => 'Layanan Pengujian Laboratorium', 'href' => url('/pengujian-laboratorium')],
                ['label' => 'Layanan Data dan Informasi', 'href' => $hdr_url_advis->url ?? '#'],
                ['label' => 'Layanan Lainnya', 'href' => '#'],
            ],
        ],
        [
            'label' => 'Tracking Layanan',
            'href' => auth()->check() ? url('/pelanggan/tracking') : url('/login'),
        ],
    ];

    $publikasiMenu = [
        [
            'label' => 'PPID',
            'href' => route('ppid.index'),
            'children' => [
                ['label' => 'E-PPID', 'href' => 'https://eppid.pu.go.id/', 'external' => true],
                ['label' => 'Kebijakan PPID', 'href' => route('ppid.show', 'kebijakan-ppid')],
                ['label' => 'Informasi Berkala', 'href' => route('ppid.show', 'info-berkala')],
                ['label' => 'Informasi Serta Merta', 'href' => route('ppid.show', 'info-serta-merta')],
                ['label' => 'Informasi Setiap Saat', 'href' => route('ppid.show', 'info-setiap-saat')],
            ],
        ],
        [
            'label' => 'Publikasi',
            'children' => [
                ['label' => 'E-Perpustakaan', 'href' => 'https://pustaka.pu.go.id/perpustakaan/balai-rawa', 'external' => true],
                ['label' => 'SANDRA', 'href' => '#'],
                ['label' => 'Rencana Strategis', 'href' => '#'],
                ['label' => 'JDIH PU', 'href' => '#'],
                ['label' => 'Pengumuman', 'href' => route('pengumuman.index')],
                ['label' => 'Berita', 'href' => url('/berita')],
            ],
        ],
        [
            'label' => 'Galeri',
            'children' => [
                ['label' => 'Foto', 'href' => url('/foto')],
                ['label' => 'Video', 'href' => url('/video')],
                ['label' => 'Dokumen', 'href' => route('dokumen.index')],
            ],
        ],
    ];

    $pengaduanMenu = [
        ['label' => 'Layanan Pengaduan Masyarakat', 'href' => 'https://www.lapor.go.id/', 'external' => true],
        ['label' => 'Pelaporan Gratifikasi', 'href' => 'https://gol.itjen.pu.go.id/', 'external' => true],
        ['label' => 'WBS Kemen PU', 'href' => 'https://wispu.pu.go.id/', 'external' => true],
    ];
@endphp

<div class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/95 shadow-sm backdrop-blur" x-data="{ mobileOpen: false, langOpen: false }">
    <style>
        .nav-item:hover .nav-dropdown {
            display: block;
        }

        .nav-dropdown {
            display: none;
            min-width: 260px;
        }

        .nav-dropdown-panel {
            padding: 10px;
            background: #fff;
            border-top: 2px solid #354776;
            border-radius: 0 0 18px 18px;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.14);
            overflow: hidden;
        }

        .nav-submenu-item {
            position: relative;
        }

        .nav-submenu-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            min-width: 220px;
            padding: 11px 14px;
            font-size: 13px;
            color: #334155;
            text-decoration: none;
            border-radius: 10px;
            transition: background-color .15s ease, color .15s ease, transform .15s ease;
        }

        .nav-submenu-link:hover {
            background: #f8fafc;
            color: #354776;
        }

        .nav-submenu-label {
            font-weight: 600;
        }

        .nav-submenu-arrow {
            color: #94a3b8;
            font-size: 11px;
        }

        .nav-flyout-title {
            padding: 4px 12px 10px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #354776;
        }

        .nav-flyout-link {
            display: block;
            padding: 10px 12px;
            border-radius: 10px;
            color: #334155;
            font-size: 13px;
            text-decoration: none;
            transition: background-color .15s ease, color .15s ease;
        }

        .nav-flyout-link:hover {
            background: #f8fafc;
            color: #354776;
        }

        .nav-dropdown--stacked .nav-dropdown-panel {
            position: relative;
            min-width: 240px;
            display: inline-flex;
            align-items: stretch;
            padding: 10px;
        }

        .nav-dropdown--stacked .nav-submenu-list {
            min-width: 240px;
        }

        .nav-dropdown--stacked .nav-submenu-item {
            position: static;
        }

        .nav-dropdown--stacked .nav-submenu-item:hover > .nav-submenu-link,
        .nav-dropdown--stacked .nav-submenu-link.is-active {
            background: #f8fafc;
            color: #354776;
        }

        .nav-dropdown--stacked .nav-flyout {
            display: none;
            width: 0;
            overflow: hidden;
            margin-left: 0;
            padding: 0;
            background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
            border-left: 1px solid #e2e8f0;
            border-radius: 0 0 18px 0;
            transition: width .18s ease, margin-left .18s ease, padding .18s ease;
        }

        .nav-dropdown--stacked .nav-flyout.is-active {
            display: block;
            width: 300px;
            margin-left: 12px;
            padding: 14px 12px;
        }

        @media (max-width: 1279px) {
            .nav-dropdown--stacked .nav-flyout.is-active {
                width: 260px;
            }
        }
    </style>

    {{-- Row 1: Dark Navy [#354776] top bar --}}
    <div class="bg-[#354776] hidden md:block py-1.5">
        <div class="max-w-6xl mx-auto px-4 md:px-6 flex items-center justify-between">

            <span id="topbar-time" class="text-[11px] text-gray-300 font-medium"></span>

            <div class="flex items-center gap-2">
                <form action="{{ url('/berita') }}" method="GET" class="flex items-center">
                    <div class="flex items-center border border-gray-300 rounded overflow-hidden">
                        <input type="text" name="search" placeholder="Cari..."
                            class="px-3 py-1 text-xs text-gray-700 bg-white focus:outline-none w-36 placeholder-gray-400">
                        <button type="submit"
                            class="bg-[#354776] hover:bg-[#2a3a61] text-white px-2.5 py-1 transition-colors cursor-pointer flex items-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </form>

                @auth
                    <div class="relative" x-data="{ userOpen: false }">
                        <button @click="userOpen = !userOpen" @click.away="userOpen = false"
                            class="flex items-center gap-1 bg-amber-400 hover:bg-amber-300 text-[#354776] px-3 py-1 rounded text-[11px] font-bold transition-colors cursor-pointer">
                            <i class="fas fa-user-circle text-[10px]"></i>
                            {{ \Illuminate\Support\Str::limit(auth()->user()->username, 10) }}
                            <i class="fas fa-caret-down text-[9px]" :class="userOpen ? 'rotate-180' : ''" style="transition:transform .2s"></i>
                        </button>
                        <ul x-show="userOpen" x-cloak
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            class="absolute right-0 top-full bg-white text-gray-800 shadow-xl min-w-[160px] z-50 border-t-2 border-[#354776] rounded-b-md mt-1">
                            @if (auth()->user()->is_admin)
                                <li><a href="{{ url('/dashboard') }}"
                                        class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100"><i
                                            class="fas fa-tachometer-alt mr-2 text-[#354776]"></i>Dashboard</a></li>
                            @else
                                <li><a href="{{ url('/profile') }}"
                                        class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100"><i
                                            class="fas fa-user mr-2 text-[#354776]"></i>Profil Saya</a></li>
                            @endif
                            <li>
                                <form action="{{ url('/logout') }}" method="post">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2.5 text-sm hover:bg-gray-50 text-red-600 cursor-pointer">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ url('/login') }}"
                        class="bg-amber-400 hover:bg-amber-300 text-[#354776] font-bold px-4 py-1 rounded text-[11px] transition-colors cursor-pointer">
                        LOGIN
                    </a>
                @endauth

                @php $activeLang = app()->getLocale(); @endphp
                <div class="relative" x-data="{ langOpen: false }">
                    <button @click="langOpen = !langOpen" @click.away="langOpen = false"
                        class="flex items-center gap-1 border border-gray-300 hover:border-[#354776] bg-white px-2.5 py-1 rounded text-[11px] font-semibold text-gray-600 hover:text-[#354776] transition-colors cursor-pointer">
                        {{ strtoupper($activeLang) }} <i class="fas fa-caret-down text-[9px]" :class="langOpen ? 'rotate-180' : ''" style="transition:transform .2s"></i>
                    </button>
                    <ul x-show="langOpen" x-cloak
                        x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        class="absolute right-0 top-full mt-1 bg-white text-gray-800 shadow-lg min-w-[90px] z-50 border-t-2 border-[#354776] rounded-b-md">
                        <li>
                            <a href="{{ route('locale.set', 'id') }}"
                                class="flex items-center gap-2 px-3 py-2 text-xs hover:bg-gray-50 border-b border-gray-100 font-medium {{ $activeLang === 'id' ? 'text-[#354776] font-bold' : '' }}">
                                🇮🇩 <span>ID</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('locale.set', 'en') }}"
                                class="flex items-center gap-2 px-3 py-2 text-xs hover:bg-gray-50 font-medium {{ $activeLang === 'en' ? 'text-[#354776] font-bold' : '' }}">
                                🇬🇧 <span>EN</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Row 2: Grey bar --}}
    <div class="bg-gray-100/95">
        <div class="max-w-6xl mx-auto px-4 md:px-6">
            <div class="flex items-center justify-between gap-6" style="min-height:72px">

                <a href="{{ url('/home') }}" class="flex items-center gap-3 py-3 flex-shrink-0">
                    <img src="{{ imageExists(config('app.logo')) }}" alt="Logo BTR" class="h-12 w-auto">
                    <div class="leading-tight">
                        <div class="font-bold text-[14px] tracking-wide text-[#354776]">BALAI TEKNIK RAWA</div>
                        <div class="text-[9px] text-gray-500 leading-snug hidden sm:block">Direktorat Bina Teknik Sumber Daya Air</div>
                        <div class="text-[9px] text-gray-500 leading-snug hidden sm:block">Direktorat Jenderal Sumber Daya Air</div>
                        <div class="text-[9px] text-gray-500 leading-snug hidden sm:block">Kementerian Pekerjaan Umum</div>
                    </div>
                </a>

                <div class="hidden md:flex items-center">

                    <a href="{{ url('/home') }}"
                        class="px-3 py-6 text-[13px] font-medium text-gray-700 hover:text-[#354776] hover:bg-gray-200/80 transition-colors whitespace-nowrap">
                        Beranda
                    </a>

                    <div class="nav-item relative">
                        <button
                            class="px-3 py-6 text-[13px] font-medium text-gray-700 hover:text-[#354776] hover:bg-gray-200/80 transition-colors flex items-center gap-1 whitespace-nowrap cursor-pointer">
                            Profil <i class="fas fa-caret-down text-[10px] text-gray-400"></i>
                        </button>
                        <div class="nav-dropdown absolute left-0 top-full z-50">
                            <div class="nav-dropdown-panel">
                                @foreach ($profilMenu as $link)
                                    <a href="{{ $link['href'] }}" class="nav-submenu-link">
                                        <span class="nav-submenu-label">{{ $link['label'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="nav-item relative" x-data="{ active: null }" @mouseleave="active = null">
                        <button
                            class="px-3 py-6 text-[13px] font-medium text-gray-700 hover:text-[#354776] hover:bg-gray-200/80 transition-colors flex items-center gap-1 whitespace-nowrap cursor-pointer">
                            Layanan <i class="fas fa-caret-down text-[10px] text-gray-400"></i>
                        </button>
                        <div class="nav-dropdown nav-dropdown--stacked absolute left-0 top-full z-50">
                            <div class="nav-dropdown-panel">
                                <div class="nav-submenu-list">
                                    @foreach ($layananMenu as $index => $item)
                                        <div class="nav-submenu-item" @mouseenter="active = {{ !empty($item['children']) ? $index : 'null' }}">
                                            <a href="{{ $item['href'] ?? '#' }}" @if(empty($item['children']) && !empty($item['external'])) target="_blank" rel="noopener noreferrer" @endif class="nav-submenu-link" :class="{ 'is-active': active === {{ $index }} }">
                                                <span class="nav-submenu-label">{{ $item['label'] }}</span>
                                                @if (!empty($item['children']))
                                                    <i class="fas fa-chevron-right nav-submenu-arrow"></i>
                                                @endif
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                @foreach ($layananMenu as $index => $item)
                                    @if (!empty($item['children']))
                                        <div class="nav-flyout" x-show="active === {{ $index }}" x-cloak :class="{ 'is-active': active === {{ $index }} }">
                                            <div class="nav-flyout-title">{{ $item['label'] }}</div>
                                            @foreach ($item['children'] as $child)
                                                <a href="{{ $child['href'] }}" @if(!empty($child['external'])) target="_blank" rel="noopener noreferrer" @endif class="nav-flyout-link">{{ $child['label'] }}</a>
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="nav-item relative" x-data="{ active: null }" @mouseleave="active = null">
                        <button
                            class="px-3 py-6 text-[13px] font-medium text-gray-700 hover:text-[#354776] hover:bg-gray-200/80 transition-colors flex items-center gap-1 whitespace-nowrap cursor-pointer">
                            Publikasi <i class="fas fa-caret-down text-[10px] text-gray-400"></i>
                        </button>
                        <div class="nav-dropdown nav-dropdown--stacked absolute left-0 top-full z-50">
                            <div class="nav-dropdown-panel">
                                <div class="nav-submenu-list">
                                    @foreach ($publikasiMenu as $index => $item)
                                        <div class="nav-submenu-item" @mouseenter="active = {{ !empty($item['children']) ? $index : 'null' }}">
                                            <a href="{{ $item['href'] ?? '#' }}" @if(empty($item['children']) && !empty($item['external'])) target="_blank" rel="noopener noreferrer" @endif class="nav-submenu-link" :class="{ 'is-active': active === {{ $index }} }">
                                                <span class="nav-submenu-label">{{ $item['label'] }}</span>
                                                @if (!empty($item['children']))
                                                    <i class="fas fa-chevron-right nav-submenu-arrow"></i>
                                                @endif
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                @foreach ($publikasiMenu as $index => $item)
                                    @if (!empty($item['children']))
                                        <div class="nav-flyout" x-show="active === {{ $index }}" x-cloak :class="{ 'is-active': active === {{ $index }} }">
                                            <div class="nav-flyout-title">{{ $item['label'] }}</div>
                                            @foreach ($item['children'] as $child)
                                                <a href="{{ $child['href'] }}" @if(!empty($child['external'])) target="_blank" rel="noopener noreferrer" @endif class="nav-flyout-link">{{ $child['label'] }}</a>
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="nav-item relative">
                        <button
                            class="px-3 py-6 text-[13px] font-medium text-gray-700 hover:text-[#354776] hover:bg-gray-200/80 transition-colors flex items-center gap-1 whitespace-nowrap cursor-pointer">
                            Saran dan Pengaduan <i class="fas fa-caret-down text-[10px] text-gray-400"></i>
                        </button>
                        <div class="nav-dropdown absolute right-0 top-full z-50">
                            <div class="nav-dropdown-panel">
                                @foreach ($pengaduanMenu as $link)
                                    <a href="{{ $link['href'] }}" @if(!empty($link['external'])) target="_blank" rel="noopener noreferrer" @endif class="nav-submenu-link">
                                        <span class="nav-submenu-label">{{ $link['label'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <button @click="mobileOpen = !mobileOpen"
                    class="md:hidden p-2 rounded hover:bg-gray-200 transition-colors cursor-pointer text-gray-700"
                    aria-label="Menu">
                    <i class="fas fa-bars text-lg" x-show="!mobileOpen"></i>
                    <i class="fas fa-times text-lg" x-show="mobileOpen" x-cloak></i>
                </button>
            </div>

            <div x-show="mobileOpen" x-cloak x-transition
                class="md:hidden pb-3 border-t border-gray-200 space-y-0.5 pt-1">
                <a href="{{ url('/home') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-200 hover:text-[#354776] rounded font-medium">Beranda</a>
                <div class="px-4 pt-2 text-[11px] font-bold uppercase tracking-[0.08em] text-[#354776]">Profil</div>
                @foreach ($profilMenu as $link)
                    <a href="{{ $link['href'] }}" class="block px-4 py-2 text-sm text-gray-500 hover:bg-gray-200 rounded pl-7">↳ {{ $link['label'] }}</a>
                @endforeach
                <div class="px-4 pt-2 text-[11px] font-bold uppercase tracking-[0.08em] text-[#354776]">Layanan</div>
                @foreach ($layananMenu as $item)
                    <div class="px-4 py-1 text-xs font-semibold text-gray-400 pl-7">{{ $item['label'] }}</div>
                    @if (!empty($item['children']))
                        @foreach ($item['children'] as $link)
                            <a href="{{ $link['href'] }}" @if(!empty($link['external'])) target="_blank" rel="noopener noreferrer" @endif class="block px-4 py-2 text-sm text-gray-500 hover:bg-gray-200 rounded pl-10">↳ {{ $link['label'] }}</a>
                        @endforeach
                    @else
                        <a href="{{ $item['href'] }}" class="block px-4 py-2 text-sm text-gray-500 hover:bg-gray-200 rounded pl-10">↳ {{ $item['label'] }}</a>
                    @endif
                @endforeach
                <div class="px-4 pt-2 text-[11px] font-bold uppercase tracking-[0.08em] text-[#354776]">Publikasi</div>
                @foreach ($publikasiMenu as $item)
                    <div class="px-4 py-1 text-xs font-semibold text-gray-400 pl-7">{{ $item['label'] }}</div>
                    @foreach ($item['children'] as $link)
                        <a href="{{ $link['href'] }}" @if(!empty($link['external'])) target="_blank" rel="noopener noreferrer" @endif class="block px-4 py-2 text-sm text-gray-500 hover:bg-gray-200 rounded pl-10">↳ {{ $link['label'] }}</a>
                    @endforeach
                @endforeach
                <div class="px-4 pt-2 text-[11px] font-bold uppercase tracking-[0.08em] text-[#354776]">Saran dan Pengaduan</div>
                @foreach ($pengaduanMenu as $link)
                    <a href="{{ $link['href'] }}" @if(!empty($link['external'])) target="_blank" rel="noopener noreferrer" @endif class="block px-4 py-2 text-sm text-gray-500 hover:bg-gray-200 rounded pl-7">↳ {{ $link['label'] }}</a>
                @endforeach
                <form action="{{ url('/berita') }}" method="GET" class="px-4 pt-1">
                    <div class="flex border border-gray-300 rounded overflow-hidden">
                        <input type="text" name="search" placeholder="Cari..." class="flex-1 px-3 py-1.5 text-sm bg-white focus:outline-none">
                        <button type="submit" class="bg-[#354776] text-white px-3 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </form>
                <div class="px-4 pt-2">
                    @auth
                        <a href="{{ auth()->user()->is_admin ? url('/dashboard') : url('/profile') }}" class="block bg-[#354776] text-white text-center py-2 rounded text-sm">{{ auth()->user()->username }}</a>
                    @else
                        <a href="{{ url('/login') }}" class="block bg-amber-400 text-[#354776] font-bold text-center py-2 rounded text-sm">LOGIN</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
