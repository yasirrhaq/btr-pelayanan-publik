<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Balai Teknik Rawa') }}</title>
    <link rel="icon" href="{{ asset('assets/logo.png') }}" type="image/png">

    <!-- Tailwind CSS CDN -->
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

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        [x-cloak] { display: none !important; }

        /* Ticker animation */
        .ticker-wrap {
            overflow: hidden;
            position: relative;
        }
        .ticker-track {
            display: flex;
            white-space: nowrap;
            animation: ticker-scroll 35s linear infinite;
        }
        .ticker-wrap:hover .ticker-track {
            animation-play-state: paused;
        }
        @keyframes ticker-scroll {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* Hero carousel transitions */
        .slide-enter { opacity: 0; }
        .slide-active { opacity: 1; transition: opacity 0.6s ease; }

        /* Smooth dropdown */
        .nav-dropdown { display: none; }
        .nav-item:hover .nav-dropdown { display: block; }

        /* Scrollbar hide */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    @yield('head')
</head>
<body class="font-sans bg-white text-gray-800 antialiased">

    @yield('content')

    @yield('scripts')
</body>
</html>
