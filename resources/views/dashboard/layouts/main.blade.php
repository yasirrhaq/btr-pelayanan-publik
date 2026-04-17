<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} | Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ url(env('APP_URL')) }}/css/trix.css">
    <link href="{{ url(env('APP_URL')) }}/css/admin.css" rel="stylesheet">

    <script type="text/javascript" src="{{ url(env('APP_URL')) }}/js/trix.js"></script>

    <style>
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;
        }

        trix-editor {
            min-height: 200px;
            border: 1.5px solid var(--border-soft);
            border-radius: var(--radius-input);
            padding: 14px;
            background: #FFFFFF;
        }
    </style>
    @stack('head')
</head>

<body class="btr-admin">
    <div class="btr-shell">
        <button type="button" class="btr-sidebar-overlay" aria-label="Tutup menu" onclick="document.body.classList.remove('btr-sidebar-open')"></button>
        @include('dashboard.layouts.sidebar')

        <div class="btr-main">
            @include('dashboard.layouts.header')

            <main class="btr-content">
                @if (session()->has('success'))
                    <div class="btr-alert btr-alert-success">{{ session('success') }}</div>
                @endif

                @if (session()->has('deleteError'))
                    <div class="btr-alert btr-alert-error">{{ session('deleteError') }}</div>
                @endif

                @yield('container')
            </main>
        </div>
    </div>

    <script>
        // Sidebar dropdown toggle
        document.querySelectorAll('.btr-nav-parent').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var children = btn.nextElementSibling;
                btn.classList.toggle('open');
                if (children && children.classList.contains('btr-nav-children')) {
                    children.classList.toggle('open');
                }
            });
        });

        document.querySelectorAll('.btr-nav-link').forEach(function (link) {
            link.addEventListener('click', function () {
                document.body.classList.remove('btr-sidebar-open');
            });
        });

        // Live clock
        function btrTickClock() {
            var el = document.getElementById('btr-clock');
            if (!el) return;
            var d = new Date();
            var pad = function (n) { return n < 10 ? '0' + n : n; };
            el.textContent = pad(d.getHours()) + ':' + pad(d.getMinutes()) + ':' + pad(d.getSeconds());
        }
        setInterval(btrTickClock, 1000);
        btrTickClock();
    </script>
    @stack('js')
</body>

</html>
