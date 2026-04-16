@extends('frontend.layouts.mainTailwind')

@section('container')
    @php
        $ctaUrl = auth()->check() ? $url->url : url('/login');
    @endphp

    <section class="bg-slate-50 px-4 py-12 md:py-16">
        <div class="mx-auto max-w-6xl">
            <div class="text-center">
                <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-[#354776]">
                    Layanan Teknis
                </span>
                <h1 class="mt-5 text-3xl font-bold tracking-tight text-[#354776] md:text-5xl">{{ $url->name }}</h1>
                <div class="mx-auto mt-4 h-1.5 w-24 rounded-full bg-amber-400"></div>
            </div>

            <div class="mt-10 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="grid gap-0 lg:grid-cols-[0.9fr_1.1fr]">
                    <div class="bg-slate-100 p-4 md:p-6">
                        <div class="overflow-hidden rounded-2xl ring-1 ring-slate-200">
                            <img src="{{ imageExists($url->path_image ?: 'assets/advis-gambar.png') }}" alt="{{ $url->name }}" class="h-full min-h-[280px] w-full object-cover">
                        </div>
                    </div>
                    <div class="px-6 py-8 md:px-8 md:py-10">
                        <h2 class="text-2xl font-semibold text-[#354776]">Tentang {{ $url->name }}</h2>
                        <div class="mt-5 text-sm leading-7 text-slate-600 md:text-base">
                            {!! str_replace(['<div>', '</div>'], ' ', $url->deskripsi) !!}
                        </div>
                        <div class="mt-8">
                            <a href="{{ $ctaUrl }}" class="inline-flex items-center rounded-xl bg-[#354776] px-5 py-3 text-sm font-semibold text-white transition-colors hover:bg-[#2a3a61]">
                                @auth Daftar Layanan @else Login untuk Mendaftar @endauth
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
