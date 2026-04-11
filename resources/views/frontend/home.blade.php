@extends('frontend.layouts.mainTailwind')

@section('content')
    @php
        $urls = \App\Models\UrlLayanan::all();
        $footer = \App\Models\FooterSetting::first();

        // Resolve social media by name (IDs vary per install)
        $sm_ig = $urls->where('name', 'Instagram')->first();
        $sm_fb = $urls->where('name', 'Facebook')->first();
        $sm_yt =
            $urls->where('name', 'Youtube')->first() ??
            $urls->filter(fn($u) => str_contains($u->url ?? '', 'youtube.com/channel'))->first();
        $sm_wa = $urls->filter(fn($u) => str_contains($u->url ?? '', 'wa.me'))->first() ?? $urls->find(8);

        // Service URLs
        $url_advis = $url ?? null; // UrlLayanan::find(3) passed from controller
        $url_livechat = $sm_wa;

        // Carousel images — use BTR logo as fallback when path_image is empty
        $fallback_img = asset('assets/balaiRawa.png');
    @endphp

    {{-- ===================================================================
     STICKY HEADER
     Row 1 (white): search bar + LOGIN + ID/EN toggle (click-based)
     Row 2 (grey):  logo + name + date/time (sejajar) LEFT | nav RIGHT
=================================================================== --}}
    <div class="sticky top-0 z-50 shadow-sm" x-data="{ mobileOpen: false, langOpen: false }">

        {{-- Row 1: White top bar — same container width as Row 2 --}}
        <div class="bg-white border-b border-gray-200 hidden md:block py-1.5">
        <div class="max-w-screen-xl mx-auto px-4 flex items-center justify-between">

            <span id="topbar-time" class="text-[11px] text-gray-500 font-medium"></span>

            <div class="flex items-center gap-2">
                {{-- Search — right beside login --}}
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
                    <div class="nav-item relative">
                        <button
                            class="flex items-center gap-1 bg-amber-400 hover:bg-amber-300 text-[#354776] px-3 py-1 rounded text-[11px] font-bold transition-colors cursor-pointer">
                            <i class="fas fa-user-circle text-[10px]"></i>
                            {{ \Illuminate\Support\Str::limit(auth()->user()->username, 10) }}
                            <i class="fas fa-caret-down text-[9px]"></i>
                        </button>
                        <ul
                            class="nav-dropdown absolute right-0 top-full bg-white text-gray-800 shadow-xl min-w-[160px] z-50 border-t-2 border-[#354776] rounded-b-md mt-1">
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

                {{-- Language toggle — Alpine.js click, closes on outside click --}}
                <div class="relative" x-data="{ langOpen: false }">
                    <button @click="langOpen = !langOpen"
                        class="flex items-center gap-1 border border-gray-300 hover:border-[#354776] bg-white px-2.5 py-1 rounded text-[11px] font-semibold text-gray-600 hover:text-[#354776] transition-colors cursor-pointer">
                        ID <i class="fas fa-caret-down text-[9px]" :class="langOpen ? 'rotate-180' : ''"
                            style="transition:transform .2s"></i>
                    </button>
                    <ul x-show="langOpen" @click.away="langOpen = false" x-cloak
                        x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        class="absolute right-0 top-full mt-1 bg-white text-gray-800 shadow-lg min-w-[90px] z-50 border-t-2 border-[#354776] rounded-b-md">
                        <li>
                            <button @click="langOpen = false"
                                class="flex items-center gap-2 w-full text-left px-3 py-2 text-xs hover:bg-gray-50 border-b border-gray-100 font-medium cursor-pointer">
                                🇮🇩 <span>ID</span>
                            </button>
                        </li>
                        <li>
                            <button @click="langOpen = false"
                                class="flex items-center gap-2 w-full text-left px-3 py-2 text-xs hover:bg-gray-50 cursor-pointer">
                                🇬🇧 <span>EN</span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>{{-- inner container --}}
        </div>{{-- bg-white --}}

        {{-- Row 2: Grey bar — logo + date/time (sejajar) LEFT | nav items RIGHT --}}
        <div class="bg-gray-100 border-b border-gray-300">
            <div class="max-w-screen-xl mx-auto px-4">
                <div class="flex items-center justify-between" style="min-height:64px">

                    {{-- LEFT: Logo + company name (visible on all sizes) --}}
                    <a href="{{ url('/home') }}" class="flex items-center gap-3 py-2 flex-shrink-0">
                        <img src="{{ imageExists(config('app.logo')) }}" alt="Logo BTR" class="h-12 w-auto">
                        <div class="leading-tight">
                            <div class="font-bold text-[14px] tracking-wide text-[#354776]">BALAI TEKNIK RAWA</div>
                            <div class="text-[9px] text-gray-500 leading-snug hidden sm:block">Direktorat Bina Teknik Sumber
                                Daya Air</div>
                            <div class="text-[9px] text-gray-500 leading-snug hidden sm:block">Direktorat Jenderal Sumber
                                Daya Air</div>
                            <div class="text-[9px] text-gray-500 leading-snug hidden sm:block">Kementerian Pekerjaan Umum
                            </div>
                        </div>

                    </a>

                    {{-- RIGHT: Nav items (desktop) --}}
                    <div class="hidden md:flex items-center">

                        <a href="{{ url('/home') }}"
                            class="px-3 py-5 text-[13px] font-medium text-gray-700 hover:text-[#354776] hover:bg-gray-200 transition-colors whitespace-nowrap">
                            Beranda
                        </a>

                        <div class="nav-item relative">
                            <button
                                class="px-3 py-5 text-[13px] font-medium text-gray-700 hover:text-[#354776] hover:bg-gray-200 transition-colors flex items-center gap-1 whitespace-nowrap cursor-pointer">
                                Profil <i class="fas fa-caret-down text-[10px] text-gray-400"></i>
                            </button>
                            <ul
                                class="nav-dropdown absolute left-0 top-full bg-white text-gray-800 shadow-xl min-w-[200px] z-50 border-t-2 border-[#354776] rounded-b-md">
                                <li><a href="{{ url('/visi-misi') }}"
                                        class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Visi dan
                                        Misi</a></li>
                                <li><a href="{{ url('/sejarah') }}"
                                        class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Sejarah</a>
                                </li>
                                <li><a href="{{ url('/tugas') }}"
                                        class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Tugas
                                        dan Fungsi</a></li>
                                <li><a href="{{ url('/struktur-organisasi') }}"
                                        class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Struktur
                                        Organisasi</a></li>
                                <li><a href="{{ url('/info-pegawai') }}"
                                        class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Informasi
                                        Pegawai</a></li>
                                <li><a href="{{ url('/fasilitas-balai') }}"
                                        class="block px-4 py-2.5 text-sm hover:bg-gray-50">Fasilitas Balai</a></li>
                            </ul>
                        </div>

                        <div class="nav-item relative">
                            <button
                                class="px-3 py-5 text-[13px] font-medium text-gray-700 hover:text-[#354776] hover:bg-gray-200 transition-colors flex items-center gap-1 whitespace-nowrap cursor-pointer">
                                Layanan <i class="fas fa-caret-down text-[10px] text-gray-400"></i>
                            </button>
                            <ul
                                class="nav-dropdown absolute left-0 top-full bg-white text-gray-800 shadow-xl min-w-[210px] z-50 border-t-2 border-[#354776] rounded-b-md">
                                <li><a href="{{ url('/advis-teknis') }}"
                                        class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Advis
                                        Teknis</a></li>
                                <li><a href="{{ url('/pengujian-laboratorium') }}"
                                        class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Pengujian
                                        Laboratorium</a></li>
                                <li><a href="{{ $url_advis->url ?? '#' }}" target="_blank"
                                        class="block px-4 py-2.5 text-sm hover:bg-gray-50">Permohonan Data</a></li>
                            </ul>
                        </div>

                        <div class="nav-item relative">
                            <button
                                class="px-3 py-5 text-[13px] font-medium text-gray-700 hover:text-[#354776] hover:bg-gray-200 transition-colors flex items-center gap-1 whitespace-nowrap cursor-pointer">
                                Publikasi <i class="fas fa-caret-down text-[10px] text-gray-400"></i>
                            </button>
                            <ul
                                class="nav-dropdown absolute left-0 top-full bg-white text-gray-800 shadow-xl min-w-[210px] z-50 border-t-2 border-[#354776] rounded-b-md">
                                <li><a href="{{ url('/berita') }}"
                                        class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Berita
                                        {{ config('app.name') }}</a></li>
                                <li><a href="{{ url('/foto') }}"
                                        class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Galeri
                                        Foto</a></li>
                                <li><a href="{{ url('/video') }}"
                                        class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Galeri
                                        Video</a></li>
                                <li><a href="{{ url('/karya-ilmiah') }}"
                                        class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Karya
                                        Ilmiah</a></li>
                                <li><a href="https://pustaka.pu.go.id/perpustakaan/balai-rawa" target="_blank"
                                        class="block px-4 py-2.5 text-sm hover:bg-gray-50">e-Perpustakaan</a></li>
                            </ul>
                        </div>

                        <div class="nav-item relative">
                            <button
                                class="px-3 py-5 text-[13px] font-medium text-gray-700 hover:text-[#354776] hover:bg-gray-200 transition-colors flex items-center gap-1 whitespace-nowrap cursor-pointer">
                                Saran dan Pengaduan <i class="fas fa-caret-down text-[10px] text-gray-400"></i>
                            </button>
                            <ul
                                class="nav-dropdown absolute right-0 top-full bg-white text-gray-800 shadow-xl min-w-[230px] z-50 border-t-2 border-[#354776] rounded-b-md">
                                <li><a href="https://eppid.pu.go.id/" target="_blank"
                                        class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">e-PPID</a>
                                </li>
                                <li><a href="https://wispu.pu.go.id/" target="_blank"
                                        class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Whistleblowing
                                        System</a></li>
                                <li><a href="https://www.lapor.go.id/" target="_blank"
                                        class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Pengaduan
                                        Masyarakat</a></li>
                                <li><a href="https://gol.itjen.pu.go.id/" target="_blank"
                                        class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Gratifikasi</a>
                                </li>
                                <li><a href="{{ $urls->filter(fn($u) => str_contains($u->url ?? '', 'survey'))->first()->url ?? '#' }}"
                                        target="_blank" class="block px-4 py-2.5 text-sm hover:bg-gray-50">Survey
                                        Kepuasan</a></li>
                            </ul>
                        </div>
                    </div>

                    {{-- Mobile: hamburger --}}
                    <button @click="mobileOpen = !mobileOpen"
                        class="md:hidden p-2 rounded hover:bg-gray-200 transition-colors cursor-pointer text-gray-700"
                        aria-label="Menu">
                        <i class="fas fa-bars text-lg" x-show="!mobileOpen"></i>
                        <i class="fas fa-times text-lg" x-show="mobileOpen" x-cloak></i>
                    </button>
                </div>

                {{-- Mobile menu --}}
                <div x-show="mobileOpen" x-cloak x-transition
                    class="md:hidden pb-3 border-t border-gray-200 space-y-0.5 pt-1">
                    <a href="{{ url('/home') }}"
                        class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-200 hover:text-[#354776] rounded font-medium">Beranda</a>
                    <a href="{{ url('/visi-misi') }}"
                        class="block px-4 py-2 text-sm text-gray-500 hover:bg-gray-200 rounded pl-7">↳ Visi &amp; Misi</a>
                    <a href="{{ url('/advis-teknis') }}"
                        class="block px-4 py-2 text-sm text-gray-500 hover:bg-gray-200 rounded pl-7">↳ Advis Teknis</a>
                    <a href="{{ url('/pengujian-laboratorium') }}"
                        class="block px-4 py-2 text-sm text-gray-500 hover:bg-gray-200 rounded pl-7">↳ Pengujian Lab</a>
                    <a href="{{ url('/berita') }}"
                        class="block px-4 py-2 text-sm text-gray-500 hover:bg-gray-200 rounded pl-7">↳ Berita</a>
                    <a href="https://www.lapor.go.id/"
                        class="block px-4 py-2 text-sm text-gray-500 hover:bg-gray-200 rounded pl-7" target="_blank">↳
                        Pengaduan</a>
                    {{-- Mobile search --}}
                    <form action="{{ url('/berita') }}" method="GET" class="px-4 pt-1">
                        <div class="flex border border-gray-300 rounded overflow-hidden">
                            <input type="text" name="search" placeholder="Cari..."
                                class="flex-1 px-3 py-1.5 text-sm bg-white focus:outline-none">
                            <button type="submit" class="bg-[#354776] text-white px-3 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                    <div class="px-4 pt-2">
                        @auth
                            <a href="{{ auth()->user()->is_admin ? url('/dashboard') : url('/profile') }}"
                                class="block bg-[#354776] text-white text-center py-2 rounded text-sm">{{ auth()->user()->username }}</a>
                        @else
                            <a href="{{ url('/login') }}"
                                class="block bg-amber-400 text-[#354776] font-bold text-center py-2 rounded text-sm">LOGIN</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /sticky header --}}


    {{-- ===================================================================
     HERO CAROUSEL
=================================================================== --}}
    <section x-data="{
        cur: 0,
        slides: [
            { img: '{{ $foto_home->find(1)->path_image ? asset($foto_home->find(1)->path_image) : $fallback_img }}', title: '{{ addslashes($foto_home->find(1)->title ?? config('app.name')) }}', desc: '{{ addslashes($foto_home->find(1)->deskripsi ?? '') }}' },
            { img: '{{ $foto_home->find(2)->path_image ? asset($foto_home->find(2)->path_image) : $fallback_img }}', title: '{{ addslashes($foto_home->find(2)->title ?? 'Balai Teknik Rawa') }}', desc: '{{ addslashes($foto_home->find(2)->deskripsi ?? '') }}' },
            { img: '{{ $foto_home->find(3)->path_image ? asset($foto_home->find(3)->path_image) : $fallback_img }}', title: '{{ addslashes($foto_home->find(3)->title ?? 'Kementerian PUPR') }}', desc: '{{ addslashes($foto_home->find(3)->deskripsi ?? '') }}' },
        ],
        timer: null,
        init() { this.timer = setInterval(() => this.cur = (this.cur + 1) % this.slides.length, 5000) },
        prev() { clearInterval(this.timer);
            this.cur = (this.cur - 1 + this.slides.length) % this.slides.length;
            this.init() },
        next() { clearInterval(this.timer);
            this.cur = (this.cur + 1) % this.slides.length;
            this.init() }
    }" x-init="init()" class="relative bg-[#354776] overflow-hidden"
        style="height:420px;">

        <template x-for="(s,i) in slides" :key="i">
            <div class="absolute inset-0 transition-opacity duration-700"
                :class="cur === i ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                <img :src="s.img" :alt="s.title" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
                <div class="absolute bottom-12 inset-x-0 text-center text-white px-6">
                    <h2 class="text-2xl md:text-4xl font-bold drop-shadow-lg" x-text="s.title"></h2>
                    <p class="mt-1 text-sm md:text-base drop-shadow" x-text="s.desc" x-show="s.desc"></p>
                </div>
            </div>
        </template>

        <button @click="prev()"
            class="absolute left-4 top-1/2 -translate-y-1/2 z-20 bg-black/30 hover:bg-black/50 text-white w-10 h-10 rounded-full flex items-center justify-center transition-colors cursor-pointer">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button @click="next()"
            class="absolute right-4 top-1/2 -translate-y-1/2 z-20 bg-black/30 hover:bg-black/50 text-white w-10 h-10 rounded-full flex items-center justify-center transition-colors cursor-pointer">
            <i class="fas fa-chevron-right"></i>
        </button>
        <div class="absolute bottom-4 inset-x-0 flex justify-center gap-2 z-20">
            <template x-for="(_,i) in slides" :key="i">
                <button @click="cur=i; clearInterval(timer); init()"
                    class="w-2.5 h-2.5 rounded-full transition-all cursor-pointer"
                    :class="cur === i ? 'bg-white scale-125' : 'bg-white/50'"></button>
            </template>
        </div>
    </section>


    {{-- ===================================================================
     PENGUMUMAN TICKER
=================================================================== --}}
    @if ($terkini->count())
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto flex items-stretch h-10">
                <div
                    class="bg-red-600 text-white text-xs font-bold uppercase tracking-wider px-4 flex items-center gap-2 shrink-0">
                    <i class="fas fa-bullhorn"></i>
                    <span class="hidden sm:inline">Pengumuman</span>
                </div>
                <div class="flex-1 overflow-hidden relative">
                    <div class="ticker-track flex items-center h-full">
                        @for ($d = 0; $d < 2; $d++)
                            @foreach ($terkini->take(6) as $item)
                                <a href="{{ url('berita', ['slug' => $item->slug]) }}"
                                    class="shrink-0 inline-flex items-center gap-1.5 text-sm text-gray-700 hover:text-[#354776] transition-colors mr-10 cursor-pointer">
                                    <span
                                        class="text-[#354776] font-semibold text-xs shrink-0">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</span>
                                    <span class="truncate max-w-xs">{{ $item->title }}</span>
                                </a>
                            @endforeach
                        @endfor
                    </div>
                </div>
                <a href="{{ url('/berita') }}"
                    class="bg-[#354776] hover:bg-[#2a3a61] text-white text-xs font-semibold px-4 flex items-center gap-1 shrink-0 transition-colors cursor-pointer">
                    Lihat Semua <i class="fas fa-angle-right text-xs"></i>
                </a>
            </div>
        </div>
    @endif


    {{-- ===================================================================
     TENTANG KAMI
=================================================================== --}}
    <section class="bg-white py-12 px-4">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-[#354776]">Tentang Kami</h2>
                <div class="w-16 h-1 bg-amber-400 mx-auto mt-2 rounded-full"></div>
            </div>
            <div class="text-gray-700 text-sm md:text-base leading-relaxed text-justify">
                @if (!empty($url_yt) && !empty($url_yt->deskripsi))
                    {!! nl2br(e(strip_tags($url_yt->deskripsi))) !!}
                @else
                    <p class="mb-4">
                        Balai Teknik Rawa merupakan Unit Pelaksana Teknis (UPT) di lingkungan Direktorat Jenderal
                        Sumber Daya Air, Kementerian Pekerjaan Umum dan Perumahan Rakyat yang berlokasi di Palembang,
                        Sumatera Selatan. Balai Teknik Rawa mempunyai tugas melaksanakan penelitian, pengembangan,
                        penerapan, pengujian, dan layanan teknik di bidang rawa.
                    </p>
                    <p>
                        Dalam melaksanakan tugasnya, Balai Teknik Rawa menyelenggarakan fungsi pelaksanaan penelitian
                        dan pengembangan di bidang rawa, pelaksanaan penerapan teknologi di bidang rawa, pengujian
                        laboratorium, serta pemberian advis teknik dan pelayanan jasa rekayasa.
                    </p>
                @endif
            </div>
        </div>
    </section>


    {{-- ===================================================================
     PELAYANAN KAMI
=================================================================== --}}
    <section class="bg-amber-400 py-12 px-4">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-white drop-shadow">Pelayanan Kami</h2>
                <div class="w-16 h-1 bg-white mx-auto mt-2 rounded-full"></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

                <a href="{{ url('/advis-teknis') }}"
                    class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-200 p-6 flex flex-col items-center text-center cursor-pointer group">
                    <div
                        class="w-16 h-16 rounded-full bg-[#354776]/10 flex items-center justify-center mb-3 group-hover:bg-[#354776]/20 transition-colors">
                        <img src="{{ asset('assets/technical-support.png') }}" alt="Advis Teknis"
                            class="w-9 h-9 object-contain"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <i class="fas fa-drafting-compass text-[#354776] text-2xl hidden"></i>
                    </div>
                    <span
                        class="bg-[#354776] text-white text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded mb-2">Layanan</span>
                    <h3 class="font-bold text-[#354776] text-sm leading-snug">Layanan Advis Teknis</h3>
                    <p class="text-gray-500 text-xs mt-1.5 leading-relaxed">Konsultasi &amp; rekomendasi teknis bidang rawa
                    </p>
                </a>

                <a href="{{ url('/pengujian-laboratorium') }}"
                    class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-200 p-6 flex flex-col items-center text-center cursor-pointer group">
                    <div
                        class="w-16 h-16 rounded-full bg-[#354776]/10 flex items-center justify-center mb-3 group-hover:bg-[#354776]/20 transition-colors">
                        <img src="{{ asset('assets/icon/laboratory.png') }}" alt="Laboratorium"
                            class="w-9 h-9 object-contain"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <i class="fas fa-flask text-[#354776] text-2xl hidden"></i>
                    </div>
                    <span
                        class="bg-[#354776] text-white text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded mb-2">Layanan</span>
                    <h3 class="font-bold text-[#354776] text-sm leading-snug">Pengujian Laboratorium</h3>
                    <p class="text-gray-500 text-xs mt-1.5 leading-relaxed">Pengujian kualitas tanah, air &amp; bahan</p>
                </a>

                <a href="{{ $url_advis->url ?? '#' }}" {{ isset($url_advis) ? 'target="_blank"' : '' }}
                    class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-200 p-6 flex flex-col items-center text-center cursor-pointer group">
                    <div
                        class="w-16 h-16 rounded-full bg-[#354776]/10 flex items-center justify-center mb-3 group-hover:bg-[#354776]/20 transition-colors">
                        <img src="{{ asset('assets/icon/permohonanIcon.png') }}" alt="Data"
                            class="w-9 h-9 object-contain"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <i class="fas fa-database text-[#354776] text-2xl hidden"></i>
                    </div>
                    <span
                        class="bg-[#354776] text-white text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded mb-2">Layanan</span>
                    <h3 class="font-bold text-[#354776] text-sm leading-snug">Data &amp; Informasi</h3>
                    <p class="text-gray-500 text-xs mt-1.5 leading-relaxed">Permohonan data &amp; informasi publik rawa</p>
                </a>

            </div>
        </div>
    </section>


    {{-- ===================================================================
     INFORMASI PERMOHONAN LAYANAN
=================================================================== --}}
    <section class="bg-gray-50 py-12 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-8">
                <h2 class="text-xl md:text-2xl font-bold text-[#354776]">Informasi Permohonan Layanan</h2>
                <div class="w-16 h-1 bg-amber-400 mx-auto mt-2 rounded-full"></div>
            </div>
            @php
                $icons = ['fas fa-drafting-compass', 'fas fa-flask', 'fas fa-database'];
                $defaultNames = ['Advis Teknis', 'Laboratorium', 'Data & Informasi'];
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @foreach ($statsLayanan as $i => $stat)
                    <div class="bg-white rounded-xl overflow-hidden shadow border border-gray-100">
                        <div class="bg-[#354776] px-4 py-3 flex items-center gap-2">
                            <i class="{{ $icons[$i] ?? 'fas fa-clipboard-list' }} text-amber-400 text-sm"></i>
                            <h3 class="text-white font-semibold text-sm truncate">
                                {{ $stat['name'] ?: $defaultNames[$i] ?? 'Layanan' }}</h3>
                        </div>
                        <div class="p-4 grid grid-cols-4 gap-2">
                            @foreach ([['Semua', $stat['all']], ['Baru', $stat['baru']], ['Proses', $stat['proses']], ['Selesai', $stat['selesai']]] as [$lbl, $val])
                                <div class="bg-[#354776] rounded-lg py-3 flex flex-col items-center">
                                    <span
                                        class="text-white text-xl font-extrabold leading-none">{{ $val }}</span>
                                    <span
                                        class="text-white/60 text-[9px] mt-1 uppercase tracking-wide">{{ $lbl }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    {{-- ===================================================================
     INFORMASI PERMOHONAN LABORATORIUM
=================================================================== --}}
    <section class="bg-white py-12 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-8">
                <h2 class="text-xl md:text-2xl font-bold text-[#354776]">Informasi Permohonan Laboratorium</h2>
                <div class="w-16 h-1 bg-amber-400 mx-auto mt-2 rounded-full"></div>
            </div>
            @php $lab = $statsLayanan[1] ?? ['all'=>0,'baru'=>0,'proses'=>0,'selesai'=>0]; @endphp
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                {{-- Lab All --}}
                <div class="bg-gray-50 rounded-xl overflow-hidden shadow border border-gray-100">
                    <div class="bg-[#354776] px-4 py-2.5 flex items-center gap-2">
                        <i class="fas fa-vials text-amber-400 text-sm"></i>
                        <h3 class="text-white font-semibold text-sm">Lab All</h3>
                    </div>
                    <div class="p-4 grid grid-cols-4 gap-2">
                        @foreach ([['All', $lab['all']], ['Baru', $lab['baru']], ['Proses', $lab['proses']], ['Selesai', $lab['selesai']]] as [$lbl, $val])
                            <div class="bg-[#354776] rounded-lg py-2.5 flex flex-col items-center">
                                <span class="text-white text-lg font-extrabold leading-none">{{ $val }}</span>
                                <span class="text-white/60 text-[9px] mt-0.5 uppercase">{{ $lbl }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{-- Lab Tersisa --}}
                <div class="bg-gray-50 rounded-xl overflow-hidden shadow border border-gray-100">
                    <div class="bg-[#354776] px-4 py-2.5 flex items-center gap-2">
                        <i class="fas fa-clipboard-check text-amber-400 text-sm"></i>
                        <h3 class="text-white font-semibold text-sm">Lab Tersisa</h3>
                    </div>
                    <div class="p-4 flex flex-col items-center justify-center" style="min-height:88px;">
                        <span
                            class="text-[#354776] text-5xl font-extrabold">{{ max(0, $lab['all'] - $lab['selesai']) }}</span>
                        <span class="text-gray-500 text-xs mt-1">permohonan tersisa</span>
                    </div>
                </div>
                {{-- Transportasi --}}
                <div class="bg-gray-50 rounded-xl overflow-hidden shadow border border-gray-100">
                    <div class="bg-[#354776] px-4 py-2.5 flex items-center gap-2">
                        <i class="fas fa-truck text-amber-400 text-sm"></i>
                        <h3 class="text-white font-semibold text-sm">Transportasi</h3>
                    </div>
                    <div class="p-4 flex flex-col items-center justify-center" style="min-height:88px;">
                        <span class="text-[#354776] text-5xl font-extrabold">{{ $lab['proses'] }}</span>
                        <span class="text-gray-500 text-xs mt-1">dalam proses</span>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- ===================================================================
     BERITA TERKINI
=================================================================== --}}
    <section class="bg-gray-50 py-12 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-[#354776]">Berita Terkini</h2>
                <div class="w-16 h-1 bg-amber-400 mx-auto mt-2 rounded-full"></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($terkini->take(3) as $post)
                    <div
                        class="bg-white rounded-xl shadow hover:shadow-lg transition-shadow overflow-hidden flex flex-col">
                        <div class="relative overflow-hidden h-48">
                            <img src="{{ $post->image ? asset($post->image) : 'https://picsum.photos/seed/' . ($post->id ?? 1) . '/500/300' }}"
                                alt="{{ $post->title }}" loading="lazy"
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                            @if ($post->category)
                                <span
                                    class="absolute top-3 left-3 bg-[#354776] text-white text-[10px] font-bold uppercase px-2 py-0.5 rounded">
                                    {{ $post->category->name }}
                                </span>
                            @endif
                        </div>
                        <div class="p-4 flex flex-col flex-1">
                            <p class="text-gray-400 text-xs mb-1.5 flex items-center gap-1">
                                <i class="far fa-calendar-alt"></i>
                                {{ \Carbon\Carbon::parse($post->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}
                            </p>
                            <h3 class="font-bold text-gray-800 text-sm leading-snug mb-2 line-clamp-2 flex-1">
                                {{ $post->title }}</h3>
                            <p class="text-gray-500 text-xs leading-relaxed mb-3 line-clamp-2">
                                {{ \Illuminate\Support\Str::limit(strip_tags($post->excerpt ?? ''), 120) }}
                            </p>
                            <a href="{{ url('berita', ['slug' => $post->slug]) }}"
                                class="mt-auto bg-[#354776] hover:bg-[#2a3a61] text-white text-xs font-semibold px-4 py-2 rounded text-center transition-colors cursor-pointer">
                                Selengkapnya &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-10 text-gray-400">
                        <i class="fas fa-newspaper text-4xl mb-3"></i>
                        <p>Belum ada berita terkini.</p>
                    </div>
                @endforelse
            </div>
            @if ($terkini->count() > 3)
                <div class="text-center mt-8">
                    <a href="{{ url('/berita') }}"
                        class="bg-[#354776] hover:bg-[#2a3a61] text-white font-semibold px-8 py-2.5 rounded-full text-sm transition-colors cursor-pointer">
                        Lihat Semua Berita
                    </a>
                </div>
            @endif
        </div>
    </section>


    {{-- ===================================================================
     ZONA INTEGRITAS  +  SOSIAL MEDIA
=================================================================== --}}
    <section class="bg-white py-12 px-4">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- Zona Integritas --}}
            <div>
                <h3 class="text-lg font-bold text-[#354776] mb-1">Zona Integritas</h3>
                <div class="w-10 h-1 bg-amber-400 mb-5 rounded-full"></div>
                <div
                    class="bg-gray-50 rounded-xl border border-gray-200 p-5 flex flex-wrap gap-4 items-center justify-center min-h-[120px]">
                    <img src="{{ asset('assets/balaiRawa.png') }}" alt="BTR" class="h-24 object-contain"
                        onerror="this.style.display='none'">
                    <div class="flex flex-col gap-2">
                        <div class="bg-[#354776] rounded-lg px-5 py-3 text-center">
                            <p class="text-white font-black text-xl tracking-wider">WBK</p>
                            <p class="text-white/60 text-[10px] mt-0.5">Wilayah Bebas Korupsi</p>
                        </div>
                        <div class="bg-amber-400 rounded-lg px-5 py-3 text-center">
                            <p class="text-white font-black text-xl tracking-wider">WBBM</p>
                            <p class="text-white/60 text-[10px] mt-0.5">Birokrasi Bersih Melayani</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sosial Media --}}
            <div>
                <h3 class="text-lg font-bold text-[#354776] mb-1">Sosial Media</h3>
                <div class="w-10 h-1 bg-amber-400 mb-5 rounded-full"></div>
                <div class="space-y-3">
                    @if ($sm_yt)
                        <a href="{{ $sm_yt->url }}" target="_blank"
                            class="flex items-center gap-4 bg-red-50 hover:bg-red-100 border border-red-100 rounded-xl px-5 py-3 transition-colors cursor-pointer group">
                            <div
                                class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <i class="fab fa-youtube text-white text-lg"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">YouTube</p>
                                <p class="text-gray-400 text-xs">Balai Teknik Rawa Official</p>
                            </div>
                            <i class="fas fa-external-link-alt ml-auto text-gray-300 text-xs"></i>
                        </a>
                    @endif
                    @if ($sm_fb)
                        <a href="{{ $sm_fb->url }}" target="_blank"
                            class="flex items-center gap-4 bg-blue-50 hover:bg-blue-100 border border-blue-100 rounded-xl px-5 py-3 transition-colors cursor-pointer group">
                            <div
                                class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <i class="fab fa-facebook text-white text-lg"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Facebook</p>
                                <p class="text-gray-400 text-xs">Balai Teknik Rawa</p>
                            </div>
                            <i class="fas fa-external-link-alt ml-auto text-gray-300 text-xs"></i>
                        </a>
                    @endif
                    @if ($sm_ig)
                        <a href="{{ $sm_ig->url }}" target="_blank"
                            class="flex items-center gap-4 bg-pink-50 hover:bg-pink-100 border border-pink-100 rounded-xl px-5 py-3 transition-colors cursor-pointer group">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-pink-500 to-purple-600 rounded-full flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <i class="fab fa-instagram text-white text-lg"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Instagram</p>
                                <p class="text-gray-400 text-xs">@pupr_sda_baltekrawa</p>
                            </div>
                            <i class="fas fa-external-link-alt ml-auto text-gray-300 text-xs"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>


    {{-- ===================================================================
     LAYANAN PENGADUAN  +  SITUS TERKAIT
=================================================================== --}}
    <section class="bg-gray-50 py-12 px-4 border-t border-gray-200">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- Layanan Pengaduan --}}
            <div>
                <h3 class="text-lg font-bold text-[#354776] mb-1">Layanan Pengaduan</h3>
                <div class="w-10 h-1 bg-amber-400 mb-5 rounded-full"></div>
                <div class="flex flex-wrap gap-3 items-center">
                    <a href="https://www.lapor.go.id/" target="_blank"
                        class="flex items-center gap-2 bg-white border border-gray-200 hover:border-[#354776]/40 hover:shadow-md rounded-xl p-3 transition-all cursor-pointer">
                        <div class="w-10 h-10 bg-[#354776]/10 rounded-lg flex items-center justify-center shrink-0">
                            <i class="fas fa-comment-dots text-[#354776] text-lg"></i>
                        </div>
                        <div>
                            <p class="font-bold text-xs text-[#354776]">SP4N LAPOR!</p>
                            <p class="text-gray-400 text-[10px]">Pengaduan Publik</p>
                        </div>
                    </a>
                    <a href="https://eppid.pu.go.id/" target="_blank"
                        class="flex items-center gap-2 bg-white border border-gray-200 hover:border-[#354776]/40 hover:shadow-md rounded-xl p-3 transition-all cursor-pointer">
                        <div class="w-10 h-10 bg-[#354776]/10 rounded-lg flex items-center justify-center shrink-0">
                            <i class="fas fa-shield-alt text-[#354776] text-lg"></i>
                        </div>
                        <div>
                            <p class="font-bold text-xs text-[#354776]">e-PPID</p>
                            <p class="text-gray-400 text-[10px]">Informasi Publik</p>
                        </div>
                    </a>
                    <a href="https://wispu.pu.go.id/" target="_blank"
                        class="flex items-center gap-2 bg-white border border-gray-200 hover:border-[#354776]/40 hover:shadow-md rounded-xl p-3 transition-all cursor-pointer">
                        <div class="w-10 h-10 bg-[#354776]/10 rounded-lg flex items-center justify-center shrink-0">
                            <i class="fas fa-user-secret text-[#354776] text-lg"></i>
                        </div>
                        <div>
                            <p class="font-bold text-xs text-[#354776]">WBS</p>
                            <p class="text-gray-400 text-[10px]">Whistleblowing</p>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Situs Terkait --}}
            <div>
                <h3 class="text-lg font-bold text-[#354776] mb-1">Situs Terkait</h3>
                <div class="w-10 h-1 bg-amber-400 mb-5 rounded-full"></div>
                @if ($situsTerkait->count())
                    <div class="flex flex-wrap gap-3 items-center">
                        @foreach ($situsTerkait->take(6) as $situs)
                            <a href="{{ $situs->url }}" target="_blank"
                                class="bg-white border border-gray-200 hover:border-[#354776]/40 hover:shadow-md rounded-xl p-2.5 transition-all cursor-pointer"
                                title="{{ $situs->title }}">
                                <img src="{{ imageExists($situs->path_image) }}" alt="{{ $situs->title }}"
                                    class="h-10 w-auto max-w-[80px] object-contain"
                                    onerror="this.src='{{ asset('assets/logoFooter.png') }}'">
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400 text-sm italic">Belum ada situs terkait.</p>
                @endif
            </div>

        </div>
    </section>


    {{-- ===================================================================
     FOOTER
=================================================================== --}}
    <footer class="bg-[#354776] text-white">
        <div class="max-w-6xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- Info + Statistik --}}
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <img src="{{ imageExists(config('app.logo')) }}" alt="Logo" class="h-10 w-auto opacity-80">
                    <div>
                        <h4 class="font-bold text-base leading-tight">{{ config('app.name') }}</h4>
                        <p class="text-white/60 text-[11px] leading-tight">
                            {{ $footer->nama_kementerian ?? 'Kementerian PUPR' }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <h5 class="font-semibold text-xs text-amber-400 uppercase tracking-wider mb-2">Statistik Pengunjung
                    </h5>
                    <table class="text-sm w-full">
                        @foreach ([['Hari ini', '—'], ['7 hari terakhir', '—'], ['30 hari terakhir', '—'], ['Sepanjang waktu', '—']] as [$lbl, $val])
                            <tr class="border-b border-white/10">
                                <td class="py-1 text-white/60 text-xs">{{ $lbl }}</td>
                                <td class="py-1 text-right font-semibold text-xs">{{ $val }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            {{-- Hubungi Kami --}}
            <div>
                <h4 class="font-bold text-base mb-4">Hubungi Kami</h4>
                <ul class="space-y-2.5 text-sm">
                    <li class="flex items-start gap-2.5">
                        <i class="fas fa-map-marker-alt text-amber-400 mt-0.5 shrink-0 text-sm"></i>
                        <span
                            class="text-white/75 text-xs leading-relaxed">{{ $footer->alamat ?? 'Jl. Kol. H. Burlian Km. 7, Palembang, Sumatera Selatan' }}</span>
                    </li>
                    @if ($footer && $footer->no_hp)
                        <li class="flex items-center gap-2.5">
                            <i class="fas fa-phone text-amber-400 text-sm shrink-0"></i>
                            <span class="text-white/75 text-xs">{{ $footer->no_hp }}</span>
                        </li>
                    @endif
                    @if ($footer && $footer->email)
                        <li class="flex items-center gap-2.5">
                            <i class="fas fa-envelope text-amber-400 text-sm shrink-0"></i>
                            <span class="text-white/75 text-xs">{{ $footer->email }}</span>
                        </li>
                    @endif
                </ul>
                <div class="flex gap-2.5 mt-4">
                    @if ($sm_ig)
                        <a href="{{ $sm_ig->url }}" target="_blank"
                            class="w-8 h-8 bg-white/10 hover:bg-pink-500 rounded-full flex items-center justify-center transition-colors cursor-pointer"><i
                                class="fab fa-instagram text-sm"></i></a>
                    @endif
                    @if ($sm_fb)
                        <a href="{{ $sm_fb->url }}" target="_blank"
                            class="w-8 h-8 bg-white/10 hover:bg-blue-500 rounded-full flex items-center justify-center transition-colors cursor-pointer"><i
                                class="fab fa-facebook text-sm"></i></a>
                    @endif
                    @if ($sm_yt)
                        <a href="{{ $sm_yt->url }}" target="_blank"
                            class="w-8 h-8 bg-white/10 hover:bg-red-600 rounded-full flex items-center justify-center transition-colors cursor-pointer"><i
                                class="fab fa-youtube text-sm"></i></a>
                    @endif
                </div>
            </div>

            {{-- Lokasi Map --}}
            <div>
                <h4 class="font-bold text-base mb-4">Lokasi</h4>
                <div class="rounded-xl overflow-hidden border border-white/20 h-44">
                    <iframe
                        src="https://maps.google.com/maps?q=balai+teknik+rawa+palembang&t=&z=14&ie=UTF8&iwloc=&output=embed"
                        class="w-full h-full" frameborder="0" loading="lazy" allowfullscreen></iframe>
                </div>
            </div>
        </div>

        <div class="border-t border-white/10 py-3 px-4 text-center text-xs text-white/50">
            Copyright &copy; <span id="copy-year"></span> {{ config('app.name') }}, Balai Teknik Rawa. All Rights
            Reserved.
        </div>
    </footer>

    {{-- Floating WhatsApp --}}
    @if ($url_livechat)
        <a href="{{ $url_livechat->url }}" target="_blank"
            class="fixed bottom-6 right-6 z-50 bg-green-500 hover:bg-green-400 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-xl transition-colors cursor-pointer group"
            title="Tanya Kami 24 Jam">
            <i class="fab fa-whatsapp text-2xl group-hover:scale-110 transition-transform"></i>
        </a>
    @endif

@endsection

@section('scripts')
    <script>
        (function() {
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                'Oktober', 'November', 'Desember'
            ];

            function tick() {
                const d = new Date();
                const el = document.getElementById('topbar-time');
                if (el) el.textContent = d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear() + '  |  ' +
                    String(d.getHours()).padStart(2, '0') + ':' + String(d.getMinutes()).padStart(2, '0') + ':' +
                    String(d.getSeconds()).padStart(2, '0');
            }
            tick();
            setInterval(tick, 1000);
            const yr = document.getElementById('copy-year');
            if (yr) yr.textContent = new Date().getFullYear();
        })();
    </script>
@endsection
