@php
    $user = auth()->user();
    $roleLabel = $user && method_exists($user, 'getRoleNames') && $user->getRoleNames()->isNotEmpty()
        ? \Illuminate\Support\Str::of($user->getRoleNames()->first())->replace('-', ' ')->title()
        : 'Admin';
@endphp

@include('partials.btr.topbar', [
    'topbarRoleLabel' => $roleLabel,
    'topbarInitial' => $user ? strtoupper(substr($user->name, 0, 1)) : 'A',
    'topbarLinks' => [
        ['label' => 'Profil', 'href' => url('/profile')],
        ['label' => 'Ganti Password', 'href' => url('/profile/password')],
        ['label' => 'Logout', 'href' => url('/logout'), 'type' => 'form', 'danger' => true],
    ],
])
