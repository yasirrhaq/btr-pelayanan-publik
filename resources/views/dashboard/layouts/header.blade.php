@php
    $monthsId = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $today = now();
    $dateStr = $today->day . ' ' . $monthsId[(int) $today->month] . ' ' . $today->year;
    $user = auth()->user();
    $initial = $user ? strtoupper(substr($user->name, 0, 1)) : 'A';
    $roleLabel = $user && method_exists($user, 'getRoleNames') && $user->getRoleNames()->isNotEmpty()
        ? \Illuminate\Support\Str::of($user->getRoleNames()->first())->replace('-', ' ')->title()
        : 'Admin';
@endphp

<header class="btr-topbar">
    <div class="btr-topbar-left">
        <button type="button" class="btr-sidebar-toggle" aria-label="Toggle menu" onclick="document.body.classList.toggle('btr-sidebar-open')">
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

    <div class="btr-topbar-right">
        <div class="btr-topbar-user">
            <div class="name">{{ $user->name ?? 'Admin' }}</div>
            <div class="role">{{ $roleLabel }}</div>
        </div>
        <div class="btr-topbar-avatar">{{ $initial }}</div>
    </div>
</header>
