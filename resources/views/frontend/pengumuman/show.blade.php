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
            <div class="mt-3 flex flex-wrap items-center gap-4 text-sm text-white/80">
                <span>Dipublikasikan {{ $pengumuman->created_at->translatedFormat('d F Y') }}</span>
                <span class="inline-flex items-center gap-2">
                    <i class="far fa-eye text-xs"></i>
                    {{ number_format($pengumuman->views) }} dilihat
                </span>
            </div>
        </div>
    </section>

    <section class="bg-gray-50 py-10 px-4" x-data="pengumumanAttachmentPreview()">
        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-[minmax(0,2fr)_360px] gap-8">
            <article class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 md:p-8">
                <img src="{{ $pengumuman->thumbnailUrl() }}" alt="{{ $pengumuman->judul }}" class="mb-6 h-64 w-full rounded-2xl object-cover md:h-80">
                @php
                    $hasRichContent = $pengumuman->isi !== strip_tags($pengumuman->isi);
                @endphp
                <div class="prose prose-sm md:prose-base max-w-none prose-headings:text-[#354776] prose-a:text-[#354776]">
                    @if ($hasRichContent)
                        {!! $pengumuman->isi !!}
                    @else
                        {!! nl2br(e($pengumuman->isi)) !!}
                    @endif
                </div>

                @if ($pengumuman->lampiran_path)
                    @php
                        $attachmentUrl = asset('storage/' . $pengumuman->lampiran_path);
                        $extension = strtolower(pathinfo($pengumuman->lampiran_path, PATHINFO_EXTENSION));
                    @endphp
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <button
                            type="button"
                            @click="open({
                                title: @js($pengumuman->judul),
                                url: @js($attachmentUrl),
                                extension: @js($extension),
                                filename: @js(basename($pengumuman->lampiran_path))
                            })"
                            class="inline-flex items-center gap-2 rounded-full bg-amber-400 hover:bg-amber-300 text-[#354776] font-semibold px-5 py-3 transition-colors"
                        >
                            <i class="fas fa-download text-sm"></i>
                            Buka Lampiran
                        </button>
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
