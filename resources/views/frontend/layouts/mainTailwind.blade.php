<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Balai Teknik Rawa') }}</title>
    <link rel="icon" href="{{ asset('assets/logo.png') }}" type="image/png">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'btr': '#354776',
                        'btr-dark': '#2a3a61',
                        'btr-yellow': '#F5A623',
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Legacy Bootstrap 5 for pages still using Bootstrap grid/components --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/frontend/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/tugas.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/navbar.css') }}">

    <style>
        [x-cloak] { display: none !important; }

        .ticker-wrap { overflow: hidden; position: relative; }
        .ticker-track {
            display: flex;
            white-space: nowrap;
            animation: ticker-scroll 35s linear infinite;
        }
        .ticker-wrap:hover .ticker-track { animation-play-state: paused; }
        @keyframes ticker-scroll {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .slide-enter { opacity: 0; }
        .slide-active { opacity: 1; transition: opacity 0.6s ease; }

        .nav-dropdown { display: none; }
        .nav-item:hover .nav-dropdown { display: block; }

        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    @yield('customCss')
    @yield('head')
</head>
<body class="font-sans bg-white text-gray-800 antialiased">

    @hasSection('content')
        @yield('content')
    @else
        @include('frontend.partials.headerTailwind')
        <main>
            @yield('container')
        </main>
        @include('frontend.partials.footerTailwind')
        @include('frontend.partials.floatingKaura')
    @endif

    <script>
        (function () {
            const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            function tick() {
                const d = new Date();
                const el = document.getElementById('topbar-time');
                if (el) el.textContent = d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear() + '  |  ' +
                    String(d.getHours()).padStart(2,'0') + ':' + String(d.getMinutes()).padStart(2,'0') + ':' + String(d.getSeconds()).padStart(2,'0');
            }
            tick();
            setInterval(tick, 1000);
            const yr = document.getElementById('copy-year');
            if (yr) yr.textContent = new Date().getFullYear();
        })();
    </script>

    <script src="{{ url(asset('js/vendor/jquery-1.12.4.min.js')) }}"></script>

    {{-- Legacy Bootstrap bundle for components that need it --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
    @yield('customJs')
    @stack('js')
</body>
</html>
