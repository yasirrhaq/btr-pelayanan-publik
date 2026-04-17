@php
    $monthsId = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $today = now();
    $dateStr = $today->day . ' ' . $monthsId[(int) $today->month] . ' ' . $today->year;
    $user = auth()->user();
    $initial = $user ? strtoupper(substr($user->name, 0, 1)) : 'P';
    $profilePhoto = $user && !empty($user->foto_profile) ? imageExists($user->foto_profile) : null;
@endphp

<header class="btr-topbar">
    <div class="btr-topbar-left">
        <button type="button" class="btr-sidebar-toggle" id="btr-sidebar-toggle" aria-label="Toggle menu">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <div class="btr-topbar-item">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M16 2v4M8 2v4M3 10h18"/></svg>
            {{ $dateStr }}
        </div>
        <div class="btr-topbar-item">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
            <span id="btr-clock">--:--:--</span>
        </div>
    </div>

    <details class="btr-topbar-profile-menu">
        <summary class="btr-topbar-profile">
            <div class="btr-topbar-user">
                <div class="name">{{ $user->name ?? 'Pelanggan' }}</div>
                <div class="role">Akun Pelanggan</div>
            </div>
            <div class="btr-topbar-avatar">
                @if ($profilePhoto)
                    <img src="{{ $profilePhoto }}" alt="{{ $user->name ?? 'Pelanggan' }}">
                @else
                    {{ $initial }}
                @endif
            </div>
        </summary>

        <div class="btr-topbar-dropdown">
            <a href="{{ url('/pelanggan') }}" class="btr-topbar-dropdown-link">Dashboard Pelanggan</a>
            <a href="{{ url('/profile/password') }}" class="btr-topbar-dropdown-link">Ganti Password</a>
            <form action="{{ url('/logout') }}" method="post">
                @csrf
                <button type="submit" class="btr-topbar-dropdown-link danger">Logout</button>
            </form>
        </div>
    </details>
</header>
