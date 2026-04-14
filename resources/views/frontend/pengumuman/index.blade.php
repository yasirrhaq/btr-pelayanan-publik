@extends('frontend.layouts.mainTailwind')

@section('container')
    <section class="bg-[#354776] text-white py-12 px-4">
        <div class="max-w-6xl mx-auto">
            <p class="text-xs uppercase tracking-[0.3em] text-amber-300 font-semibold">Publikasi</p>
            <h1 class="mt-3 text-3xl md:text-4xl font-bold">Pengumuman</h1>
            <p class="mt-3 max-w-3xl text-sm md:text-base text-white/80">
                Kumpulan pengumuman resmi Balai Teknik Rawa yang dipublikasikan untuk masyarakat dan pemangku kepentingan.
            </p>
        </div>
    </section>

    <section class="bg-gray-50 py-10 px-4">
        <div class="max-w-6xl mx-auto">
            @if ($pengumuman->count())
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach ($pengumuman as $item)
                        <article class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                            <div class="px-6 pt-6">
                                <div class="flex items-center gap-2 text-xs font-semibold text-[#354776] uppercase tracking-wide">
                                    <i class="fas fa-bullhorn text-amber-400"></i>
                                    <span>{{ $item->created_at->format('d M Y') }}</span>
                                </div>
                                <h2 class="mt-3 text-lg font-bold text-gray-900 leading-snug">
                                    <a href="{{ route('pengumuman.show', $item) }}" class="hover:text-[#354776] transition-colors">
                                        {{ $item->judul }}
                                    </a>
                                </h2>
                                <p class="mt-3 text-sm leading-6 text-gray-600">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($item->isi), 140) }}
                                </p>
                            </div>
                            <div class="px-6 py-5 mt-5 border-t border-gray-100 flex items-center justify-between gap-3">
                                <a href="{{ route('pengumuman.show', $item) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#354776] hover:text-[#2a3a61] transition-colors">
                                    Baca Pengumuman
                                    <i class="fas fa-arrow-right text-xs"></i>
                                </a>
                                @if ($item->lampiran_path)
                                    <a href="{{ asset('storage/' . $item->lampiran_path) }}" target="_blank" class="inline-flex items-center gap-2 text-xs font-semibold text-amber-600 hover:text-amber-700 transition-colors">
                                        <i class="fas fa-paperclip"></i>
                                        Lampiran
                                    </a>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                @if ($pengumuman->hasPages())
                    <div class="mt-8 flex justify-center">
                        {{ $pengumuman->links() }}
                    </div>
                @endif
            @else
                <div class="bg-white border border-dashed border-gray-300 rounded-2xl p-10 text-center text-gray-500">
                    <i class="fas fa-bullhorn text-3xl text-amber-400"></i>
                    <p class="mt-4 text-sm">Belum ada pengumuman yang dipublikasikan.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
