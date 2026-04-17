@extends('frontend.layouts.mainTailwind')

@section('container')
    <section class="bg-slate-50 px-4 py-12 md:py-16">
        <div class="mx-auto max-w-6xl">
            <div class="overflow-hidden rounded-[32px] border border-slate-200 bg-white shadow-sm">
                <div class="bg-[radial-gradient(circle_at_top_left,_rgba(255,255,255,0.22),_transparent_42%),linear-gradient(135deg,#354776_0%,#4f6ba7_100%)] px-6 py-10 text-white md:px-10 md:py-12">
                    <div class="max-w-3xl">
                        <span class="inline-flex items-center rounded-full bg-white/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.26em] text-amber-200">
                            Publikasi
                        </span>
                        <h1 class="mt-4 text-3xl font-bold tracking-tight md:text-5xl">PPID Balai Teknik Rawa</h1>
                        <p class="mt-4 text-sm leading-7 text-slate-100 md:text-base">
                            Empat kanal informasi publik dipisah agar pengguna langsung masuk ke jenis informasi yang dibutuhkan tanpa
                            membaca satu halaman panjang.
                        </p>
                    </div>
                </div>

                <div class="grid gap-5 px-5 py-6 md:grid-cols-2 md:px-8 md:py-8">
                    @foreach ($sections as $section)
                        <a href="{{ $section['href'] }}"
                            class="group overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:border-slate-300 hover:shadow-xl">
                            <div class="bg-gradient-to-r {{ $section['accent'] }} px-6 py-5 text-white">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <div class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-200">{{ $section['eyebrow'] }}</div>
                                        <h2 class="mt-2 text-2xl font-bold tracking-tight">{{ $section['title'] }}</h2>
                                    </div>
                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/15 text-xl">
                                        <i class="fas {{ $section['icon'] }}"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="px-6 py-5">
                                <p class="text-sm leading-7 text-slate-600">{{ $section['summary'] }}</p>

                                <div class="mt-5 flex items-center justify-between gap-3">
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-[#354776]">
                                        {{ $section['badge'] }}
                                    </span>
                                    <span class="inline-flex items-center gap-2 text-sm font-semibold text-[#354776] transition group-hover:translate-x-1">
                                        Buka Halaman
                                        <i class="fas fa-arrow-right text-xs"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
