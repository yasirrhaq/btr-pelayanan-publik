@extends('frontend.layouts.mainTailwind')

@section('container')
    <section class="bg-slate-50 px-4 py-12 md:py-16">
        <div class="mx-auto max-w-6xl space-y-6">
            <div class="flex flex-wrap items-center gap-3 text-sm">
                <a href="{{ route('ppid.index') }}" class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 font-semibold text-[#354776] shadow-sm ring-1 ring-slate-200 transition hover:bg-slate-100">
                    <i class="fas fa-arrow-left text-xs"></i>
                    Semua PPID
                </a>
                @foreach ($sections as $item)
                    <a href="{{ $item['href'] }}"
                        class="inline-flex items-center rounded-full px-4 py-2 font-semibold ring-1 transition {{ $item['key'] === $section['key'] ? 'bg-[#354776] text-white ring-[#354776]' : 'bg-white text-slate-600 ring-slate-200 hover:bg-slate-100' }}">
                        {{ $item['title'] }}
                    </a>
                @endforeach
            </div>

            <div class="overflow-hidden rounded-[32px] border border-slate-200 bg-white shadow-sm">
                <div class="bg-gradient-to-r {{ $section['accent'] }} px-6 py-10 text-white md:px-10 md:py-12">
                    <div class="max-w-3xl">
                        <span class="inline-flex items-center rounded-full bg-white/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.26em] text-amber-200">
                            {{ $section['eyebrow'] }}
                        </span>
                        <h1 class="mt-4 text-3xl font-bold tracking-tight md:text-5xl">{{ $section['title'] }}</h1>
                        <p class="mt-4 text-sm leading-7 text-slate-100 md:text-base">{{ $section['summary'] }}</p>
                    </div>
                </div>

                <div class="grid gap-0 {{ $section['path'] ? 'lg:grid-cols-[1.05fr_0.95fr]' : '' }}">
                    <article class="px-6 py-8 md:px-10 md:py-10">
                        @if ($section['hasContent'])
                            <div class="max-w-3xl space-y-5 text-sm leading-8 text-slate-600 md:text-base [&_p]:mb-4 [&_p]:text-justify [&_ul]:list-disc [&_ul]:pl-6 [&_ol]:list-decimal [&_ol]:pl-6">
                                {!! str_replace(['<div>', '</div>'], ' ', $section['deskripsi'] ?: '<p>Belum ada konten yang dipublikasikan.</p>') !!}
                            </div>

                            @if ($section['path'])
                                <div class="mt-8">
                                    <a href="{{ imageExists($section['path']) }}" target="_blank" rel="noopener noreferrer"
                                        class="inline-flex items-center gap-2 rounded-full bg-[#354776] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#2a3a61]">
                                        <i class="fas fa-file-arrow-down text-sm"></i>
                                        Lihat Lampiran
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-5 py-5 text-sm leading-7 text-slate-500">
                                Konten untuk bagian ini belum dipublikasikan dari admin PPID.
                            </div>
                        @endif
                    </article>

                    @if ($section['path'])
                        <aside class="bg-slate-100 p-4 md:p-6">
                            <div class="flex h-full min-h-[320px] items-center justify-center overflow-hidden rounded-2xl bg-white ring-1 ring-slate-200">
                                @php
                                    $filePath = strtolower((string) $section['path']);
                                    $isImage = \Illuminate\Support\Str::endsWith($filePath, ['.jpg', '.jpeg', '.png', '.webp', '.gif']);
                                @endphp

                                @if ($isImage)
                                    <img src="{{ imageExists($section['path']) }}" alt="{{ $section['title'] }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex flex-col items-center justify-center px-6 text-center">
                                        <div class="flex h-20 w-20 items-center justify-center rounded-full bg-[#354776]/10 text-[#354776]">
                                            <i class="fas {{ $section['icon'] }} text-3xl"></i>
                                        </div>
                                        <h3 class="mt-5 text-lg font-semibold text-[#354776]">Lampiran Tersedia</h3>
                                        <p class="mt-2 text-sm leading-7 text-slate-500">Dokumen pendukung dapat dibuka melalui tombol lampiran di area konten.</p>
                                    </div>
                                @endif
                            </div>
                        </aside>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
