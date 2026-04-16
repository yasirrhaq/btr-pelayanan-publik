@extends('frontend.layouts.mainTailwind')

@section('container')
    <section class="bg-slate-50 px-4 pt-10 pb-6 md:pt-14 md:pb-8">
        <div class="mx-auto max-w-6xl">
            <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-[#354776]">
                Berita Balai
            </span>
            <h1 class="mt-5 max-w-3xl text-3xl font-bold tracking-tight text-[#354776] md:text-5xl">
                Kabar terbaru layanan, kegiatan, dan pengembangan Balai Teknik Rawa
            </h1>
            <div class="mt-4 h-1.5 w-24 rounded-full bg-amber-400"></div>
            <p class="mt-5 max-w-2xl text-sm leading-7 text-slate-600 md:text-base">
                Informasi terbaru mengenai kegiatan lapangan, layanan teknis, laboratorium, dan penguatan data bidang rawa.
            </p>
        </div>
    </section>

    <section class="bg-slate-50 px-4 pb-12 md:pb-16">
        <div class="mx-auto grid max-w-6xl gap-8 lg:grid-cols-[minmax(0,1fr)_320px]">
            <div>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    @forelse ($posts as $post)
                        <a href="{{ url('berita', ['slug' => $post->slug]) }}" class="group block overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition-shadow hover:shadow-md">
                            <div class="aspect-[16/8] overflow-hidden bg-slate-100">
                                <img src="{{ imageExists($post->image ?: 'assets/beritaterkini1.png') }}" alt="{{ $post->title }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-[1.03]">
                            </div>
                            <div class="flex min-h-[250px] flex-col px-5 py-5">
                                <div class="flex flex-wrap items-center gap-2 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-500">
                                    <span>{{ optional($post->created_at)->format('d M Y') }}</span>
                                    <span class="rounded-full bg-[#FEF3C7] px-2.5 py-1 text-[#354776]">{{ $post->category->name ?? 'Berita' }}</span>
                                </div>
                                <h3 class="mt-3 line-clamp-3 min-h-[5.5rem] text-lg font-semibold leading-8 text-[#354776] transition-colors group-hover:text-[#2a3a61]">
                                    {{ $post->title }}
                                </h3>
                                <p class="mt-3 line-clamp-3 min-h-[5.5rem] text-sm leading-7 text-slate-600">
                                    {{ $post->excerpt ?: $post->attr_body_limit }}
                                </p>
                                <div class="mt-auto pt-5">
                                    <span class="inline-flex items-center rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-[#354776] transition-colors group-hover:bg-[#354776] group-hover:text-white">
                                        Baca selengkapnya
                                    </span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center text-slate-500 md:col-span-2">
                            Belum ada berita.
                        </div>
                    @endforelse
                </div>

                <div class="mt-10 flex justify-center">
                    {{ $posts->onEachSide(1)->links() }}
                </div>
            </div>

            <aside class="space-y-6">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-semibold text-[#354776]">Cari Berita</h2>

                    <form method="GET" action="{{ url('/berita') }}" class="mt-5 space-y-4">
                        <div>
                            <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Kategori</label>
                            <select class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-[#354776]" name="categori_id">
                                <option value="">Semua</option>
                                @foreach ($categori as $item)
                                    <option value="{{ $item->id }}" {{ (string) request('categori_id') === (string) $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Pencarian</label>
                            <div class="flex overflow-hidden rounded-xl border border-slate-200 bg-white focus-within:border-[#354776]">
                                <input type="text" class="w-full px-4 py-3 text-sm text-slate-700 outline-none" placeholder="Cari berita..." name="search" value="{{ request('search') }}">
                                <button type="submit" class="inline-flex items-center justify-center bg-[#354776] px-4 text-white transition-colors hover:bg-[#2a3a61]">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-semibold text-[#354776]">Berita Terkini</h2>
                    <div class="mt-5 space-y-4">
                        @foreach ($terkini as $latest)
                            <a href="{{ url('berita', ['slug' => $latest->slug]) }}" class="group flex items-start gap-3 rounded-2xl p-2 transition-colors hover:bg-slate-50">
                                <img src="{{ imageExists($latest->image ?: 'assets/beritaterkini1.png') }}" alt="{{ $latest->title }}" class="h-16 w-16 rounded-xl object-cover">
                                <div>
                                    <h3 class="line-clamp-2 text-sm font-semibold text-slate-700 transition-colors group-hover:text-[#354776]">{{ $latest->title }}</h3>
                                    <p class="mt-1 text-xs text-slate-500">{{ $latest->created_at->diffForHumans() }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
