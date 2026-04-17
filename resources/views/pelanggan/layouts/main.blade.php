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
                @include('partials.btr.alerts')

                @yield('container')
            </main>
        </div>
    </div>

    @include('partials.btr.shell-scripts', [
        'btrSidebarToggleId' => 'btr-sidebar-toggle',
        'btrOverlayId' => 'btr-overlay',
    ])
    @stack('js')
</body>

</html>
