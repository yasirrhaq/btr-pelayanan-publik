@extends('frontend.layouts.mainTailwind')

@section('container')
    <section class="bg-[#354776] text-white py-12 px-4">
        <div class="max-w-6xl mx-auto">
            <a href="{{ route('pengumuman.index') }}" class="inline-flex items-center gap-2 text-sm text-white/80 hover:text-white transition-colors">
                <i class="fas fa-arrow-left text-xs"></i>
                Kembali ke Pengumuman
            </a>
            <p class="mt-6 text-xs uppercase tracking-[0.3em] text-amber-300 font-semibold">Pengumuman</p>
            <h1 class="mt-3 text-3xl md:text-4xl font-bold max-w-4xl">{{ $pengumuman->judul }}</h1>
            <p class="mt-3 text-sm text-white/80">Dipublikasikan {{ $pengumuman->created_at->translatedFormat('d F Y') }}</p>
        </div>
    </section>

    <section class="bg-gray-50 py-10 px-4">
        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-[minmax(0,2fr)_360px] gap-8">
            <article class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 md:p-8">
                <div class="prose prose-sm md:prose-base max-w-none prose-headings:text-[#354776] prose-a:text-[#354776]">
                    {!! nl2br(e($pengumuman->isi)) !!}
                </div>

                @if ($pengumuman->lampiran_path)
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <a href="{{ asset('storage/' . $pengumuman->lampiran_path) }}" target="_blank" class="inline-flex items-center gap-2 rounded-full bg-amber-400 hover:bg-amber-300 text-[#354776] font-semibold px-5 py-3 transition-colors">
                            <i class="fas fa-download text-sm"></i>
                            Buka Lampiran
                        </a>
                    </div>
                @endif
            </article>

            <aside class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 h-fit">
                <h2 class="text-lg font-bold text-[#354776]">Pengumuman Terbaru</h2>
                <div class="mt-5 space-y-4">
                    @forelse ($terbaru as $item)
                        <a href="{{ route('pengumuman.show', $item) }}" class="block rounded-xl border border-gray-100 p-4 hover:border-[#354776]/20 hover:shadow-sm transition-all">
                            <p class="text-[11px] uppercase tracking-wide text-amber-500 font-semibold">{{ $item->created_at->format('d M Y') }}</p>
                            <h3 class="mt-2 text-sm font-semibold text-gray-900 leading-6">{{ $item->judul }}</h3>
                        </a>
                    @empty
                        <p class="text-sm text-gray-500">Tidak ada pengumuman lain.</p>
                    @endforelse
                </div>
            </aside>
        </div>
    </section>
@endsection
