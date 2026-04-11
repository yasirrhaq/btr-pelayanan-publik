<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{url('')}}/">PU</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" aria-current="page"
                        href="{{url('')}}/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" aria-current="page"
                        href="{{url('')}}/about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('berita') ? 'active' : '' }}" aria-current="page"
                        href="{{url('')}}/berita">Berita</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('categories') ? 'active' : '' }}" aria-current="page"
                        href="{{url('')}}/categories">Kategori</a>
                </li>
                <li class="nav-item">
                    <div id="ytWidget"></div>
                    <script
                        src="https://translate.yandex.net/website-widget/v1/widget.js?widgetId=ytWidget&pageLang=id&widgetTheme=light&&autoMode=false"
                        type="text/javascript"></script>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            @if (Auth::user()->foto_profile)
                                <img src="{{  asset(  Auth::user()->foto_profile) }}" width="40"
                                    height="40" class="rounded-circle">
                            @else
                                <i class="bi bi-person-circle"></i>
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                            @if (Auth::user()->is_admin == 0)
                                <li>
                                    <a class="dropdown-item" href="{{url('')}}/profile"> <i class="bi bi-person-circle"></i> My
                                        Profil</a>
                                </li>
                            @else
                                <li>
                                    <a class="dropdown-item" href="{{url('')}}/dashboard"> <i class="bi bi-person-circle"></i> Halaman Admin</a>
                                </li>
                            @endif
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{url('')}}/logout" method="post">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i>
                                        Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{url('')}}/login" class="nav-link {{ request()->is('login') ? 'active' : '' }}"><i
                                class="bi bi-box-arrow-in-right"></i>Login</a>
                    </li>
                @endauth
            </ul>

        </div>
    </div>
</nav>
