@php
    $hdr_urls = \App\Models\UrlLayanan::all();
    $hdr_url_advis = $hdr_urls->firstWhere('id', 3);
@endphp

<div class="sticky top-0 z-50 shadow-sm" x-data="{ mobileOpen: false, langOpen: false }">

    {{-- Row 1: Dark Navy [#354776] top bar --}}
    <div class="bg-[#354776] border-b border-gray-200 hidden md:block py-1.5">
        <div class="max-w-screen-xl mx-auto px-4 flex items-center justify-between">

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
    <div class="bg-gray-100 border-b border-gray-300">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="flex items-center justify-between" style="min-height:64px">

                <a href="{{ url('/home') }}" class="flex items-center gap-3 py-2 flex-shrink-0">
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
                        class="px-3 py-5 text-[13px] font-medium text-gray-700 hover:text-[#354776] hover:bg-gray-200 transition-colors whitespace-nowrap">
                        Beranda
                    </a>

                    <div class="nav-item relative">
                        <button
                            class="px-3 py-5 text-[13px] font-medium text-gray-700 hover:text-[#354776] hover:bg-gray-200 transition-colors flex items-center gap-1 whitespace-nowrap cursor-pointer">
                            Profil <i class="fas fa-caret-down text-[10px] text-gray-400"></i>
                        </button>
                        <ul class="nav-dropdown absolute left-0 top-full bg-white text-gray-800 shadow-xl min-w-[200px] z-50 border-t-2 border-[#354776] rounded-b-md">
                            <li><a href="{{ url('/visi-misi') }}" class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Visi dan Misi</a></li>
                            <li><a href="{{ url('/sejarah') }}" class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Sejarah</a></li>
                            <li><a href="{{ url('/tugas') }}" class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Tugas dan Fungsi</a></li>
                            <li><a href="{{ url('/struktur-organisasi') }}" class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Struktur Organisasi</a></li>
                            <li><a href="{{ url('/info-pegawai') }}" class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Informasi Pegawai</a></li>
                            <li><a href="{{ url('/fasilitas-balai') }}" class="block px-4 py-2.5 text-sm hover:bg-gray-50">Fasilitas Balai</a></li>
                        </ul>
                    </div>

                    <div class="nav-item relative">
                        <button
                            class="px-3 py-5 text-[13px] font-medium text-gray-700 hover:text-[#354776] hover:bg-gray-200 transition-colors flex items-center gap-1 whitespace-nowrap cursor-pointer">
                            Layanan <i class="fas fa-caret-down text-[10px] text-gray-400"></i>
                        </button>
                        <ul class="nav-dropdown absolute left-0 top-full bg-white text-gray-800 shadow-xl min-w-[210px] z-50 border-t-2 border-[#354776] rounded-b-md">
                            <li><a href="{{ url('/advis-teknis') }}" class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Advis Teknis</a></li>
                            <li><a href="{{ url('/pengujian-laboratorium') }}" class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Pengujian Laboratorium</a></li>
                            <li><a href="{{ $hdr_url_advis->url ?? '#' }}" target="_blank" class="block px-4 py-2.5 text-sm hover:bg-gray-50">Permohonan Data</a></li>
                        </ul>
                    </div>

                    <div class="nav-item relative">
                        <button
                            class="px-3 py-5 text-[13px] font-medium text-gray-700 hover:text-[#354776] hover:bg-gray-200 transition-colors flex items-center gap-1 whitespace-nowrap cursor-pointer">
                            Publikasi <i class="fas fa-caret-down text-[10px] text-gray-400"></i>
                        </button>
                        <ul class="nav-dropdown absolute left-0 top-full bg-white text-gray-800 shadow-xl min-w-[210px] z-50 border-t-2 border-[#354776] rounded-b-md">
                            <li><a href="{{ url('/berita') }}" class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Berita {{ config('app.name') }}</a></li>
                            <li><a href="{{ url('/foto') }}" class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Galeri Foto</a></li>
                            <li><a href="{{ url('/video') }}" class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Galeri Video</a></li>
                            <li><a href="{{ url('/karya-ilmiah') }}" class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Karya Ilmiah</a></li>
                            <li><a href="https://pustaka.pu.go.id/perpustakaan/balai-rawa" target="_blank" class="block px-4 py-2.5 text-sm hover:bg-gray-50">e-Perpustakaan</a></li>
                        </ul>
                    </div>

                    <div class="nav-item relative">
                        <button
                            class="px-3 py-5 text-[13px] font-medium text-gray-700 hover:text-[#354776] hover:bg-gray-200 transition-colors flex items-center gap-1 whitespace-nowrap cursor-pointer">
                            Saran dan Pengaduan <i class="fas fa-caret-down text-[10px] text-gray-400"></i>
                        </button>
                        <ul class="nav-dropdown absolute right-0 top-full bg-white text-gray-800 shadow-xl min-w-[230px] z-50 border-t-2 border-[#354776] rounded-b-md">
                            <li><a href="https://eppid.pu.go.id/" target="_blank" class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">e-PPID</a></li>
                            <li><a href="https://wispu.pu.go.id/" target="_blank" class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Whistleblowing System</a></li>
                            <li><a href="https://www.lapor.go.id/" target="_blank" class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Pengaduan Masyarakat</a></li>
                            <li><a href="https://gol.itjen.pu.go.id/" target="_blank" class="block px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100">Gratifikasi</a></li>
                            <li><a href="{{ $hdr_urls->filter(fn($u) => str_contains($u->url ?? '', 'survey'))->first()->url ?? '#' }}" target="_blank" class="block px-4 py-2.5 text-sm hover:bg-gray-50">Survey Kepuasan</a></li>
                        </ul>
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
                <a href="{{ url('/visi-misi') }}" class="block px-4 py-2 text-sm text-gray-500 hover:bg-gray-200 rounded pl-7">↳ Visi &amp; Misi</a>
                <a href="{{ url('/advis-teknis') }}" class="block px-4 py-2 text-sm text-gray-500 hover:bg-gray-200 rounded pl-7">↳ Advis Teknis</a>
                <a href="{{ url('/pengujian-laboratorium') }}" class="block px-4 py-2 text-sm text-gray-500 hover:bg-gray-200 rounded pl-7">↳ Pengujian Lab</a>
                <a href="{{ url('/berita') }}" class="block px-4 py-2 text-sm text-gray-500 hover:bg-gray-200 rounded pl-7">↳ Berita</a>
                <a href="https://www.lapor.go.id/" class="block px-4 py-2 text-sm text-gray-500 hover:bg-gray-200 rounded pl-7" target="_blank">↳ Pengaduan</a>
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
