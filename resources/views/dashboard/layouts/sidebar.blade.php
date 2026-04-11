<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item"> 
                <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" aria-current="page"
                     href="{{ url('dashboard') }}">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard/posts*') ? 'active' : '' }}"
                    href="{{ url('dashboard/posts') }}">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Berita
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard/categories*') ? 'active' : '' }}"
                    href="{{ url('dashboard/categories') }}">
                    <span data-feather="grid" class="align-text-bottom"></span>
                    Kategori
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard/galeri/foto-video*') ? 'active' : '' }}"
                    href="{{ url('dashboard/galeri/foto-video') }}">
                    <span data-feather="image" class="align-text-bottom"></span>
                    Galeri Foto
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard/info-pegawai*') ? 'active' : '' }}"
                    href="{{ url('dashboard/info-pegawai') }}">
                    <span data-feather="image" class="align-text-bottom"></span>
                    Informasi Pegawai
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard/struktur-organisasi*') ? 'active' : '' }}"
                    href="{{ url('dashboard/struktur-organisasi') }}">
                    <span data-feather="image" class="align-text-bottom"></span>
                    Struktur Organisasi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard/fasilitas-balai*') ? 'active' : '' }}"
                    href="{{ url('dashboard/fasilitas-balai') }}">
                    <span data-feather="image" class="align-text-bottom"></span>
                    Fasilitas Balai
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard/foto-home*') ? 'active' : '' }}"
                    href="{{ url('dashboard/foto-home') }}">
                    <span data-feather="image" class="align-text-bottom"></span>
                    Foto Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard/foto-layanan*') ? 'active' : '' }}"
                    href="{{ url('dashboard/foto-layanan') }}">
                    <span data-feather="image" class="align-text-bottom"></span>
                    Foto dan Deskripsi Layanan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard/situs-terkait*') ? 'active' : '' }}"
                    href="{{ url('dashboard/situs-terkait') }}">
                    <span data-feather="image" class="align-text-bottom"></span>
                    Situs Terkait
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard/karya-ilmiah*') ? 'active' : '' }}"
                    href="{{ url('dashboard/karya-ilmiah') }}">
                    <span data-feather="archive" class="align-text-bottom"></span>
                    Karya Ilmiah
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard/profil-singkat*') ? 'active' : '' }}"
                    href="{{ url('dashboard/profil-singkat') }}">
                    <span data-feather="type" class="align-text-bottom"></span>
                    Profil Singkat
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard/status-layanan*') ? 'active' : '' }}"
                    href="{{ url('dashboard/status-layanan') }}">
                    <span data-feather="user" class="align-text-bottom"></span>
                    Status Layanan User
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard/url-layanan*') ? 'active' : '' }}"
                    href="{{ url('dashboard/url-layanan') }}">
                    <span data-feather="link" class="align-text-bottom"></span>
                    Url Layanan
                </a>
            </li>
            @foreach (globalTipeLanding() as $landing_page_tipe)
                <li class="nav-item">
                    <a class="nav-link {{ (request()->type ?? null) == $landing_page_tipe->slug ? 'active' : '' }}"
                         href="{{ url('dashboard/landing-page') }}?type={{ $landing_page_tipe->slug }}">
                        <span data-feather="link" class="align-text-bottom"></span>
                        {{ $landing_page_tipe->title }}
                    </a>
                </li>
            @endforeach
            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard/footer-setting*') ? 'active' : '' }}"
                    href="{{ url('dashboard/footer-setting') }}">
                    <span data-feather="settings" class="align-text-bottom"></span>
                    Footer Settings
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard/settings*') ? 'active' : '' }}"
                    href="{{ url('dashboard/settings') }}">
                    <span data-feather="settings" class="align-text-bottom"></span>
                    Settings
                </a>
            </li>
        </ul>
    </div>
</nav>
