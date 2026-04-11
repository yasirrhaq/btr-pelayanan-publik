<div class="header-area">
    <div class="main-header">
        <div class="header-top header-main d-none d-md-block">
            <div class="container">
                <div class="col-xl-12">
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="header-info-left">
                            <ul>
                                <li>
                                    <p class="time" style="color:white"></p>
                                </li>
                                <li>
                            </ul>
                        </div>
                        <div class="header-info-right">
                            <ul class="header-social">
                                <li>
                                    <a href="{{ $urls->find(11)->url }}">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ $urls->find(12)->url }}">
                                        <i class="fab fa-facebook"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ $urls->find(13)->url }}">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-mid d-none d-md-block">
            <div class="container">
                <div class="row d-flex align-items-center">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="header-banner f-left ">
                            <a class="navbar-brand d-flex" href="{{ url('') }}/home">
                                <img class="image-header-logo" src="{{ imageExists(config('app.logo')) }}" />
                                <img src="{{ imageExists(config('app.logoText')) }}" class="logo-text" />
                            </a>
                        </div>
                        <div class="header-banner f-right ">
                            <div id="ytWidget"></div>
                            <script
                                src="https://translate.yandex.net/website-widget/v1/widget.js?widgetId=ytWidget&pageLang=id&widgetTheme=light&&autoMode=false"
                                type="text/javascript"></script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom header-sticky">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-10 col-lg-10 col-md-12 header-flex">
                        <div class="sticky-logo">
                            <a href="{{ url('') }}/berita">
                                <img src="{{ imageExists(config('app.logo')) }}" />
                            </a>
                        </div>
                        <div class="main-menu d-none d-md-block">
                            <nav>
                                <ul id="navigation">
                                    <li><a href="{{ url(env('APP_URL').'/home') }}">Home</a></li>
                                    <li><a href="#" class="dropdown-toggle">Profil</a>
                                        <ul class="submenu">
                                            <li><a href="{{url(env('APP_URL').'/visi-misi')}}">Visi dan Misi</a></li>
                                            <li><a href="{{url(env('APP_URL').'/sejarah')}}">Sejarah</a></li>
                                            <li><a href="{{ url(env('APP_URL')) }}/tugas">Tugas dan Fungsi</a></li>
                                            <li><a href="{{ url(env('APP_URL')) }}/struktur-organisasi">Struktur
                                                    Organisasi</a></li>
                                            <li><a href="{{ url(env('APP_URL')) }}/info-pegawai">Informasi Pegawai</a>
                                            <li><a href="{{ url(env('APP_URL')) }}/fasilitas-balai">Fasilitas Balai</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a href="#" class="dropdown-toggle">Layanan</a>
                                        <ul class="submenu">
                                            <li><a href="{{ url(env('APP_URL')) }}/advis-teknis">Advis Teknis</a></li>
                                            <li><a href="{{ url(env('APP_URL')) }}/pengujian-laboratorium">Pengujian
                                                    Laboratorium</a></li>

                                            <li><a href="{{ $urls->find(3)->url ?? '#' }}" target="_blank">Permohonan
                                                    Data</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#" class="dropdown-toggle">Repository</a>
                                        <ul class="submenu">
                                            <li><a href="https://pustaka.pu.go.id/perpustakaan/balai-rawa"
                                                    target="_blank">e-Perpustakaan</a></li>
                                            <li><a href="{{ $urls->find(4)->url ?? '#' }}" target="_blank">Layanan
                                                    Perpustakaan (Intranet)</a></li>
                                            <li><a href="{{ url(env('APP_URL')) }}/karya-ilmiah">Karya Ilmiah</a></li>
                                            <li><a href="{{ $urls->find(5)->url ?? '#' }}" target="_blank">Rencana
                                                    Strategi</a></li>
                                            <li><a href="{{ $urls->find(10)->url ?? '#' }}" target="_blank">User Manual</a></li>
                                            <li><a href="https://jdih.pu.go.id/" target="_blank">JDIH PU</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#" class="dropdown-toggle">Informasi Publik</a>
                                        <ul class="submenu">
                                            <li><a href="https://eppid.pu.go.id/">e-PPID</a></li>
                                            <li><a href="https://wispu.pu.go.id/">Whistleblowing System</a></li>
                                            <li><a href="https://www.lapor.go.id/">Pengaduan Masyarakat</a></li>
                                            <li><a href="https://gol.itjen.pu.go.id/">Gratifikasi</a></li>
                                            <li><a href="{{ $urls->find(6)->url ?? '#' }}" target="_blank">Survey
                                                    Kepuasaan Pelanggan</a></li>
                                            <li><a href="{{ $urls->find(7)->url ?? '#' }}" target="_blank">Hasil Survey
                                                    Kepuasaan Pelanggan</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#" class="dropdown-toggle">Publikasi</a>
                                        <ul class="submenu">
                                            <li><a href="https://pu.go.id/berita/kanal" target="_blank">Berita
                                                    Kementrian PU</a></li>
                                            <li><a href="https://sda.pu.go.id/berita/index/sda">Berita SDA</a></li>
                                            <li><a href="{{ url(env('APP_URL')) }}/berita">Berita
                                                    {{ config('app.name') }}</a></li>
                                            <li><a href="{{ url(env('APP_URL')) }}/foto">Galeri Foto</a></li>
                                            <li><a href="{{ url(env('APP_URL')) }}/video">Galeri Video</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4">
                        <div class="header-right-btn f-right d-none d-lg-block">
                            @auth
                                <div class="header-right-btn f-right d-none d-lg-block">
                                    <div class="dropdown">
                                        <button class="btn btn-sm dropdown-toggle p-2" type="button" id="dropdownMenu2"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            @if (isset(auth()->user()->foto_profile))
                                                <img src="{{ asset(auth()->user()->foto_profile) }}" width="20"
                                                    height="20" class="rounded-circle normal" aria-hidden="true">
                                            @else
                                                <img src="{{ imageExists(config('app.logo')) }}" width="20"
                                                    height="20" class="rounded-circle" aria-hidden="true">
                                            @endif
                                            {{ auth()->user()->username }}
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                            @if (auth()->user()->is_admin == 0)
                                                <a href="{{ url(env('APP_URL')) }}/profile" class="dropdown-item"
                                                    style="color:#354776">
                                                    <i class="bi bi-box-arrow-in-right"></i>My Profile
                                                </a>
                                            @else
                                                <a href="{{ url(env('APP_URL')) }}/dashboard" class="dropdown-item"
                                                    style="color:#354776">
                                                    <i class="bi bi-box-arrow-in-right"></i>Halaman Admin
                                                </a>
                                            @endif
                                            <form action="{{ url(env('APP_URL')) }}/logout" method="post">
                                                @csrf
                                                <button type="submit" class="dropdown-item"><span class="fa fa-times"
                                                        aria-hidden="true"></span>
                                                    Logout</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle p-2" type="button"
                                        id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Login/Register
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                        <a href="{{ url(env('APP_URL')) }}/login"
                                            class="nav-link {{ request('login') ? 'active' : '' }}"
                                            style="color:#354776">
                                            <i class="bi bi-box-arrow-in-right"></i>Login
                                        </a>
                                        <a href="{{ url(env('APP_URL')) }}/register" class="nav-link" style="color:#354776">
                                            <i class="bi bi-box-arrow-in-right"></i>Register
                                        </a>
                                    </div>
                                </div>

                            @endauth
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mobile_menu d-block d-md-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
