@extends('frontend.layouts.mainTailwind')

@section('container')
    <section class="bg-[#f7f7f8] py-12 px-4" x-data="pengumumanAttachmentPreview()">
        <div class="mx-auto max-w-6xl">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-[#354776] md:text-5xl">Daftar Pengumuman</h1>
                <div class="mx-auto mt-5 h-2 w-20 rounded-full bg-[#FDC300]"></div>
            </div>

            <div class="mt-10 rounded-[28px] bg-white px-6 py-6 shadow-[0_18px_45px_rgba(15,23,42,0.06)] md:px-8">
                <form action="{{ route('pengumuman.index') }}" method="GET" class="space-y-3">
                    <label for="search" class="block text-sm font-semibold text-gray-900">Masukkan Kata Kunci :</label>
                    <div class="flex items-center overflow-hidden rounded-2xl border border-gray-300 bg-white shadow-inner focus-within:border-[#354776] focus-within:ring-2 focus-within:ring-[#354776]/10">
                        <input
                            id="search"
                            name="search"
                            type="search"
                            value="{{ $search }}"
                            placeholder="Cari judul pengumuman"
                            class="w-full border-0 bg-transparent px-5 py-4 text-sm text-gray-700 outline-none placeholder:text-gray-400"
                        >
                        <button
                            type="submit"
                            class="inline-flex h-12 w-14 items-center justify-center text-xl text-gray-900 transition-colors hover:text-[#354776]"
                            aria-label="Cari pengumuman"
                        >
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            @if ($pengumuman->count())
                <div class="mt-10 space-y-5">
                    @foreach ($pengumuman as $item)
                        <article class="rounded-[28px] bg-white px-6 py-6 shadow-[0_18px_45px_rgba(15,23,42,0.06)] transition-shadow hover:shadow-[0_22px_55px_rgba(15,23,42,0.09)] md:px-8">
                            <div class="flex items-start justify-between gap-4 text-xs text-gray-400">
                                <span class="inline-flex items-center gap-2 font-medium">
                                    <i class="fas fa-calendar-alt text-[11px]"></i>
                                    {{ $item->created_at->translatedFormat('l, d F Y') }}
                                </span>
                                <span class="inline-flex items-center gap-2 whitespace-nowrap">
                                    <i class="far fa-eye text-[11px]"></i>
                                    {{ number_format($item->views) }} dilihat
                                </span>
                            </div>

                            <div class="mt-5 flex flex-col gap-5 md:flex-row md:items-start">
                                <a href="{{ route('pengumuman.show', $item) }}" class="block h-24 w-24 shrink-0 overflow-hidden rounded-2xl bg-[#dbeafe]">
                                    <img
                                        src="{{ $item->thumbnailUrl() }}"
                                        alt="{{ $item->judul }}"
                                        class="h-full w-full object-cover transition-transform duration-300 hover:scale-105"
                                    >
                                </a>

                                <div class="min-w-0 flex-1">
                                    <h2 class="text-xl font-bold uppercase leading-snug text-gray-950">
                                        <a href="{{ route('pengumuman.show', $item) }}" class="transition-colors hover:text-[#354776]">
                                            {{ $item->judul }}
                                        </a>
                                    </h2>
                                    <p class="mt-3 text-sm leading-7 text-gray-700">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($item->isi), 220) }}
                                    </p>

                                    <div class="mt-5 flex flex-wrap items-center justify-between gap-4">
                                        <a href="{{ route('pengumuman.show', $item) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#354776] transition-colors hover:text-[#26375f]">
                                            Selengkapnya..
                                            <i class="fas fa-arrow-right text-xs"></i>
                                        </a>

                                        @if ($item->lampiran_path)
                                            @php
                                                $attachmentUrl = asset('storage/' . $item->lampiran_path);
                                                $extension = strtolower(pathinfo($item->lampiran_path, PATHINFO_EXTENSION));
                                            @endphp
                                            <button
                                                type="button"
                                                @click="open({
                                                    title: @js($item->judul),
                                                    url: @js($attachmentUrl),
                                                    extension: @js($extension),
                                                    filename: @js(basename($item->lampiran_path))
                                                })"
                                                class="inline-flex items-center gap-2 rounded-full border border-amber-200 bg-amber-50 px-4 py-2 text-xs font-semibold text-amber-700 transition-colors hover:border-amber-300 hover:bg-amber-100"
                                            >
                                                <i class="fas fa-paperclip"></i>
                                                Lampiran
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <p class="text-sm text-gray-700">
                        Menampilkan {{ $pengumuman->firstItem() }} sampai {{ $pengumuman->lastItem() }} dari {{ $pengumuman->total() }} Pengumuman
                    </p>

                    @if ($pengumuman->hasPages())
                        @php
                            $startPage = max($pengumuman->currentPage() - 1, 1);
                            $endPage = min($startPage + 2, $pengumuman->lastPage());
                            $startPage = max($endPage - 2, 1);
                        @endphp
                        <nav aria-label="Pagination pengumuman" class="ml-auto">
                            <div class="inline-flex items-center gap-2 rounded-2xl bg-white p-2 shadow-[0_12px_30px_rgba(15,23,42,0.08)]">
                                <a
                                    href="{{ $pengumuman->onFirstPage() ? '#' : $pengumuman->previousPageUrl() }}"
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-sm text-gray-700 transition-colors {{ $pengumuman->onFirstPage() ? 'pointer-events-none opacity-40' : 'hover:bg-gray-100' }}"
                                    aria-disabled="{{ $pengumuman->onFirstPage() ? 'true' : 'false' }}"
                                >
                                    <i class="fas fa-chevron-left text-xs"></i>
                                </a>

                                @for ($page = $startPage; $page <= $endPage; $page++)
                                    <a
                                        href="{{ $pengumuman->url($page) }}"
                                        class="inline-flex h-10 min-w-10 items-center justify-center rounded-xl px-3 text-sm font-semibold transition-colors {{ $page === $pengumuman->currentPage() ? 'bg-[#dbeafe] text-[#1e3a6b]' : 'text-gray-700 hover:bg-gray-100' }}"
                                        aria-current="{{ $page === $pengumuman->currentPage() ? 'page' : 'false' }}"
                                    >
                                        {{ $page }}
                                    </a>
                                @endfor

                                <a
                                    href="{{ $pengumuman->hasMorePages() ? $pengumuman->nextPageUrl() : '#' }}"
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-sm text-gray-700 transition-colors {{ $pengumuman->hasMorePages() ? 'hover:bg-gray-100' : 'pointer-events-none opacity-40' }}"
                                    aria-disabled="{{ $pengumuman->hasMorePages() ? 'false' : 'true' }}"
                                >
                                    <i class="fas fa-chevron-right text-xs"></i>
                                </a>
                            </div>
                        </nav>
                    @endif
                </div>
            @else
                <div class="mt-10 rounded-[28px] border border-dashed border-gray-300 bg-white px-6 py-12 text-center text-gray-500 shadow-[0_18px_45px_rgba(15,23,42,0.05)]">
                    <i class="fas fa-bullhorn text-3xl text-amber-400"></i>
                    <p class="mt-4 text-sm">
                        {{ $search !== '' ? 'Tidak ada pengumuman dengan judul yang cocok.' : 'Belum ada pengumuman yang dipublikasikan.' }}
                    </p>
                </div>
            @endif

            <div
                x-show="isOpen"
                x-cloak
                @keydown.escape.window="close()"
                class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
            >
                <div @click="close()" class="absolute inset-0 bg-slate-950/70"></div>
                <div class="relative z-10 w-full max-w-5xl max-h-[90vh] overflow-hidden rounded-[28px] bg-white shadow-2xl flex flex-col">
                    <div class="flex items-start justify-between gap-4 px-6 py-5 border-b border-gray-100">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900" x-text="attachment.title || 'Lampiran Pengumuman'"></h3>
                            <p class="mt-1 text-xs text-slate-500" x-text="attachment.filename"></p>
                        </div>
                        <button type="button" @click="close()" class="w-10 h-10 rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 transition-colors">&times;</button>
                    </div>

                    <div class="p-6 overflow-auto">
                        <template x-if="isImage()">
                            <img :src="attachment.url" :alt="attachment.title || 'Lampiran Pengumuman'" class="w-full max-h-[70vh] object-contain rounded-2xl bg-slate-50">
                        </template>

                        <template x-if="isPdf()">
                            <iframe :src="attachment.url" title="Preview lampiran pengumuman" class="w-full h-[70vh] rounded-2xl bg-slate-50"></iframe>
                        </template>

                        <template x-if="isDownloadOnly()">
                            <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-amber-100 text-amber-600 text-2xl">
                                    <i class="fas fa-paperclip"></i>
                                </div>
                                <h4 class="mt-4 text-lg font-bold text-slate-900">File tidak bisa dipratinjau langsung</h4>
                                <p class="mt-2 text-sm text-slate-500">Silakan buka atau unduh lampiran untuk melihat isi file.</p>
                            </div>
                        </template>
                    </div>

                    <div class="flex justify-end border-t border-gray-100 bg-slate-50 px-6 py-4">
                        <a :href="attachment.url" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-amber-400 px-5 py-3 text-sm font-semibold text-[#354776] hover:bg-amber-300 transition-colors">
                            <i class="fas fa-arrow-up-right-from-square text-xs"></i>
                            Buka File
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function pengumumanAttachmentPreview() {
            return {
                isOpen: false,
                attachment: { title: '', url: '', extension: '', filename: '' },
                open(file) {
                    this.attachment = file;
                    this.isOpen = true;
                    document.body.style.overflow = 'hidden';
                },
                close() {
                    this.isOpen = false;
                    document.body.style.overflow = '';
                },
                isImage() {
                    return ['jpg', 'jpeg', 'png'].includes((this.attachment.extension || '').toLowerCase());
                },
                isPdf() {
                    return (this.attachment.extension || '').toLowerCase() === 'pdf';
                },
                isDownloadOnly() {
                    return !this.isImage() && !this.isPdf();
                }
            }
        }
    </script>
@endsection
