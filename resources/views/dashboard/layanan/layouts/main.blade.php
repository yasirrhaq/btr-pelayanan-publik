<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} | Admin Layanan</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ url(env('APP_URL')) }}/css/admin.css" rel="stylesheet">
    @stack('head')
</head>

<body class="btr-admin">
    <div class="btr-shell">
        @include('dashboard.layanan.layouts.sidebar')

        <div class="btr-main">
            @include('dashboard.layouts.header')

            <main class="btr-content">
                @if (session()->has('success'))
                    <div class="btr-alert btr-alert-success">{{ session('success') }}</div>
                @endif
                @if (session()->has('error'))
                    <div class="btr-alert btr-alert-error">{{ session('error') }}</div>
                @endif

                @yield('container')
            </main>
        </div>
    </div>

    <script>
        document.querySelectorAll('.btr-nav-parent').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var children = btn.nextElementSibling;
                btn.classList.toggle('open');
                if (children && children.classList.contains('btr-nav-children')) {
                    children.classList.toggle('open');
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
