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

    <section class="bg-gray-50 py-10 px-4" x-data="pengumumanAttachmentPreview()">
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
                                        class="inline-flex items-center gap-2 text-xs font-semibold text-amber-600 hover:text-amber-700 transition-colors"
                                    >
                                        <i class="fas fa-paperclip"></i>
                                        Lampiran
                                    </button>
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
