@php
    $ftr_urls = \App\Models\UrlLayanan::all();
    $ftr_footer = \App\Models\FooterSetting::first();
    $ftr_ig = $ftr_urls->firstWhere('name', 'Instagram');
    $ftr_fb = $ftr_urls->firstWhere('name', 'Facebook');
    $ftr_yt = $ftr_urls->firstWhere('name', 'Youtube')
        ?? $ftr_urls->filter(fn($u) => str_contains($u->url ?? '', 'youtube.com/channel'))->first();
@endphp

<footer class="bg-[#354776] text-white">
    <div class="max-w-6xl mx-auto px-4 md:px-6 py-12 grid grid-cols-1 md:grid-cols-3 gap-8">

        <div>
            <div class="flex items-center gap-2 mb-3">
                <img src="{{ imageExists(config('app.logo')) }}" alt="Logo" class="h-10 w-auto opacity-80">
                <div>
                    <h4 class="font-bold text-base leading-tight text-white">{{ config('app.name') }}</h4>
                    <p class="text-white/60 text-[11px] leading-tight">{{ $ftr_footer->nama_kementerian ?? 'Kementerian PUPR' }}</p>
                </div>
            </div>
            <div class="mt-4">
                <h5 class="font-semibold text-xs text-amber-400 uppercase tracking-wider mb-2">Statistik Pengunjung</h5>
                <table class="text-sm w-full text-white">
                    @foreach ([['Hari ini', '—'], ['7 hari terakhir', '—'], ['30 hari terakhir', '—'], ['Sepanjang waktu', '—']] as [$lbl, $val])
                        <tr class="border-b border-white/10">
                            <td class="py-1 text-white/60 text-xs">{{ $lbl }}</td>
                            <td class="py-1 text-right font-semibold text-xs">{{ $val }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <div>
                <h4 class="font-bold text-base mb-4 text-white">Hubungi Kami</h4>
            <ul class="space-y-2.5 text-sm">
                <li class="flex items-start gap-2.5">
                    <i class="fas fa-map-marker-alt text-amber-400 mt-0.5 shrink-0 text-sm"></i>
                    <span class="text-white/75 text-xs leading-relaxed">{{ $ftr_footer->alamat ?? 'Jl. Kol. H. Burlian Km. 7, Palembang, Sumatera Selatan' }}</span>
                </li>
                @if ($ftr_footer && $ftr_footer->no_hp)
                    <li class="flex items-center gap-2.5">
                        <i class="fas fa-phone text-amber-400 text-sm shrink-0"></i>
                        <span class="text-white/75 text-xs">{{ $ftr_footer->no_hp }}</span>
                    </li>
                @endif
                @if ($ftr_footer && $ftr_footer->email)
                    <li class="flex items-center gap-2.5">
                        <i class="fas fa-envelope text-amber-400 text-sm shrink-0"></i>
                        <span class="text-white/75 text-xs">{{ $ftr_footer->email }}</span>
                    </li>
                @endif
            </ul>
            <div class="flex gap-2.5 mt-4">
                @if ($ftr_ig)
                    <a href="{{ $ftr_ig->url }}" target="_blank" class="w-8 h-8 bg-white/10 hover:bg-pink-500 rounded-full flex items-center justify-center transition-colors cursor-pointer"><i class="fab fa-instagram text-sm"></i></a>
                @endif
                @if ($ftr_fb)
                    <a href="{{ $ftr_fb->url }}" target="_blank" class="w-8 h-8 bg-white/10 hover:bg-blue-500 rounded-full flex items-center justify-center transition-colors cursor-pointer"><i class="fab fa-facebook text-sm"></i></a>
                @endif
                @if ($ftr_yt)
                    <a href="{{ $ftr_yt->url }}" target="_blank" class="w-8 h-8 bg-white/10 hover:bg-red-600 rounded-full flex items-center justify-center transition-colors cursor-pointer"><i class="fab fa-youtube text-sm"></i></a>
                @endif
            </div>
        </div>

        <div>
                <h4 class="font-bold text-base mb-4 text-white">Lokasi</h4>
            <div class="rounded-xl overflow-hidden border border-white/20 h-44">
                <iframe src="https://maps.google.com/maps?q=balai+teknik+rawa+palembang&t=&z=14&ie=UTF8&iwloc=&output=embed"
                    class="w-full h-full" frameborder="0" loading="lazy" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="max-w-6xl mx-auto px-4 md:px-6 py-3 text-center text-xs text-white/50">
            Copyright &copy; <span id="copy-year"></span> {{ config('app.name') }}, Balai Teknik Rawa. All Rights Reserved.
        </div>
    </div>
</footer>
