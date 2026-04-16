@extends('frontend.layouts.mainTailwind')

@section('container')
    <section class="bg-slate-50 px-4 py-12 md:py-16">
        <div class="mx-auto max-w-6xl">
            <div class="text-center">
                <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-[#354776]">
                    Sarana Balai
                </span>
                <h1 class="mt-5 text-3xl font-bold tracking-tight text-[#354776] md:text-5xl">Fasilitas Kami</h1>
                <div class="mx-auto mt-4 h-1.5 w-24 rounded-full bg-amber-400"></div>
                <p class="mx-auto mt-6 max-w-3xl text-sm leading-7 text-slate-600 md:text-base">
                    Fasilitas pendukung layanan teknis Balai Teknik Rawa untuk kegiatan pengujian, koordinasi, dokumentasi, dan pengembangan pengetahuan.
                </p>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($fasilitasBalai as $item)
                    <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition-shadow hover:shadow-md">
                        <div class="aspect-[4/3] overflow-hidden bg-slate-100">
                            <img src="{{ imageExists($item->path_image ?: 'assets/fotoDumy.jpeg') }}" alt="{{ $item->title }}" class="h-full w-full object-cover">
                        </div>
                        <div class="px-5 py-5">
                            <h2 class="text-lg font-semibold text-[#354776]">{{ $item->title }}</h2>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-8 flex justify-center">
                {{ $fasilitasBalai->links() }}
            </div>
        </div>
    </section>
@endsection
