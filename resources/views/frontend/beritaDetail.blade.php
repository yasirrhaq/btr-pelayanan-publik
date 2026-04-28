@extends('frontend.layouts.mainTailwind')

@section('container')
    <section class="bg-slate-50 px-4 py-10 md:py-14">
        <div class="mx-auto max-w-6xl">
            <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_320px]">
                <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                    <div class="aspect-[16/8] overflow-hidden bg-slate-100">
                        <img src="{{ imageExists($post->image ?: 'assets/beritautama.png') }}" alt="{{ $post->title }}" class="h-full w-full object-cover">
                    </div>
                    <div class="px-6 py-8 md:px-10 md:py-10">
                        <div class="flex flex-wrap items-center gap-3 text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">
                            <span>{{ optional($post->created_at)->format('d M Y') }}</span>
                            <span>&bull;</span>
                            <span class="inline-flex items-center rounded-full bg-[#FEF3C7] px-3 py-1 text-[11px] font-bold tracking-[0.18em] text-[#354776]">
                                {{ $post->category->name ?? 'Berita' }}
                            </span>
                        </div>
                        <h1 class="mt-4 text-3xl font-bold tracking-tight text-[#354776] md:text-5xl">{{ $post->title }}</h1>
                        <div class="mt-8 space-y-5 text-sm leading-8 text-slate-600 md:text-base [&_p]:text-justify [&_img]:rounded-2xl [&_img]:max-w-full">
                            {!! $post->body !!}
                        </div>
                        <div class="mt-8 flex flex-wrap items-center gap-3">
                            <a href="{{ url('/berita') }}" class="inline-flex items-center rounded-xl bg-slate-100 px-4 py-2.5 text-sm font-semibold text-[#354776] transition-colors hover:bg-slate-200">
                                Kembali ke Berita
                            </a>
                            @if ($post->lampiran_path)
                                <a href="{{ asset('storage/' . $post->lampiran_path) }}" target="_blank" rel="noopener" class="inline-flex items-center rounded-xl bg-[#ffc425] px-4 py-2.5 text-sm font-semibold text-[#2a3a61] transition-colors hover:bg-[#ffcf47]">
                                    Lihat Lampiran
                                </a>
                            @endif
                        </div>
                    </div>
                </article>

                <aside class="space-y-4">
                    <div class="rounded-3xl border border-slate-200 bg-white px-5 py-5 shadow-sm">
                        <h2 class="text-lg font-semibold text-[#354776]">Berita Terkini</h2>
                        <div class="mt-4 space-y-4">
                            @foreach ($terkini->take(4) as $latest)
                                <a href="{{ url('berita', ['slug' => $latest->slug]) }}" class="flex items-start gap-3 rounded-2xl p-2 transition-colors hover:bg-slate-50">
                                    <img src="{{ imageExists($latest->image ?: 'assets/beritaterkini2.png') }}" alt="{{ $latest->title }}" class="h-16 w-16 rounded-xl object-cover">
                                    <div>
                                        <h3 class="line-clamp-2 text-sm font-semibold text-slate-700">{{ $latest->title }}</h3>
                                        <p class="mt-1 text-xs text-slate-500">{{ optional($latest->created_at)->diffForHumans() }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
