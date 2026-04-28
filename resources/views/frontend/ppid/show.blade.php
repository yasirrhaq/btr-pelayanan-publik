@extends('frontend.layouts.mainTailwind')

@section('container')
    @php
        $contentHtml = trim((string) ($currentSection['deskripsi'] ?? ''));
        $hasAttachment = filled($currentSection['path']);
        $attachmentUrl = $hasAttachment ? imageExists($currentSection['path']) : null;
    @endphp

    <section class="bg-[#354776] px-4 py-12 text-white">
        <div class="mx-auto max-w-6xl">
            <a href="{{ route('ppid.index') }}" class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-sm font-semibold text-white hover:bg-white/15">
                <i class="fas fa-arrow-left text-xs"></i>
                Semua PPID
            </a>

            <div class="mt-6 max-w-3xl">
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-amber-300">{{ $currentSection['eyebrow'] }}</p>
                <h1 class="mt-3 text-3xl font-bold md:text-4xl">{{ $currentSection['title'] }}</h1>
                <p class="mt-4 text-sm leading-7 text-white/80 md:text-base">{{ $currentSection['summary'] }}</p>
            </div>
        </div>
    </section>

    <section class="bg-slate-50 px-4 py-10">
        <div class="mx-auto max-w-6xl space-y-6">
            <div class="flex flex-wrap gap-3">
                @foreach ($sections as $item)
                    <a href="{{ $item['href'] }}"
                        class="rounded-full px-4 py-2 text-sm font-semibold {{ $item['key'] === $currentSection['key'] ? 'bg-[#354776] text-white' : 'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-100' }}">
                        {{ $item['title'] }}
                    </a>
                @endforeach
            </div>

            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 px-6 py-5 md:px-8">
                    <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-[#354776]">
                        {{ $currentSection['badge'] }}
                    </span>
                </div>

                <div class="px-6 py-8 md:px-8">
                    @if ($contentHtml !== '')
                        <div class="space-y-4 text-sm leading-7 text-slate-600 md:text-base [&_p]:mb-4 [&_ul]:list-disc [&_ul]:pl-6 [&_ol]:list-decimal [&_ol]:pl-6">
                            {!! $contentHtml !!}
                        </div>
                    @else
                        <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-5 py-5 text-sm leading-7 text-slate-500">
                            Konten untuk bagian ini belum dipublikasikan dari admin PPID.
                        </div>
                    @endif

                    @if ($hasAttachment)
                        <div class="mt-8">
                            <a href="{{ $attachmentUrl }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 rounded-full bg-[#354776] px-5 py-3 text-sm font-semibold text-white hover:bg-[#2a3a61]">
                                <i class="fas fa-file-arrow-down text-sm"></i>
                                Lihat Lampiran
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
