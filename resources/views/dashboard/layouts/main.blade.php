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
                @include('partials.btr.alerts', [
                    'btrAlertMap' => [
                        'success' => 'btr-alert-success',
                        'deleteError' => 'btr-alert-error',
                    ],
                ])

                @yield('container')
            </main>
        </div>
    </div>

    @include('partials.btr.shell-scripts', [
        'btrToggleNavParents' => true,
    ])
    @stack('js')
</body>

</html>
