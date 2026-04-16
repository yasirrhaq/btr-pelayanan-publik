@foreach ($landing_page as $item)
    @php
        $pageImage = imageExists($item->path ?: 'assets/balaiRawa.png');
    @endphp

    <section class="px-4 py-12 md:py-16">
        <div class="mx-auto max-w-5xl">
            <div class="text-center">
                <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-[#354776]">
                    Profil Balai
                </span>
                <h1 class="mt-5 text-3xl font-bold tracking-tight text-[#354776] md:text-5xl">{{ $item->title }}</h1>
                <div class="mx-auto mt-4 h-1.5 w-24 rounded-full bg-amber-400"></div>
            </div>

            <div class="mt-10 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="grid gap-0 lg:grid-cols-[1.15fr_0.85fr]">
                    <article class="px-6 py-8 md:px-10 md:py-10">
                        <div class="space-y-5 text-sm leading-8 text-slate-600 md:text-base [&_p]:text-justify">
                            {!! str_replace(['<div>', '</div>'], ' ', $item->deskripsi) !!}
                        </div>
                    </article>

                    <aside class="border-t border-slate-200 bg-slate-50 p-6 lg:border-l lg:border-t-0">
                        <figure class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
                            <img src="{{ $pageImage }}" alt="{{ $item->title }}" class="h-full min-h-[260px] w-full object-cover">
                        </figure>
                    </aside>
                </div>
            </div>
        </div>
    </section>
@endforeach
