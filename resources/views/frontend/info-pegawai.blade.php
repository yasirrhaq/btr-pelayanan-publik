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

            <div class="mt-10 grid gap-6 sm:grid-cols-2">
                @foreach ($infoPegawai as $info)
                    @php
                        $initials = \Illuminate\Support\Str::of($info->title ?? 'BTR')
                            ->explode(' ')
                            ->filter()
                            ->take(2)
                            ->map(fn ($part) => \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($part, 0, 1)))
                            ->implode('');
                        $hasPhoto = filled($info->path_image);
                        $avatarTone = str_contains(strtolower($info->jenis_kepegawaian ?? ''), 'non')
                            ? 'bg-[#354776] ring-[#D9E2F2]'
                            : 'bg-red-500/90 ring-red-100';
                    @endphp
                    <article class="group relative overflow-hidden rounded-[28px] border border-slate-200 bg-white p-5 shadow-[0_18px_50px_rgba(15,23,42,0.07)] transition-transform duration-200 hover:-translate-y-1 hover:shadow-[0_24px_60px_rgba(15,23,42,0.10)]">
                        <div class="pointer-events-none absolute right-4 top-4 h-8 w-8 border-r-4 border-t-4 border-amber-300"></div>
                        <div class="grid gap-4 sm:grid-cols-[96px_minmax(0,1fr)] sm:items-center">
                            <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full p-1 text-xl font-semibold text-white shadow-sm ring-4 sm:mx-0 {{ $avatarTone }}">
                                @if ($hasPhoto)
                                    <img
                                        src="{{ imageExists($info->path_image) }}"
                                        alt="{{ $info->title ?: 'Informasi Pegawai' }}"
                                        class="h-full w-full rounded-full object-cover"
                                    >
                                @else
                                    <span aria-hidden="true">{{ $initials ?: 'BT' }}</span>
                                @endif
                            </div>

                            <div class="border-slate-200 sm:border-l sm:pl-5">
                                <dl class="grid gap-2 text-[11px] leading-5 text-slate-500 sm:text-xs">
                                    <div class="grid grid-cols-[92px_minmax(0,1fr)] gap-2">
                                        <dt class="font-semibold uppercase tracking-[0.18em] text-slate-400">Nama</dt>
                                        <dd class="font-semibold text-[#354776]">{{ $info->title }}</dd>
                                    </div>
                                    <div class="grid grid-cols-[92px_minmax(0,1fr)] gap-2">
                                        <dt class="font-semibold uppercase tracking-[0.18em] text-slate-400">NIP</dt>
                                        <dd>{{ $info->nip ?: '-' }}</dd>
                                    </div>
                                    <div class="grid grid-cols-[92px_minmax(0,1fr)] gap-2">
                                        <dt class="font-semibold uppercase tracking-[0.18em] text-slate-400">Status</dt>
                                        <dd>{{ $info->jenis_kepegawaian ?: '-' }}</dd>
                                    </div>
                                    <div class="grid grid-cols-[92px_minmax(0,1fr)] gap-2">
                                        <dt class="font-semibold uppercase tracking-[0.18em] text-slate-400">Pangkat</dt>
                                        <dd>{{ $info->pangkat_golongan ?: '-' }}</dd>
                                    </div>
                                    <div class="grid grid-cols-[92px_minmax(0,1fr)] gap-2">
                                        <dt class="font-semibold uppercase tracking-[0.18em] text-slate-400">Jabatan</dt>
                                        <dd>{{ $info->jabatan ?: '-' }}</dd>
                                    </div>
                                    <div class="grid grid-cols-[92px_minmax(0,1fr)] gap-2">
                                        <dt class="font-semibold uppercase tracking-[0.18em] text-slate-400">Instansi</dt>
                                        <dd>{{ $info->instansi ?: '-' }}</dd>
                                    </div>
                                    <div class="grid grid-cols-[92px_minmax(0,1fr)] gap-2">
                                        <dt class="font-semibold uppercase tracking-[0.18em] text-slate-400">Email</dt>
                                        <dd class="break-all">{{ $info->email ?: '-' }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-8 flex justify-center">
                {{ $infoPegawai->links() }}
            </div>
        </div>
    </section>
@endsection
