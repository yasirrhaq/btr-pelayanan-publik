<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} | Akun Pelanggan</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ url(env('APP_URL')) }}/css/pelanggan.css" rel="stylesheet">
    @stack('head')
</head>

<body class="btr-pelanggan">
    <div class="btr-shell">
        @include('pelanggan.layouts.sidebar')

        <div class="btr-main">
            @include('pelanggan.layouts.header')

            <main class="btr-content">
                @if (session()->has('success'))
                    <div class="btr-alert btr-alert-success">{{ session('success') }}</div>
                @endif
                @if (session()->has('error'))
                    <div class="btr-alert btr-alert-error">{{ session('error') }}</div>
                @endif
                @if (session()->has('info'))
                    <div class="btr-alert btr-alert-info">{{ session('info') }}</div>
                @endif

                @yield('container')
            </main>
        </div>
    </div>

    <script>
        var sidebarToggle = document.getElementById('btr-sidebar-toggle');
        var overlay = document.getElementById('btr-overlay');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                document.body.classList.toggle('btr-sidebar-open');
                if (overlay) overlay.classList.toggle('open');
            });
        }
        if (overlay) {
            overlay.addEventListener('click', function() {
                document.body.classList.remove('btr-sidebar-open');
                overlay.classList.remove('open');
            });
        }

        document.addEventListener('click', function(event) {
            document.querySelectorAll('.btr-topbar-profile-menu[open]').forEach(function(menu) {
                if (!menu.contains(event.target)) {
                    menu.removeAttribute('open');
                }
            });
        });

        function btrTickClock() {
            var el = document.getElementById('btr-clock');
            if (!el) return;
            var d = new Date();
            var pad = function(n) { return n < 10 ? '0' + n : n; };
            el.textContent = pad(d.getHours()) + ':' + pad(d.getMinutes()) + ':' + pad(d.getSeconds());
        }
        setInterval(btrTickClock, 1000);
        btrTickClock();
    </script>
    @stack('js')
</body>

</html>
