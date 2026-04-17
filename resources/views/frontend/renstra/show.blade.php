@extends('frontend.layouts.mainTailwind')

@section('container')
    <section class="bg-[#354776] text-white py-12 px-4">
        <div class="max-w-6xl mx-auto">
            <a href="{{ route('renstra.index') }}" class="inline-flex items-center gap-2 text-sm text-white/80 hover:text-white transition-colors">
                <i class="fas fa-arrow-left text-xs"></i>
                Kembali ke Renstra
            </a>
            <p class="mt-6 text-xs uppercase tracking-[0.3em] text-amber-300 font-semibold">Rencana Strategis</p>
            <h1 class="mt-3 max-w-4xl text-3xl md:text-4xl font-bold">{{ $renstra->title }}</h1>
            <p class="mt-3 text-sm text-white/80">Penerbit: {{ $renstra->penerbit }} • {{ $renstra->tanggal_terbit }}</p>
        </div>
    </section>

    <section class="bg-gray-50 py-10 px-4">
        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-[minmax(0,2fr)_360px] gap-8">
            <article class="rounded-[24px] border border-slate-200 bg-white p-6 md:p-8 shadow-sm">
                @if ($renstra->path_image)
                    <div class="mb-8 overflow-hidden rounded-[22px] border border-slate-200 bg-slate-100">
                        <img src="{{ asset($renstra->path_image) }}" alt="{{ $renstra->title }}" class="w-full object-cover">
                    </div>
                @endif

                <div class="prose prose-sm md:prose-base max-w-none prose-headings:text-[#354776] prose-a:text-[#354776]">
                    {!! $renstra->abstract !!}
                </div>

                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4 rounded-[22px] border border-slate-200 bg-slate-50 p-5">
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">Penerbit</p>
                        <p class="mt-1 text-sm font-semibold text-slate-800">{{ $renstra->penerbit }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">Tanggal Terbit</p>
                        <p class="mt-1 text-sm font-semibold text-slate-800">{{ $renstra->tanggal_terbit }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">Bahasa</p>
                        <p class="mt-1 text-sm font-semibold text-slate-800">{{ $renstra->bahasa }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">Subyek</p>
                        <p class="mt-1 text-sm font-semibold text-slate-800">{{ $renstra->subyek }}</p>
                    </div>
                    @if ($renstra->issn_online)
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">ISSN Online</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">{{ $renstra->issn_online }}</p>
                        </div>
                    @endif
                    @if ($renstra->issn_cetak)
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">ISSN Cetak</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">{{ $renstra->issn_cetak }}</p>
                        </div>
                    @endif
                </div>

                <div class="mt-8">
                    <a href="{{ auth()->check() ? $renstra->link_download : url('/login') }}" class="inline-flex items-center gap-2 rounded-full bg-amber-400 px-5 py-3 text-sm font-semibold text-[#354776] hover:bg-amber-300 transition-colors">
                        <i class="fas fa-download text-xs"></i>
                        Unduh Dokumen
                    </a>
                </div>
            </article>

            <aside class="rounded-[24px] border border-slate-200 bg-white p-6 shadow-sm h-fit">
                <h2 class="text-lg font-bold text-[#354776]">Renstra Lainnya</h2>
                <div class="mt-5 space-y-4">
                    @forelse ($terbaru as $item)
                        <a href="{{ route('renstra.show', $item) }}" class="block rounded-xl border border-slate-100 p-4 hover:border-[#354776]/20 hover:shadow-sm transition-all">
                            <p class="text-[11px] uppercase tracking-wide text-amber-500 font-semibold">{{ $item->tanggal_terbit }}</p>
                            <h3 class="mt-2 text-sm font-semibold text-slate-900 leading-6">{{ $item->title }}</h3>
                            <p class="mt-2 text-xs text-slate-500">{{ $item->penerbit }}</p>
                        </a>
                    @empty
                        <p class="text-sm text-slate-500">Tidak ada dokumen lain.</p>
                    @endforelse
                </div>
            </aside>
        </div>
    </section>
@endsection
