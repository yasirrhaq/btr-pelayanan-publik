@extends('frontend.layouts.mainTailwind')

@section('container')
    @php
        $featuredPost = $posts->first();
        $secondaryPosts = $posts->slice(1);
    @endphp

    <section class="bg-slate-50 px-4 pt-10 pb-6 md:pt-14 md:pb-8">
        <div class="mx-auto max-w-6xl">
            <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-[#354776]">
                Berita Balai
            </span>
            <h1 class="mt-5 max-w-3xl text-3xl font-bold tracking-tight text-[#354776] md:text-5xl">Kabar terbaru layanan, kegiatan, dan pengembangan Balai Teknik Rawa</h1>
            <div class="mt-4 h-1.5 w-24 rounded-full bg-amber-400"></div>
            <p class="mt-5 max-w-2xl text-sm leading-7 text-slate-600 md:text-base">
                Informasi terbaru mengenai kegiatan lapangan, layanan teknis, laboratorium, dan penguatan data bidang rawa.
            </p>
        </div>
    </section>

    <section class="bg-slate-50 px-4 pb-10 md:pb-14">
        <div class="mx-auto max-w-6xl">
            @if ($featuredPost)
                <a href="{{ url('berita', ['slug' => $featuredPost->slug]) }}" class="group block overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition-shadow hover:shadow-md lg:grid lg:grid-cols-[1.15fr_0.85fr]">
                    <div class="order-2 px-6 py-8 md:px-8 md:py-10 lg:order-1">
                        <div class="flex flex-wrap items-center gap-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                            <span class="rounded-full bg-amber-100 px-3 py-1 text-[#354776]">Sorotan</span>
                            <span>{{ optional($featuredPost->created_at)->format('d M Y') }}</span>
                            <span>{{ $featuredPost->category->name ?? 'Berita' }}</span>
                        </div>
                        <h2 class="mt-4 text-2xl font-bold tracking-tight text-[#354776] transition-colors group-hover:text-[#2a3a61] md:text-4xl">{{ $featuredPost->title }}</h2>
                        <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-600 md:text-base">{{ $featuredPost->excerpt }}</p>
                        <div class="mt-6 inline-flex items-center text-sm font-semibold text-[#354776] group-hover:text-[#2a3a61]">
                            Baca Berita
                        </div>
                    </div>
                    <div class="order-1 bg-slate-100 lg:order-2">
                        <img src="{{ imageExists($featuredPost->image ?: 'assets/beritautama.png') }}" alt="{{ $featuredPost->title }}" class="h-full min-h-[260px] w-full object-cover transition-transform duration-300 group-hover:scale-[1.02]">
                    </div>
                </a>
            @endif

            @if ($secondaryPosts->count())
                <div class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($secondaryPosts as $post)
                        <a href="{{ url('berita', ['slug' => $post->slug]) }}" class="group block overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition-shadow hover:shadow-md">
                            <div class="aspect-[16/10] overflow-hidden bg-slate-100">
                                <img src="{{ imageExists($post->image ?: 'assets/beritaterkini1.png') }}" alt="{{ $post->title }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-[1.03]">
                            </div>
                            <div class="px-5 py-5">
                                <div class="flex flex-wrap items-center gap-2 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-500">
                                    <span>{{ optional($post->created_at)->format('d M Y') }}</span>
                                    <span>&bull;</span>
                                    <span>{{ $post->category->name ?? 'Berita' }}</span>
                                </div>
                                <h3 class="mt-3 line-clamp-2 text-lg font-semibold text-[#354776] transition-colors group-hover:text-[#2a3a61]">{{ $post->title }}</h3>
                                <p class="mt-3 line-clamp-3 text-sm leading-7 text-slate-600">{{ $post->excerpt }}</p>
                                <div class="mt-5 inline-flex items-center text-sm font-semibold text-[#354776] group-hover:text-[#2a3a61]">
                                    Baca selengkapnya
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

            @if (!$posts->count())
                <div class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center text-slate-500">
                    Belum ada berita.
                </div>
            @endif

            <div class="mt-10 flex justify-center">
                {{ $posts->links() }}
            </div>
        </div>
    </section>
@endsection
