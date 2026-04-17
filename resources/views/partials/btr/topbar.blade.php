@php
    $monthsId = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $today = now();
    $dateStr = $today->day . ' ' . $monthsId[(int) $today->month] . ' ' . $today->year;
    $user = auth()->user();
    $topbarUserName = $topbarUserName ?? ($user->name ?? 'Pengguna');
    $topbarRoleLabel = $topbarRoleLabel ?? 'Akun';
    $topbarInitial = $topbarInitial ?? ($user ? strtoupper(substr($user->name, 0, 1)) : 'U');
    $topbarProfilePhoto = $topbarProfilePhoto ?? ($user && !empty($user->foto_profile) ? imageExists($user->foto_profile) : null);
    $topbarToggleId = $topbarToggleId ?? null;
    $topbarLinks = $topbarLinks ?? [];
@endphp

<header class="btr-topbar">
    <div class="btr-topbar-left">
        <button
            type="button"
            class="btr-sidebar-toggle"
            @if ($topbarToggleId) id="{{ $topbarToggleId }}" @else aria-label="Toggle menu" onclick="document.body.classList.toggle('btr-sidebar-open')" @endif
        >
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
                <div class="name">{{ $topbarUserName }}</div>
                <div class="role">{{ $topbarRoleLabel }}</div>
            </div>
            <div class="btr-topbar-avatar">
                @if ($topbarProfilePhoto)
                    <img src="{{ $topbarProfilePhoto }}" alt="{{ $topbarUserName }}">
                @else
                    {{ $topbarInitial }}
                @endif
            </div>
        </summary>

        <div class="btr-topbar-dropdown">
            @foreach ($topbarLinks as $link)
                @if (($link['type'] ?? 'link') === 'form')
                    <form action="{{ $link['href'] }}" method="{{ $link['method'] ?? 'post' }}">
                        @csrf
                        @if (strtolower($link['method'] ?? 'post') !== 'post')
                            @method($link['method'])
                        @endif
                        <button type="submit" class="btr-topbar-dropdown-link {{ !empty($link['danger']) ? 'danger' : '' }}">{{ $link['label'] }}</button>
                    </form>
                @else
                    <a href="{{ $link['href'] }}" class="btr-topbar-dropdown-link {{ !empty($link['danger']) ? 'danger' : '' }}">{{ $link['label'] }}</a>
                @endif
            @endforeach
        </div>
    </details>
</header>
