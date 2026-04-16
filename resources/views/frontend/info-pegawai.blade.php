@extends('frontend.layouts.mainTailwind')

@section('container')
    <section class="bg-slate-50 px-4 py-12 md:py-16">
        <div class="mx-auto max-w-6xl">
            <div class="text-center">
                <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-[#354776]">
                    Sumber Daya Manusia
                </span>
                <h1 class="mt-5 text-3xl font-bold tracking-tight text-[#354776] md:text-5xl">Informasi Pegawai</h1>
                <p class="mt-2 text-sm font-medium text-slate-500 md:text-base">{{ config('app.name') }}</p>
                <div class="mx-auto mt-4 h-1.5 w-24 rounded-full bg-amber-400"></div>
            </div>

            <div class="mt-10 grid gap-8">
                @foreach ($infoPegawai as $info)
                    <div class="overflow-hidden rounded-3xl bg-white p-4 shadow-sm ring-1 ring-slate-200 md:p-6">
                        <img src="{{ imageExists($info->path_image ?: 'assets/info-pegawai.jpg') }}" alt="{{ $info->title ?: 'Informasi Pegawai' }}" class="w-full rounded-2xl object-contain">
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex justify-center">
                {{ $infoPegawai->links() }}
            </div>
        </div>
    </section>
@endsection
