@extends('frontend.layouts.mainTailwind')

@section('container')
    <section class="bg-[#354776] text-white py-12 px-4">
        <div class="max-w-6xl mx-auto">
            <p class="text-xs uppercase tracking-[0.3em] text-amber-300 font-semibold">Publikasi</p>
            <h1 class="mt-3 text-3xl md:text-4xl font-bold">Rencana Strategis</h1>
            <p class="mt-3 max-w-3xl text-sm md:text-base text-white/80">
                Dokumen Renstra Balai Teknik Rawa yang dapat diakses publik sebagai rujukan arah kebijakan dan program kerja.
            </p>
        </div>
    </section>

    <section class="bg-gray-50 py-10 px-4">
        <div class="max-w-6xl mx-auto">
            <form action="{{ route('renstra.index') }}" method="get" class="mb-8">
                <div class="flex flex-col sm:flex-row gap-3">
                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari judul, penerbit, atau subyek Renstra..."
                        class="flex-1 rounded-2xl border border-gray-200 px-5 py-3 text-sm text-slate-700 shadow-sm focus:border-[#354776] focus:outline-none focus:ring-2 focus:ring-[#354776]/10"
                    >
                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-amber-400 px-5 py-3 text-sm font-semibold text-[#354776] hover:bg-amber-300 transition-colors">
                        <i class="fas fa-search text-xs"></i>
                        Cari
                    </button>
                </div>
            </form>

            @if ($renstra->count())
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach ($renstra as $item)
                        <article class="overflow-hidden rounded-[24px] border border-slate-200 bg-white shadow-sm transition-all hover:-translate-y-1 hover:shadow-lg">
                            <div class="aspect-[16/10] bg-slate-100 overflow-hidden">
                                @if ($item->path_image)
                                    <img src="{{ asset($item->path_image) }}" alt="{{ $item->title }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-[#354776] to-slate-700 text-white">
                                        <div class="text-center">
                                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-white/15 text-xl">
                                                <i class="fas fa-file-lines"></i>
                                            </div>
                                            <p class="mt-3 text-xs font-semibold uppercase tracking-[0.25em] text-white/75">Renstra</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="p-6">
                                <div class="flex items-center gap-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-amber-500">
                                    <span>{{ $item->tanggal_terbit }}</span>
                                </div>
                                <h2 class="mt-3 text-lg font-bold leading-snug text-slate-900">
                                    <a href="{{ route('renstra.show', $item) }}" class="hover:text-[#354776] transition-colors">
                                        {{ $item->title }}
                                    </a>
                                </h2>
                                <p class="mt-3 text-sm font-medium text-[#354776]">{{ $item->penerbit }}</p>
                                <p class="mt-3 text-sm leading-6 text-slate-600">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($item->abstract), 130) }}
                                </p>

                                <div class="mt-5 flex items-center justify-between gap-3 border-t border-slate-100 pt-4">
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-[11px] font-semibold text-slate-600">
                                        {{ $item->bahasa }}
                                    </span>
                                    <a href="{{ route('renstra.show', $item) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#354776] hover:text-[#2a3a61] transition-colors">
                                        Lihat Detail
                                        <i class="fas fa-arrow-right text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if ($renstra->hasPages())
                    <div class="mt-8 flex justify-center">
                        {{ $renstra->links() }}
                    </div>
                @endif
            @else
                <div class="rounded-[28px] border border-dashed border-slate-300 bg-white px-6 py-14 text-center text-slate-500">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-amber-100 text-amber-600 text-2xl">
                        <i class="fas fa-file-lines"></i>
                    </div>
                    <p class="mt-4 text-base font-semibold text-slate-700">Belum ada dokumen Renstra.</p>
                    <p class="mt-2 text-sm">Publikasi Renstra akan tampil di sini setelah ditambahkan dari admin.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
