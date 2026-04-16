@extends('frontend.layouts.mainTailwind')

@section('container')
    <section class="bg-slate-50 px-4 py-12 md:py-16">
        <div class="mx-auto max-w-6xl">
            <div class="text-center">
                <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-[#354776]">
                    Profil Balai
                </span>
                <h1 class="mt-5 text-3xl font-bold tracking-tight text-[#354776] md:text-5xl">Struktur Organisasi</h1>
                <div class="mx-auto mt-4 h-1.5 w-24 rounded-full bg-amber-400"></div>
                <p class="mx-auto mt-6 max-w-3xl text-sm leading-7 text-slate-600 md:text-base">
                    Struktur organisasi Balai Teknik Rawa berdasarkan Peraturan Menteri PUPR Nomor 16 Tahun 2020 tentang Organisasi dan Tata Kerja Unit Pelaksana Teknis Kementerian Pekerjaan Umum dan Perumahan Rakyat.
                </p>
            </div>

            <div class="mt-10 space-y-8">
                @foreach ($strukturOrganisasi as $item)
                    <div class="overflow-hidden rounded-3xl bg-white p-4 shadow-sm ring-1 ring-slate-200 md:p-6">
                        <img src="{{ imageExists($item->path_image ?: 'assets/struktur.png') }}" alt="{{ $item->title ?: 'Struktur Organisasi BTR' }}" class="w-full object-contain">
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex justify-center">
                {{ $strukturOrganisasi->links() }}
            </div>
        </div>
    </section>
@endsection
