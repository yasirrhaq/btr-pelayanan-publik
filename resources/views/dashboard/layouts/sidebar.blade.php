@php
    $is = function ($pattern) { return request()->is($pattern) ? 'active' : ''; };
    $group = function (array $patterns) {
        foreach ($patterns as $p) {
            if (request()->is($p)) return 'open';
        }
        return '';
    };
@endphp

<aside class="btr-sidebar">
    <a href="{{ url('dashboard') }}" class="btr-logo">
        <span class="btr-logo-mark">B</span>
        BALAI TEKNIK RAWA
    </a>

    <ul class="btr-nav">
        <li class="btr-nav-item">
            <a class="btr-nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ url('dashboard') }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10h14V10"/></svg>
                Dashboard
            </a>
        </li>

        {{-- Profil --}}
        <li class="btr-nav-item">
            <button class="btr-nav-parent {{ $group(['dashboard/profil-singkat*','dashboard/info-pegawai*','dashboard/struktur-organisasi*','dashboard/fasilitas-balai*']) }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 0 20M12 2a15.3 15.3 0 0 0 0 20"/></svg>
                Profil
                <svg class="chev" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </button>
            <ul class="btr-nav-children {{ $group(['dashboard/profil-singkat*','dashboard/info-pegawai*','dashboard/struktur-organisasi*','dashboard/fasilitas-balai*']) }}">
                <li><a class="btr-nav-link {{ $is('dashboard/profil-singkat*') }}" href="{{ url('dashboard/profil-singkat') }}">Identitas</a></li>
                <li><a class="btr-nav-link {{ $is('dashboard/info-pegawai*') || request()->is('dashboard/struktur-organisasi*') ? 'active' : '' }}" href="{{ url('dashboard/info-pegawai') }}">SDM</a></li>
                <li><a class="btr-nav-link {{ $is('dashboard/fasilitas-balai*') }}" href="{{ url('dashboard/fasilitas-balai') }}">Fasilitas</a></li>
            </ul>
        </li>

        {{-- Layanan --}}
        <li class="btr-nav-item">
            <a class="btr-nav-link {{ $is('dashboard/url-layanan*') || request()->is('dashboard/status-layanan*') || request()->is('dashboard/foto-layanan*') ? 'active' : '' }}" href="{{ url('dashboard/url-layanan') }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2"/></svg>
                Layanan
            </a>
        </li>

        {{-- Publikasi --}}
        <li class="btr-nav-item">
            <button class="btr-nav-parent {{ $group(['dashboard/foto-home*','dashboard/posts*','dashboard/categories*','dashboard/galeri*','dashboard/karya-ilmiah*']) }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2"/></svg>
                Publikasi
                <svg class="chev" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </button>
            <ul class="btr-nav-children {{ $group(['dashboard/foto-home*','dashboard/posts*','dashboard/categories*','dashboard/galeri*','dashboard/karya-ilmiah*']) }}">
                <li><a class="btr-nav-link {{ $is('dashboard/foto-home*') }}" href="{{ url('dashboard/foto-home') }}">Banner</a></li>
                <li><a class="btr-nav-link {{ $is('dashboard/posts*') || request()->is('dashboard/categories*') ? 'active' : '' }}" href="{{ url('dashboard/posts') }}">Berita</a></li>
                <li><a class="btr-nav-link {{ $is('dashboard/galeri*') }}" href="{{ url('dashboard/galeri/foto-video') }}">Galeri</a></li>
                <li><a class="btr-nav-link {{ $is('dashboard/karya-ilmiah*') }}" href="{{ url('dashboard/karya-ilmiah') }}">Karya Ilmiah</a></li>
            </ul>
        </li>

        {{-- Tautan --}}
        <li class="btr-nav-item">
            <a class="btr-nav-link {{ $is('dashboard/situs-terkait*') }}" href="{{ url('dashboard/situs-terkait') }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 0 0-5.656 0l-4 4a4 4 0 1 0 5.656 5.656l1.102-1.101"/><path stroke-linecap="round" stroke-linejoin="round" d="M10.172 13.828a4 4 0 0 0 5.656 0l4-4a4 4 0 1 0-5.656-5.656l-1.1 1.1"/></svg>
                Tautan
            </a>
        </li>

        {{-- Pengaturan --}}
        <li class="btr-nav-item">
            <button class="btr-nav-parent {{ $group(['dashboard/footer-setting*','dashboard/settings*','dashboard/landing-page*']) }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                Pengaturan
                <svg class="chev" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </button>
            <ul class="btr-nav-children {{ $group(['dashboard/footer-setting*','dashboard/settings*','dashboard/landing-page*']) }}">
                <li><a class="btr-nav-link {{ $is('dashboard/settings*') }}" href="{{ url('dashboard/settings') }}">Hak Akses</a></li>
                <li><a class="btr-nav-link {{ $is('dashboard/footer-setting*') }}" href="{{ url('dashboard/footer-setting') }}">Sistem</a></li>
            </ul>
        </li>
    </ul>

    <div class="btr-logout">
        <form action="{{ url('') }}/logout" method="post">
            @csrf
            <button type="submit">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H9m4 4v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1"/></svg>
                Logout
            </button>
        </form>
    </div>
</aside>
