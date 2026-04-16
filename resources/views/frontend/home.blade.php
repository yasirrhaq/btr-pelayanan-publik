@extends('frontend.layouts.mainTailwind')

@section('container')
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
    @if ($pengumuman->count())
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
                            @foreach ($pengumuman as $item)
                                <a href="{{ route('pengumuman.show', $item) }}"
                                    class="shrink-0 inline-flex items-center gap-1.5 text-sm text-gray-700 hover:text-[#354776] transition-colors mr-10 cursor-pointer">
                                    <span
                                        class="text-[#354776] font-semibold text-xs shrink-0">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</span>
                                    <span class="truncate max-w-xs">{{ $item->judul }}</span>
                                </a>
                            @endforeach
                        @endfor
                    </div>
                </div>
                <a href="{{ route('pengumuman.index') }}"
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
                    class="bg-white rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-200 p-6 flex flex-col items-center text-center cursor-pointer group border border-white/60">
                    <div
                        class="w-24 h-24 rounded-2xl bg-[#354776] flex items-center justify-center mb-4 shadow-lg shadow-[#354776]/20 group-hover:bg-[#2a3a61] transition-colors p-4">
                        <img src="{{ asset('assets/technical-support.png') }}" alt="Advis Teknis"
                            class="w-full h-full object-contain brightness-0 invert"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <i class="fas fa-drafting-compass text-white text-4xl hidden"></i>
                    </div>
                    <span
                        class="bg-[#354776]/10 text-[#354776] text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-2">Layanan</span>
                    <h3 class="font-bold text-[#354776] text-base leading-snug">Layanan Advis Teknis</h3>
                    <p class="text-gray-500 text-sm mt-2 leading-relaxed">Konsultasi &amp; rekomendasi teknis bidang rawa
                    </p>
                </a>

                <a href="{{ url('/pengujian-laboratorium') }}"
                    class="bg-white rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-200 p-6 flex flex-col items-center text-center cursor-pointer group border border-white/60">
                    <div
                        class="w-24 h-24 rounded-2xl bg-[#354776] flex items-center justify-center mb-4 shadow-lg shadow-[#354776]/20 group-hover:bg-[#2a3a61] transition-colors p-4">
                        <img src="{{ asset('assets/icon/laboratory.png') }}" alt="Laboratorium"
                            class="w-full h-full object-contain brightness-0 invert"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <i class="fas fa-flask text-white text-4xl hidden"></i>
                    </div>
                    <span
                        class="bg-[#354776]/10 text-[#354776] text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-2">Layanan</span>
                    <h3 class="font-bold text-[#354776] text-base leading-snug">Pengujian Laboratorium</h3>
                    <p class="text-gray-500 text-sm mt-2 leading-relaxed">Pengujian kualitas tanah, air &amp; bahan</p>
                </a>

                <a href="{{ $url_advis->url ?? '#' }}" {{ isset($url_advis) ? 'target="_blank"' : '' }}
                    class="bg-white rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-200 p-6 flex flex-col items-center text-center cursor-pointer group border border-white/60">
                    <div
                        class="w-24 h-24 rounded-2xl bg-[#354776] flex items-center justify-center mb-4 shadow-lg shadow-[#354776]/20 group-hover:bg-[#2a3a61] transition-colors p-4">
                        <img src="{{ asset('assets/icon/permohonanIcon.png') }}" alt="Data"
                            class="w-full h-full object-contain brightness-0 invert"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <i class="fas fa-database text-white text-4xl hidden"></i>
                    </div>
                    <span
                        class="bg-[#354776]/10 text-[#354776] text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-2">Layanan</span>
                    <h3 class="font-bold text-[#354776] text-base leading-snug">Data &amp; Informasi</h3>
                    <p class="text-gray-500 text-sm mt-2 leading-relaxed">Permohonan data &amp; informasi publik rawa</p>
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
                $barColors = ['bg-amber-400', 'bg-[#354776]', 'bg-emerald-500'];
                $statsLayanan = collect($statsLayanan)->take(3)->values();
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @foreach ($statsLayanan as $i => $stat)
                    @php
                        $total = max(1, (int) ($stat['all'] ?? 0));
                        $bars = [
                            ['label' => 'Baru', 'value' => (int) ($stat['baru'] ?? 0), 'color' => 'bg-amber-400'],
                            ['label' => 'Proses', 'value' => (int) ($stat['proses'] ?? 0), 'color' => 'bg-[#354776]'],
                            ['label' => 'Selesai', 'value' => (int) ($stat['selesai'] ?? 0), 'color' => 'bg-emerald-500'],
                        ];
                    @endphp
                    <div class="bg-white rounded-xl overflow-hidden shadow border border-gray-100">
                        <div class="bg-[#354776] px-4 py-3 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2 min-w-0">
                                <i class="{{ $icons[$i] ?? 'fas fa-clipboard-list' }} text-amber-400 text-sm"></i>
                                <h3 class="text-white font-semibold text-sm truncate">
                                    {{ $stat['name'] ?: $defaultNames[$i] ?? 'Layanan' }}
                                </h3>
                            </div>
                            <div class="text-right shrink-0">
                                <div class="text-white text-2xl font-extrabold leading-none">{{ $stat['all'] }}</div>
                                <div class="text-white/60 text-[9px] mt-1 uppercase tracking-wide">Total</div>
                            </div>
                        </div>

                        <div class="p-4 space-y-4">
                            @foreach ($bars as $bar)
                                @php
                                    $steps = $stat['all'] > 0 ? (int) ceil(($bar['value'] / $total) * 12) : 0;
                                    $widthClass = match ($steps) {
                                        12 => 'w-full',
                                        11 => 'w-11/12',
                                        10 => 'w-10/12',
                                        9 => 'w-9/12',
                                        8 => 'w-8/12',
                                        7 => 'w-7/12',
                                        6 => 'w-6/12',
                                        5 => 'w-5/12',
                                        4 => 'w-4/12',
                                        3 => 'w-3/12',
                                        2 => 'w-2/12',
                                        1 => 'w-1/12',
                                        default => 'w-0',
                                    };
                                @endphp
                                <div>
                                    <div class="flex items-center justify-between mb-1.5 text-sm">
                                        <span class="font-medium text-slate-600">{{ $bar['label'] }}</span>
                                        <span class="font-bold text-[#354776]">{{ $bar['value'] }}</span>
                                    </div>
                                    <div class="h-3 rounded-full bg-slate-100 overflow-hidden">
                                        <div class="h-full rounded-full {{ $bar['color'] }} {{ $widthClass }} transition-all duration-500"></div>
                                    </div>
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
            @php
                $lab = $statsLayanan[1] ?? ['all' => 0, 'baru' => 0, 'proses' => 0, 'selesai' => 0];
                $labCards = [
                    ['name' => 'Lab Air', 'icon' => 'fas fa-tint'],
                    ['name' => 'Lab Tanah', 'icon' => 'fas fa-mountain'],
                    ['name' => 'Topografi', 'icon' => 'fas fa-map-marked-alt'],
                ];
            @endphp
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                @foreach ($labCards as $card)
                    <div class="bg-gray-50 rounded-xl overflow-hidden shadow border border-gray-100">
                        <div class="bg-[#354776] px-4 py-2.5 flex items-center gap-2">
                            <i class="{{ $card['icon'] }} text-amber-400 text-sm"></i>
                            <h3 class="text-white font-semibold text-sm">{{ $card['name'] }}</h3>
                        </div>
                        <div class="p-4 grid grid-cols-3 gap-2">
                            @foreach ([['Baru', $lab['baru']], ['Proses', $lab['proses']], ['Selesai', $lab['selesai']]] as [$lbl, $val])
                                <div class="bg-[#354776] rounded-lg py-2.5 flex flex-col items-center">
                                    <span class="text-white text-lg font-extrabold leading-none">{{ $val }}</span>
                                    <span class="text-white/60 text-[9px] mt-0.5 uppercase">{{ $lbl }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
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
                                    >
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400 text-sm italic">Belum ada situs terkait.</p>
                @endif
            </div>

        </div>
    </section>
@endsection

