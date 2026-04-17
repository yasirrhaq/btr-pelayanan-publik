@extends('frontend.layouts.mainTailwind')

@section('container')
    <section class="bg-slate-50 px-4 py-12 md:py-16">
        <div class="mx-auto max-w-6xl">
            <div class="text-center">
                <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-[#354776]">
                    Galeri Balai
                </span>
                <h1 class="mt-5 text-3xl font-bold tracking-tight text-[#354776] md:text-5xl">Video</h1>
                <div class="mx-auto mt-4 h-1.5 w-24 rounded-full bg-amber-400"></div>
                <p class="mx-auto mt-6 max-w-3xl text-sm leading-7 text-slate-600 md:text-base">
                    Kumpulan video kegiatan, layanan, dan dokumentasi Balai Teknik Rawa.
                </p>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($galeri_foto as $item)
                    <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                        <div class="aspect-video bg-slate-950">
                            <video controls preload="metadata" class="h-full w-full object-cover">
                                <source src="{{ asset($item->path_image) }}">
                            </video>
                        </div>
                        <div class="px-5 py-5">
                            <h2 class="text-lg font-semibold text-[#354776]">{{ $item->title }}</h2>
                            <p class="mt-2 text-xs uppercase tracking-[0.16em] text-slate-400">{{ optional($item->created_at)->format('d M Y') }}</p>
                        </div>
                    </article>
                @empty
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center text-slate-500 md:col-span-2 xl:col-span-3">
                        Belum ada video.
                    </div>
                @endforelse
            </div>

            <div class="mt-8 flex justify-center">
                {{ $galeri_foto->links() }}
            </div>
        </div>
    </section>
@endsection
