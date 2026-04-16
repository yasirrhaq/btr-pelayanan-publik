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
        // Sidebar mobile toggle
        var sidebarToggle = document.getElementById('btr-sidebar-toggle');
        var sidebar = document.querySelector('.btr-sidebar');
        var overlay = document.getElementById('btr-overlay');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('open');
            });
        }
        if (overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('open');
                overlay.classList.remove('open');
            });
        }

        // Live clock
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
