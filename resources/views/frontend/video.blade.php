@extends('frontend.layouts.mainTailwind')

@php
    $currentPage = $galeriVideo->currentPage();
    $lastPage = $galeriVideo->lastPage();
    $windowStart = max(1, $currentPage - 1);
    $windowEnd = min($lastPage, $currentPage + 1);

    if ($windowEnd - $windowStart < 2) {
        if ($windowStart === 1) {
            $windowEnd = min($lastPage, 3);
        } else {
            $windowStart = max(1, $lastPage - 2);
        }
    }
@endphp

@section('container')
    <section class="bg-[#F7F7F7] px-4 py-12 md:py-16">
        <div class="mx-auto max-w-7xl">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-[#354776] md:text-6xl">Video</h1>
                <div class="mx-auto mt-5 h-2 w-20 rounded-full bg-[#FDC300]"></div>
            </div>

            <form method="get" action="{{ route('video.index') }}" class="mt-10 rounded-[28px] bg-white px-6 py-5 shadow-[0_18px_45px_rgba(15,23,42,0.06)]">
                <div class="grid gap-5 md:grid-cols-[280px_minmax(0,1fr)]">
                    <div>
                        <label for="category" class="block text-sm font-semibold text-slate-900">Filter Kategori :</label>
                        <select id="category" name="category" class="mt-2 h-14 w-full rounded-2xl border border-slate-300 px-4 text-sm text-slate-700 focus:border-[#354776] focus:outline-none">
                            <option value="">-Semua Kategori-</option>
                            @foreach ($videoCategories as $videoCategory)
                                <option value="{{ $videoCategory }}" @selected($category === $videoCategory)>{{ $videoCategory }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="search" class="block text-sm font-semibold text-slate-900">Masukkan Kata Kunci :</label>
                        <div class="mt-2 flex items-center gap-3">
                            <input id="search" name="search" type="text" value="{{ $search }}" placeholder="Cari judul video..." class="h-14 flex-1 rounded-2xl border border-slate-300 px-4 text-sm text-slate-700 focus:border-[#354776] focus:outline-none">
                            <button type="submit" class="flex h-14 w-14 items-center justify-center rounded-full bg-white text-slate-900 shadow-sm transition hover:bg-slate-100">
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"></circle><path stroke-linecap="round" stroke-linejoin="round" d="M20 20l-3.5-3.5"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                @forelse ($galeriVideo as $item)
                    <article class="overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-[0_20px_45px_rgba(15,23,42,0.06)]">
                        <div class="aspect-video bg-slate-950">
                            @if ($item->isYoutubeVideo())
                                <iframe
                                    src="{{ $item->youtubeEmbedUrl() }}"
                                    title="{{ $item->title }}"
                                    class="h-full w-full"
                                    loading="lazy"
                                    allowfullscreen
                                ></iframe>
                            @elseif ($item->isUploadedVideo())
                                <video controls preload="metadata" class="h-full w-full object-cover">
                                    <source src="{{ $item->publicFileUrl() }}">
                                </video>
                            @else
                                <div class="flex h-full items-center justify-center bg-[#111827] text-sm font-semibold uppercase tracking-[0.3em] text-white">Video</div>
                            @endif
                        </div>
                        <div class="px-4 pb-5 pt-4">
                            <div class="mb-3 flex flex-wrap items-center gap-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">
                                <span>{{ $item->category ?: 'Dokumentasi' }}</span>
                                <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                                <span>{{ $item->sourceLabel() }}</span>
                            </div>
                            <h2 class="min-h-[3.75rem] text-base font-semibold leading-6 text-[#354776]">{{ $item->title }}</h2>
                            <div class="mt-4 flex items-center justify-between gap-3 text-xs text-slate-400">
                                <span>{{ optional($item->created_at)->translatedFormat('d F Y') }}</span>
                                <div class="flex items-center gap-2">
                                    <a href="{{ $item->embedRoute() }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-[#FDC300] px-3 py-2 font-semibold text-[#1E2B50] transition hover:bg-[#FFD84D]">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7h4a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2v-4"/><path stroke-linecap="round" stroke-linejoin="round" d="M10 14L21 3"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 3h6v6"/><path stroke-linecap="round" stroke-linejoin="round" d="M5 5h5"/></svg>
                                        Putar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full rounded-[28px] border border-dashed border-slate-300 bg-white px-6 py-16 text-center text-slate-500">
                        Belum ada video yang sesuai filter.
                    </div>
                @endforelse
            </div>

            @if ($totalVideos > 0)
                <div class="mt-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <p class="text-sm text-slate-700">
                        Menampilkan {{ $galeriVideo->count() }} Video dari {{ $totalVideos }} Video
                    </p>

                    @if ($lastPage > 1)
                        <nav class="flex items-center gap-2 rounded-3xl bg-white px-3 py-3 shadow-[0_16px_36px_rgba(15,23,42,0.08)]">
                            @if ($galeriVideo->onFirstPage())
                                <span class="flex h-11 w-11 items-center justify-center rounded-2xl text-slate-300">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/></svg>
                                </span>
                            @else
                                <a href="{{ $galeriVideo->previousPageUrl() }}" class="flex h-11 w-11 items-center justify-center rounded-2xl text-slate-700 transition hover:bg-slate-100">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/></svg>
                                </a>
                            @endif

                            @if ($windowStart > 1)
                                <a href="{{ $galeriVideo->url(1) }}" class="flex h-11 min-w-[44px] items-center justify-center rounded-2xl px-3 text-sm text-slate-700 transition hover:bg-slate-100">1</a>
                                @if ($windowStart > 2)
                                    <span class="px-1 text-slate-400">...</span>
                                @endif
                            @endif

                            @for ($page = $windowStart; $page <= $windowEnd; $page++)
                                @if ($page === $currentPage)
                                    <span class="flex h-11 min-w-[44px] items-center justify-center rounded-2xl bg-[#D7E8FF] px-3 text-sm font-semibold text-[#354776]">{{ $page }}</span>
                                @else
                                    <a href="{{ $galeriVideo->url($page) }}" class="flex h-11 min-w-[44px] items-center justify-center rounded-2xl px-3 text-sm text-slate-700 transition hover:bg-slate-100">{{ $page }}</a>
                                @endif
                            @endfor

                            @if ($windowEnd < $lastPage)
                                @if ($windowEnd < $lastPage - 1)
                                    <span class="px-1 text-slate-400">...</span>
                                @endif
                                <a href="{{ $galeriVideo->url($lastPage) }}" class="flex h-11 min-w-[44px] items-center justify-center rounded-2xl px-3 text-sm text-slate-700 transition hover:bg-slate-100">{{ $lastPage }}</a>
                            @endif

                            @if ($galeriVideo->hasMorePages())
                                <a href="{{ $galeriVideo->nextPageUrl() }}" class="flex h-11 w-11 items-center justify-center rounded-2xl text-slate-700 transition hover:bg-slate-100">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6"/></svg>
                                </a>
                            @else
                                <span class="flex h-11 w-11 items-center justify-center rounded-2xl text-slate-300">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6"/></svg>
                                </span>
                            @endif
                        </nav>
                    @endif
                </div>
            @endif
        </div>
    </section>
@endsection
