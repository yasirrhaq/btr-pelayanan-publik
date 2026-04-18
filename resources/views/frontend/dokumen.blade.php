@extends('frontend.layouts.mainTailwind')

@section('container')
    <style>
        .dokumen-preview-btn {
            border-color: #e2e8f0;
            background: #ffffff;
            color: #475569;
        }

        .dokumen-preview-btn:hover {
            border-color: #2a3a61;
            background: #eef3ff;
            color: #2a3a61;
        }
    </style>

    <section class="bg-[#354776] text-white py-12 px-4">
        <div class="max-w-6xl mx-auto">
            <p class="text-xs uppercase tracking-[0.3em] text-amber-300 font-semibold">Publikasi</p>
            <h1 class="mt-3 text-3xl md:text-4xl font-bold">Dokumen Publik</h1>
            <p class="mt-3 max-w-3xl text-sm md:text-base text-white/80">
                Lampiran dan dokumen publik yang tersedia dari pengumuman, berita, dan galeri dokumen Balai Teknik Rawa.
            </p>
            <div class="mt-5 inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-xs font-semibold text-white/80">
                <i class="fas fa-folder-open text-amber-300"></i>
                <span>{{ $dokumenCount }} dokumen tersedia</span>
            </div>
        </div>
    </section>

    <section class="bg-slate-50 py-10 px-4" x-data="dokumenPreview()">
        <div class="max-w-6xl mx-auto">
            @if ($dokumen->count())
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach ($dokumen as $item)
                        <article class="group flex h-full flex-col overflow-hidden rounded-[26px] border border-slate-200 bg-white shadow-sm transition-all duration-200 hover:-translate-y-1 hover:border-slate-300 hover:shadow-xl">
                            <div class="h-1.5 w-full bg-gradient-to-r from-[#354776] via-[#49639f] to-amber-400"></div>

                            <div class="flex flex-1 flex-col p-6">
                                <div class="flex min-h-[2.5rem] items-start justify-between gap-3">
                                    <span class="inline-flex items-center rounded-full bg-[#354776]/8 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.22em] text-[#354776]">
                                        {{ $item['source'] }}
                                    </span>
                                    <span class="pt-1 text-[11px] font-semibold uppercase tracking-[0.12em] text-slate-400">{{ optional($item['published_at'])->format('d M Y') }}</span>
                                </div>

                                <div class="mt-4 min-h-[4.5rem]">
                                    <h2 class="text-[1.15rem] font-bold leading-snug text-slate-900" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                        {{ $item['title'] }}
                                    </h2>
                                </div>

                                <div class="mt-3 min-h-[5.75rem]">
                                    <p class="text-sm leading-6 text-slate-600" style="display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">
                                        {{ $item['summary'] }}
                                    </p>
                                </div>

                                <div class="mt-5 flex min-h-[5.5rem] items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50/90 px-4 py-3">
                                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-amber-100 text-amber-600 shadow-sm">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-slate-900">{{ $item['filename'] }}</p>
                                        <p class="mt-1 text-[11px] uppercase tracking-[0.22em] text-slate-400">{{ strtoupper($item['extension'] ?: 'FILE') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-auto flex items-center gap-3 border-t border-slate-100 px-6 py-4">
                                <a href="{{ $item['page_url'] }}" class="inline-flex min-h-[44px] min-w-0 flex-1 items-center gap-2 text-sm font-semibold text-[#354776] transition-colors hover:text-[#2a3a61]">
                                    <span>Lihat Sumber</span>
                                    <i class="fas fa-arrow-right text-xs transition-transform duration-200 group-hover:translate-x-0.5"></i>
                                </a>
                                <div class="ml-auto flex flex-shrink-0 items-center gap-2">
                                    <button
                                        type="button"
                                        @click="open({
                                            title: @js($item['title']),
                                            url: @js($item['url']),
                                            extension: @js($item['extension']),
                                            filename: @js($item['filename'])
                                        })"
                                        class="dokumen-preview-btn inline-flex min-h-[44px] min-w-[84px] items-center justify-center gap-2 rounded-full border px-4 py-2 text-xs font-semibold transition-colors"
                                    >
                                        Preview
                                    </button>
                                    <a href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex min-h-[44px] min-w-[84px] items-center justify-center gap-2 rounded-full bg-amber-400 px-4 py-2 text-xs font-semibold text-[#354776] transition-colors hover:bg-amber-300">
                                        Buka
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if ($dokumen->hasPages())
                    <div class="mt-10 flex justify-center">
                        {{ $dokumen->links() }}
                    </div>
                @endif
            @else
                <div class="rounded-[28px] border border-dashed border-slate-300 bg-white px-6 py-16 text-center text-slate-500">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-amber-100 text-amber-500 text-2xl">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <p class="mt-4 text-sm">Belum ada dokumen publik yang tersedia.</p>
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
                    <div class="flex items-start justify-between gap-4 px-6 py-5 border-b border-slate-100">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900" x-text="dokumen.title || 'Dokumen Publik'"></h3>
                            <p class="mt-1 text-xs text-slate-500" x-text="dokumen.filename"></p>
                        </div>
                        <button type="button" @click="close()" class="h-10 w-10 rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 transition-colors">&times;</button>
                    </div>

                    <div class="p-6 overflow-auto">
                        <template x-if="isImage()">
                            <img :src="dokumen.url" :alt="dokumen.title || 'Dokumen Publik'" class="w-full max-h-[70vh] object-contain rounded-2xl bg-slate-50">
                        </template>

                        <template x-if="isPdf()">
                            <iframe :src="dokumen.url" title="Preview dokumen publik" class="w-full h-[70vh] rounded-2xl bg-slate-50"></iframe>
                        </template>

                        <template x-if="isDownloadOnly()">
                            <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-amber-100 text-amber-600 text-2xl">
                                    <i class="fas fa-file-download"></i>
                                </div>
                                <h4 class="mt-4 text-lg font-bold text-slate-900">File perlu dibuka atau diunduh</h4>
                                <p class="mt-2 text-sm text-slate-500">Preview langsung hanya tersedia untuk gambar dan PDF.</p>
                            </div>
                        </template>
                    </div>

                    <div class="flex justify-end border-t border-slate-100 bg-slate-50 px-6 py-4">
                        <a :href="dokumen.url" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-amber-400 px-5 py-3 text-sm font-semibold text-[#354776] hover:bg-amber-300 transition-colors">
                            <i class="fas fa-arrow-up-right-from-square text-xs"></i>
                            Buka File
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function dokumenPreview() {
            return {
                isOpen: false,
                dokumen: { title: '', url: '', extension: '', filename: '' },
                open(file) {
                    this.dokumen = file;
                    this.isOpen = true;
                    document.body.style.overflow = 'hidden';
                },
                close() {
                    this.isOpen = false;
                    document.body.style.overflow = '';
                },
                isImage() {
                    return ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes((this.dokumen.extension || '').toLowerCase());
                },
                isPdf() {
                    return (this.dokumen.extension || '').toLowerCase() === 'pdf';
                },
                isDownloadOnly() {
                    return !this.isImage() && !this.isPdf();
                }
            }
        }
    </script>
@endsection
