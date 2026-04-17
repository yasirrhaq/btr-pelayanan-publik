@php
    $is = function ($pattern) { return request()->is($pattern) ? 'active' : ''; };
@endphp

<div class="btr-overlay" id="btr-overlay"></div>

<aside class="btr-sidebar">
    <a href="{{ route('pelanggan.dashboard') }}" class="btr-logo">
        <span class="btr-logo-mark">
            <img src="{{ imageExists('assets/logo.png') }}" alt="Balai Teknik Rawa">
        </span>
        <span class="btr-logo-text">BALAI TEKNIK RAWA</span>
    </a>

    <ul class="btr-nav">
        <li class="btr-nav-item">
            <a class="btr-nav-link {{ $is('pelanggan') && !request()->is('pelanggan/*') ? 'active' : '' }}" href="{{ route('pelanggan.dashboard') }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10h14V10"/></svg>
                Dashboard
            </a>
        </li>
        <li class="btr-nav-item">
            <a class="btr-nav-link {{ $is('pelanggan/permohonan*') }}" href="{{ route('pelanggan.permohonan.index') }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-1.414-9.414a2 2 0 1 1 2.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Ajukan Permohonan
            </a>
        </li>
        <li class="btr-nav-item">
            <a class="btr-nav-link {{ $is('pelanggan/tracking*') }}" href="{{ route('pelanggan.tracking') }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2m-6 9l2 2 4-4"/></svg>
                Tracking Layanan
            </a>
        </li>
        <li class="btr-nav-item">
            <a class="btr-nav-link {{ $is('pelanggan/pembayaran*') }}" href="{{ route('pelanggan.pembayaran.index') }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2m2 4h10a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2zm7-5a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/></svg>
                Pembayaran
            </a>
        </li>
        <li class="btr-nav-item">
            <a class="btr-nav-link {{ $is('pelanggan/dokumen*') }}" href="{{ route('pelanggan.dokumen.index') }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 0 0 2-2V9.414a1 1 0 0 0-.293-.707l-5.414-5.414A1 1 0 0 0 12.586 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2z"/></svg>
                Dokumen
            </a>
        </li>
        <li class="btr-nav-item">
            <a class="btr-nav-link {{ $is('pelanggan/notifikasi*') }}" href="{{ route('pelanggan.notifikasi.index') }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6.002 6.002 0 0 0-4-5.659V5a2 2 0 1 0-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9"/></svg>
                Notifikasi
                @php $unread = auth()->user()->unreadNotifikasi->count(); @endphp
                @if($unread > 0)
                    <span class="btr-badge">{{ $unread }}</span>
                @endif
            </a>
        </li>
        <li class="btr-nav-item">
            <a class="btr-nav-link {{ $is('pelanggan/profil*') }}" href="{{ route('pelanggan.profil') }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7z"/></svg>
                Profil Pelanggan
            </a>
        </li>
        <li class="btr-nav-item">
            <a class="btr-nav-link {{ $is('pelanggan/bantuan*') }}" href="{{ route('pelanggan.bantuan') }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3m.08 4h.01"/></svg>
                Bantuan
            </a>
        </li>
    </ul>

    <div class="btr-logout">
        <form action="{{ url('') }}/logout" method="post">
            @csrf
            <button type="submit" class="btr-logout-btn">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v9"/><path stroke-linecap="round" stroke-linejoin="round" d="M8.5 5.5a8 8 0 1 0 7 0"/></svg>
                Logout
            </button>
        </form>
    </div>
</aside>
