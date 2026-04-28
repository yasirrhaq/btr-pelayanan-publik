@extends('frontend.layouts.mainTailwind')

@section('customCss')
    <link rel="stylesheet" href="{{ url('css/frontend/fasilitas.css')}}">
    <style>
        .foto-page-shell {
            background: #F7F7F8;
            padding: 52px 0 28px;
        }

        .foto-heading {
            text-align: center;
            margin-bottom: 34px;
        }

        .foto-heading-title {
            margin: 0;
            color: #354776;
            font-size: 42px;
            font-weight: 700;
        }

        .foto-heading-divider {
            width: 80px;
            height: 8px;
            margin: 18px auto 0;
            border-radius: 999px;
            background: #FDC300;
        }

        .foto-filter-card {
            border: 1px solid #ECECEC;
            border-radius: 26px;
            background: #FFFFFF;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.05);
            padding: 22px 22px 18px;
            margin-bottom: 28px;
        }

        .foto-filter-grid {
            display: grid;
            grid-template-columns: minmax(0, 320px) minmax(0, 1fr) auto;
            gap: 14px;
            align-items: end;
        }

        .foto-filter-label {
            display: block;
            margin-bottom: 8px;
            color: #111827;
            font-size: 15px;
            font-weight: 600;
        }

        .foto-filter-control {
            width: 100%;
            height: 50px;
            border: 2px solid #C7CBD4;
            border-radius: 12px;
            background: #FFFFFF;
            color: #1F2937;
            padding: 0 16px;
            font-size: 15px;
            outline: none;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .foto-filter-control:focus {
            border-color: #354776;
            box-shadow: 0 0 0 4px rgba(53, 71, 118, 0.12);
        }

        .foto-filter-submit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 54px;
            height: 50px;
            border: none;
            border-radius: 14px;
            background: #FFFFFF;
            color: #111827;
            font-size: 30px;
            cursor: pointer;
            transition: color .2s ease, transform .2s ease;
        }

        .foto-filter-submit:hover {
            color: #354776;
            transform: translateY(-1px);
        }

        .foto-gallery-grid {
            display: grid;
            gap: 20px;
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .foto-gallery-card {
            position: relative;
            border: 1px solid #E9ECF2;
            border-radius: 20px;
            overflow: hidden;
            background: #FFFFFF;
            box-shadow: 0 18px 36px rgba(15, 23, 42, 0.06);
            transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease;
            cursor: pointer;
        }

        .foto-gallery-card:hover {
            transform: translateY(-6px);
            border-color: rgba(53, 71, 118, 0.22);
            box-shadow: 0 24px 54px rgba(15, 23, 42, 0.12);
        }

        .foto-gallery-media {
            position: relative;
            aspect-ratio: 1 / 1;
            margin: 12px 12px 0;
            overflow: hidden;
            border-radius: 18px;
            background: #EEF3FA;
        }

        .foto-gallery-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .4s ease;
        }

        .foto-gallery-card:hover .foto-gallery-media img {
            transform: scale(1.05);
        }

        .foto-gallery-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: flex-start;
            justify-content: flex-end;
            padding: 14px;
            background: linear-gradient(180deg, rgba(22, 43, 82, 0.04) 0%, rgba(22, 43, 82, 0.58) 100%);
            opacity: 0;
            transition: opacity .24s ease;
        }

        .foto-gallery-card:hover .foto-gallery-overlay {
            opacity: 1;
        }

        .foto-gallery-eye {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.94);
            color: #1E3A6B;
            font-size: 17px;
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.12);
        }

        .foto-gallery-body {
            padding: 14px 16px 16px;
        }

        .foto-gallery-title {
            margin: 0;
            color: #111827;
            font-size: 17px;
            font-weight: 500;
            line-height: 1.45;
            text-align: center;
            min-height: 52px;
        }

        .foto-gallery-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-top: 14px;
            color: #9CA3AF;
            font-size: 12px;
        }

        .foto-gallery-source {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #6B7280;
            font-weight: 500;
        }

        .foto-gallery-empty {
            border: 1px dashed #D1D5DB;
            border-radius: 22px;
            background: #FFFFFF;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.04);
            text-align: center;
            padding: 52px 20px;
            color: #6B7280;
        }

        .foto-pagination-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            margin-top: 26px;
            flex-wrap: wrap;
        }

        .foto-pagination-summary {
            color: #111827;
            font-size: 15px;
        }

        .foto-pagination-nav {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-radius: 16px;
            background: #FFFFFF;
            padding: 8px;
            box-shadow: 0 16px 36px rgba(15, 23, 42, 0.08);
        }

        .foto-pagination-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 42px;
            height: 42px;
            padding: 0 12px;
            border-radius: 12px;
            color: #1F2937;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            transition: background-color .2s ease, color .2s ease, opacity .2s ease;
        }

        .foto-pagination-link:hover {
            background: #F3F4F6;
            color: #1E3A6B;
            text-decoration: none;
        }

        .foto-pagination-link.active {
            background: #D9EAFE;
            color: #1E3A6B;
        }

        .foto-pagination-link.disabled {
            opacity: .42;
            pointer-events: none;
        }

        .foto-lightbox {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: rgba(15, 23, 42, 0.82);
            backdrop-filter: blur(4px);
        }

        .foto-lightbox.is-open {
            display: flex;
        }

        .foto-lightbox-dialog {
            position: relative;
            width: fit-content;
            max-width: min(1120px, calc(100vw - 48px));
            max-height: calc(100vh - 48px);
            overflow: hidden;
            border-radius: 28px;
            border: 1px solid rgba(255, 255, 255, 0.16);
            background: #FFFFFF;
            box-shadow: 0 28px 70px rgba(15, 23, 42, 0.35);
            display: flex;
            flex-direction: column;
        }

        .foto-lightbox-close {
            position: absolute;
            top: 18px;
            right: 18px;
            z-index: 2;
            width: 44px;
            height: 44px;
            border: none;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.72);
            color: #FFFFFF;
            font-size: 24px;
            line-height: 1;
            cursor: pointer;
        }

        .foto-lightbox-media {
            background: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 18px 18px 0;
        }

        .foto-lightbox-media img {
            width: auto;
            height: auto;
            max-width: min(1040px, calc(100vw - 84px));
            max-height: min(72vh, calc(100vh - 190px));
            object-fit: contain;
            display: block;
            margin: 0 auto;
            border-radius: 18px;
            background: #FFFFFF;
            box-shadow: 0 16px 36px rgba(15, 23, 42, 0.08);
        }

        .foto-lightbox-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 18px 24px;
            border-top: 1px solid #E5E7EB;
            background: #FFFFFF;
        }

        .foto-lightbox-title {
            margin: 0;
            color: #1E3A6B;
            font-size: 18px;
            font-weight: 600;
            line-height: 1.4;
        }

        .foto-lightbox-counter {
            color: #6B7280;
            font-size: 13px;
            font-weight: 500;
            white-space: nowrap;
        }

        .foto-lightbox-actions {
            display: inline-flex;
            align-items: center;
            gap: 12px;
        }

        .foto-lightbox-source {
            display: none;
            align-items: center;
            gap: 8px;
            border-radius: 999px;
            background: #FDC300;
            color: #162B52;
            text-decoration: none;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 700;
        }

        .foto-lightbox-source:hover {
            background: #FFD84D;
            color: #162B52;
            text-decoration: none;
        }

        .foto-lightbox-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 2;
            width: 52px;
            height: 52px;
            border: none;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.92);
            color: #1E3A6B;
            font-size: 22px;
            cursor: pointer;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.18);
        }

        .foto-lightbox-nav.prev { left: 18px; }
        .foto-lightbox-nav.next { right: 18px; }
        .foto-lightbox-nav[disabled] { opacity: .45; cursor: not-allowed; }

        @media (max-width: 991.98px) {
            .foto-filter-grid {
                grid-template-columns: 1fr;
            }

            .foto-gallery-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .foto-filter-submit {
                width: 50px;
            }
        }

        @media (max-width: 767.98px) {
            .foto-page-shell { padding-top: 36px; }
            .foto-heading-title { font-size: 32px; }
            .foto-gallery-grid { grid-template-columns: 1fr; }
            .foto-lightbox { padding: 14px; }
            .foto-lightbox-dialog { border-radius: 22px; }
            .foto-lightbox-nav { width: 44px; height: 44px; }
            .foto-lightbox-footer {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endsection

@section('container')
    <main class="foto-page-shell">
        <div class="container">
            <div class="foto-heading">
                <h1 class="foto-heading-title">Foto</h1>
                <div class="foto-heading-divider"></div>
            </div>

            <div class="foto-filter-card">
                <form action="{{ url('/foto') }}" method="GET">
                    <div class="foto-filter-grid">
                        <div>
                            <label class="foto-filter-label" for="category">Filter Kategori :</label>
                            <select id="category" name="category" class="foto-filter-control">
                                @foreach ($categories as $value => $label)
                                    <option value="{{ $value }}" {{ $selectedCategory === $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="foto-filter-label" for="search">Masukkan Kata Kunci :</label>
                            <input
                                id="search"
                                name="search"
                                type="search"
                                value="{{ $search }}"
                                class="foto-filter-control"
                                placeholder="Cari judul foto atau sumber"
                            >
                        </div>
                        <button type="submit" class="foto-filter-submit" aria-label="Cari foto">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            @if ($galeri_foto->count())
                <div class="foto-gallery-grid">
                    @foreach ($galeri_foto as $item)
                        <article
                            class="foto-gallery-card"
                            data-foto-card
                            data-title="{{ e($item['title']) }}"
                            data-image="{{ e($item['image_url']) }}"
                            data-source-url="{{ e($item['detail_url'] ?? '') }}"
                            data-source-label="{{ e($item['category_label']) }}"
                            data-index="{{ $loop->index }}"
                        >
                            <div class="foto-gallery-media">
                                <img src="{{ $item['image_url'] }}" alt="{{ $item['title'] }}" loading="lazy">
                                <div class="foto-gallery-overlay">
                                    <span class="foto-gallery-eye">
                                        <i class="far fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="foto-gallery-body">
                                <h5 class="foto-gallery-title">{{ $item['title'] }}</h5>
                                <div class="foto-gallery-meta">
                                    <span>{{ optional($item['published_at'])->translatedFormat('d F Y') }}</span>
                                    <span class="foto-gallery-source">
                                        <i class="fas fa-folder-open"></i>
                                        {{ $item['category_label'] }}
                                    </span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="foto-pagination-row">
                    <p class="foto-pagination-summary">
                        Menampilkan {{ $galeri_foto->firstItem() }} Foto dari {{ $galeri_foto->total() }} Foto
                    </p>

                    @if ($galeri_foto->hasPages())
                        @php
                            $currentPage = $galeri_foto->currentPage();
                            $lastPage = $galeri_foto->lastPage();
                            $startPage = max($currentPage - 1, 1);
                            $endPage = min($currentPage + 1, $lastPage);

                            if ($endPage - $startPage < 2) {
                                if ($startPage === 1) {
                                    $endPage = min(3, $lastPage);
                                } elseif ($endPage === $lastPage) {
                                    $startPage = max($lastPage - 2, 1);
                                }
                            }
                        @endphp
                        <nav class="foto-pagination-nav" aria-label="Pagination galeri foto">
                            <a href="{{ $galeri_foto->onFirstPage() ? '#' : $galeri_foto->previousPageUrl() }}" class="foto-pagination-link {{ $galeri_foto->onFirstPage() ? 'disabled' : '' }}">
                                <i class="fas fa-chevron-left"></i>
                            </a>

                            @if ($startPage > 1)
                                <a href="{{ $galeri_foto->url(1) }}" class="foto-pagination-link {{ 1 === $currentPage ? 'active' : '' }}">1</a>
                                @if ($startPage > 2)
                                    <span class="foto-pagination-link disabled">...</span>
                                @endif
                            @endif

                            @for ($page = $startPage; $page <= $endPage; $page++)
                                <a href="{{ $galeri_foto->url($page) }}" class="foto-pagination-link {{ $page === $galeri_foto->currentPage() ? 'active' : '' }}">
                                    {{ $page }}
                                </a>
                            @endfor

                            @if ($endPage < $lastPage)
                                @if ($endPage < $lastPage - 1)
                                    <span class="foto-pagination-link disabled">...</span>
                                @endif
                                <a href="{{ $galeri_foto->url($lastPage) }}" class="foto-pagination-link {{ $lastPage === $currentPage ? 'active' : '' }}">{{ $lastPage }}</a>
                            @endif

                            <a href="{{ $galeri_foto->hasMorePages() ? $galeri_foto->nextPageUrl() : '#' }}" class="foto-pagination-link {{ $galeri_foto->hasMorePages() ? '' : 'disabled' }}">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </nav>
                    @endif
                </div>
            @else
                <div class="foto-gallery-empty">
                    Belum ada foto yang cocok dengan filter saat ini.
                </div>
            @endif
        </div>
    </main>

    @if ($galeri_foto->count())
        <div id="foto-lightbox" class="foto-lightbox" aria-hidden="true">
            <div class="foto-lightbox-dialog" role="dialog" aria-modal="true" aria-label="Preview foto galeri">
                <button type="button" class="foto-lightbox-close" id="foto-lightbox-close" aria-label="Tutup preview">&times;</button>
                <button type="button" class="foto-lightbox-nav prev" id="foto-lightbox-prev" aria-label="Foto sebelumnya">&#8249;</button>
                <button type="button" class="foto-lightbox-nav next" id="foto-lightbox-next" aria-label="Foto berikutnya">&#8250;</button>
                <div class="foto-lightbox-media">
                    <img id="foto-lightbox-image" src="" alt="">
                </div>
                <div class="foto-lightbox-footer">
                    <div>
                        <h4 class="foto-lightbox-title" id="foto-lightbox-title"></h4>
                        <span class="foto-lightbox-counter" id="foto-lightbox-counter"></span>
                    </div>
                    <div class="foto-lightbox-actions">
                        <a id="foto-lightbox-source" class="foto-lightbox-source" href="#" target="_blank" rel="noopener noreferrer">
                            <i class="fas fa-link"></i>
                            Buka Sumber
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            (function () {
                var cards = Array.from(document.querySelectorAll('[data-foto-card]'));
                var modal = document.getElementById('foto-lightbox');
                var dialog = modal ? modal.querySelector('.foto-lightbox-dialog') : null;
                var image = document.getElementById('foto-lightbox-image');
                var title = document.getElementById('foto-lightbox-title');
                var counter = document.getElementById('foto-lightbox-counter');
                var closeButton = document.getElementById('foto-lightbox-close');
                var prevButton = document.getElementById('foto-lightbox-prev');
                var nextButton = document.getElementById('foto-lightbox-next');
                var sourceLink = document.getElementById('foto-lightbox-source');
                var activeIndex = 0;

                if (!modal || !dialog || !cards.length) {
                    return;
                }

                function render(index) {
                    var item = cards[index];
                    if (!item) return;

                    activeIndex = index;
                    image.src = item.dataset.image || '';
                    image.alt = item.dataset.title || 'Foto galeri';
                    title.textContent = item.dataset.title || 'Foto galeri';
                    counter.textContent = (index + 1) + ' / ' + cards.length + ' • ' + (item.dataset.sourceLabel || '');

                    if (item.dataset.sourceUrl) {
                        sourceLink.href = item.dataset.sourceUrl;
                        sourceLink.style.display = 'inline-flex';
                    } else {
                        sourceLink.href = '#';
                        sourceLink.style.display = 'none';
                    }

                    prevButton.disabled = index === 0;
                    nextButton.disabled = index === cards.length - 1;
                }

                function open(index) {
                    render(index);
                    modal.classList.add('is-open');
                    modal.setAttribute('aria-hidden', 'false');
                    document.body.style.overflow = 'hidden';
                }

                function close() {
                    modal.classList.remove('is-open');
                    modal.setAttribute('aria-hidden', 'true');
                    document.body.style.overflow = '';
                }

                cards.forEach(function (card, index) {
                    card.addEventListener('click', function () {
                        open(index);
                    });
                });

                closeButton.addEventListener('click', close);

                modal.addEventListener('click', function (event) {
                    if (!dialog.contains(event.target)) {
                        close();
                    }
                });

                prevButton.addEventListener('click', function () {
                    if (activeIndex > 0) render(activeIndex - 1);
                });

                nextButton.addEventListener('click', function () {
                    if (activeIndex < cards.length - 1) render(activeIndex + 1);
                });

                document.addEventListener('keydown', function (event) {
                    if (!modal.classList.contains('is-open')) return;

                    if (event.key === 'Escape') close();
                    if (event.key === 'ArrowLeft' && activeIndex > 0) render(activeIndex - 1);
                    if (event.key === 'ArrowRight' && activeIndex < cards.length - 1) render(activeIndex + 1);
                });
            })();
        </script>
    @endif
@endsection
