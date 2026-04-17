@php $user = auth()->user(); @endphp

@include('partials.btr.topbar', [
    'topbarRoleLabel' => 'Akun Pelanggan',
    'topbarInitial' => $user ? strtoupper(substr($user->name, 0, 1)) : 'P',
    'topbarToggleId' => 'btr-sidebar-toggle',
    'topbarLinks' => [
        ['label' => 'Profil Saya', 'href' => route('pelanggan.profil')],
        ['label' => 'Ganti Password', 'href' => route('pelanggan.profil.password')],
        ['label' => 'Bantuan', 'href' => route('pelanggan.bantuan')],
        ['label' => 'Logout', 'href' => url('/logout'), 'type' => 'form', 'danger' => true],
    ],
])
