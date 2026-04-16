@php
    $is = function ($pattern) { return request()->is($pattern) ? 'active' : ''; };
@endphp

<aside class="btr-sidebar">
    <a href="{{ route('admin.layanan.dashboard') }}" class="btr-logo">
        <span class="btr-logo-mark">B</span>
        BALAI TEKNIK RAWA
    </a>

    <ul class="btr-nav">
        <li class="btr-nav-item">
            <a class="btr-nav-link {{ $is('dashboard/layanan') && !request()->is('dashboard/layanan/*') ? 'active' : '' }}" href="{{ route('admin.layanan.dashboard') }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10h14V10"/></svg>
                Dashboard
            </a>
        </li>
        <li class="btr-nav-item">
            <a class="btr-nav-link {{ $is('dashboard/layanan/permohonan*') }}" href="{{ route('admin.layanan.permohonan.index') }}?jenis_layanan_id=1">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
                Advis Teknik
            </a>
        </li>
        <li class="btr-nav-item">
            <a class="btr-nav-link" href="{{ route('admin.layanan.permohonan.index') }}?jenis_layanan_id=2">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c.251.023.501.05.75.082M9.75 3.104a49.656 49.656 0 0 0-3.5 0m7.5 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c-.251.023-.501.05-.75.082m.75-.082a49.656 49.656 0 0 1 3.5 0m-3.5 0V1.5m0 0h3.75M14.25 1.5H10.5m8.25 12.75v3a2.25 2.25 0 0 1-2.25 2.25H7.5a2.25 2.25 0 0 1-2.25-2.25v-3"/></svg>
                Laboratorium
            </a>
        </li>
        <li class="btr-nav-item">
            <a class="btr-nav-link" href="{{ route('admin.layanan.permohonan.index') }}?jenis_layanan_id=3">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75"/></svg>
                Data dan Informasi
            </a>
        </li>
        <li class="btr-nav-item">
            <a class="btr-nav-link" href="{{ route('admin.layanan.permohonan.index') }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75z"/></svg>
                Layanan Lainnya
            </a>
        </li>
        <li class="btr-nav-item">
            <a class="btr-nav-link" href="{{ url('dashboard/layanan') }}#survei">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.563.563 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.563.563 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5z"/></svg>
                Survei Kepuasan
            </a>
        </li>
        <li class="btr-nav-item">
            <a class="btr-nav-link" href="{{ url('dashboard/layanan') }}#pelanggan">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0z"/></svg>
                Data Pelanggan
            </a>
        </li>
        <li class="btr-nav-item">
            <a class="btr-nav-link" href="{{ url('dashboard/layanan') }}#dokumen-final">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9z"/></svg>
                Dokumen Final
            </a>
        </li>
        <li class="btr-nav-item">
            <a class="btr-nav-link" href="{{ url('dashboard/layanan') }}#notifikasi">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"/></svg>
                Notifikasi
            </a>
        </li>
        <li class="btr-nav-item">
            <a class="btr-nav-link" href="{{ url('dashboard/layanan') }}#bantuan">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3m.08 4h.01"/></svg>
                Bantuan
            </a>
        </li>
    </ul>

    <div class="btr-logout">
        <form action="{{ url('') }}/logout" method="post">
            @csrf
            <button type="submit">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H9m4 4v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1"/></svg>
                Logout
            </button>
        </form>
    </div>
</aside>
