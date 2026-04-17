@php
    $is = function ($pattern) { return request()->is($pattern) ? 'active' : ''; };
@endphp

<div class="btr-overlay" id="btr-overlay"></div>

<aside class="btr-sidebar">
    <a href="{{ url('/profile') }}" class="btr-logo">
        <span class="btr-logo-mark">
            <img src="{{ imageExists('assets/logo.png') }}" alt="Balai Teknik Rawa">
        </span>
        <span class="btr-logo-text">BALAI TEKNIK RAWA</span>
    </a>

    <ul class="btr-nav">
        <li class="btr-nav-item">
            <a class="btr-nav-link {{ $is('profile') && !request()->is('profile/*') ? 'active' : '' }}" href="{{ url('/profile') }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10h14V10"/></svg>
                Profil Pelanggan
            </a>
        </li>
        <li class="btr-nav-item">
            <a class="btr-nav-link {{ $is('profile/password*') }}" href="{{ url('/profile/password') }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="10" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M7 11V8a5 5 0 0 1 10 0v3"/></svg>
                Ganti Password
            </a>
        </li>
    </ul>

    <div class="btr-logout">
        <form action="{{ url('/logout') }}" method="post">
            @csrf
            <button type="submit" class="btr-logout-btn">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v9"/><path stroke-linecap="round" stroke-linejoin="round" d="M8.5 5.5a8 8 0 1 0 7 0"/></svg>
                Logout
            </button>
        </form>
    </div>
</aside>
