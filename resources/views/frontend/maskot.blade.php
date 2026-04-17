@extends('frontend.layouts.mainTailwind')

@section('container')
    <section class="bg-slate-50 px-4 py-12 md:py-16">
        <div class="mx-auto max-w-6xl">
            @if ($landing_page->isNotEmpty())
                @foreach ($landing_page as $item)
                    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                        <div class="grid gap-0 {{ $item->path ? 'lg:grid-cols-[1.05fr_0.95fr]' : '' }}">
                            <article class="px-6 py-8 md:px-10 md:py-10">
                                <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-[#354776]">
                                    Profil Balai
                                </span>
                                <h1 class="mt-5 text-3xl font-bold tracking-tight text-[#354776] md:text-5xl">{{ $item->title }}</h1>
                                <div class="mt-4 h-1.5 w-24 rounded-full bg-amber-400"></div>

                                <div class="mt-8 max-w-3xl space-y-5 text-sm leading-8 text-slate-600 md:text-base [&_p]:mb-4 [&_p]:text-justify [&_ul]:list-disc [&_ul]:pl-6 [&_ol]:list-decimal [&_ol]:pl-6">
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
            @else
                <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                    <div class="px-6 py-10 text-center md:px-10">
                        <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-[#354776]">
                            Profil Balai
                        </span>
                        <h1 class="mt-5 text-3xl font-bold tracking-tight text-[#354776] md:text-5xl">Maskot Balai Teknik Rawa</h1>
                        <div class="mx-auto mt-4 h-1.5 w-24 rounded-full bg-amber-400"></div>
                        <div class="mx-auto mt-8 max-w-2xl rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-5 py-5 text-sm leading-7 text-slate-500">
                            Konten maskot belum dipublikasikan dari admin identitas.
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
