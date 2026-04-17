@extends('frontend.layouts.mainTailwind')

@section('container')
    <section class="bg-slate-50 px-4 py-12 md:py-16">
        <div class="mx-auto max-w-4xl space-y-8">
            @foreach ($landing_page as $item)
                <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                    <div class="grid gap-0 {{ $item->path ? 'lg:grid-cols-[1.05fr_0.95fr]' : '' }}">
                        <article class="px-6 py-8 md:px-10 md:py-10">
                            <div class="text-center">
                                <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-[#354776]">
                                    Profil Balai
                                </span>
                                <h1 class="mt-5 text-3xl font-bold tracking-tight text-[#354776] md:text-5xl">{{ $item->title }}</h1>
                                <div class="mx-auto mt-4 h-1.5 w-24 rounded-full bg-amber-400"></div>
                            </div>

                            <div class="mx-auto mt-8 max-w-3xl space-y-5 text-sm leading-8 text-slate-600 md:text-base [&_p]:text-justify">
                                {!! str_replace(['<div>', '</div>'], ' ', $item->deskripsi) !!}
                            </div>
                        </article>

                        @if ($item->path)
                            <aside class="bg-slate-100 p-4 md:p-6">
                                <div class="h-full overflow-hidden rounded-2xl bg-white ring-1 ring-slate-200">
                                    <img src="{{ imageExists($item->path) }}" alt="{{ $item->title }}" class="h-full min-h-[320px] w-full object-cover">
                                </div>
                            </aside>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
