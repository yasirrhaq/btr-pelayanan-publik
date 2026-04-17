<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} | Profil Pelanggan</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ url(env('APP_URL')) }}/css/pelanggan.css" rel="stylesheet">
    <style>
        .btr-profile-shell .btr-page-title {
            margin-bottom: 18px;
        }
        .btr-profile-card {
            background: #fff;
            border-radius: 24px;
            box-shadow: var(--shadow-card);
            padding: 32px 28px 34px;
        }
        .btr-profile-grid {
            display: grid;
            grid-template-columns: 150px 20px minmax(0, 1fr);
            gap: 18px 18px;
            align-items: center;
        }
        .btr-profile-label {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-body);
        }
        .btr-profile-sep {
            text-align: center;
            font-weight: 600;
            color: #94A3B8;
        }
        .btr-profile-value {
            font-size: 14px;
            color: #111827;
            min-width: 0;
        }
        .btr-profile-pill {
            display: inline-flex;
            align-items: center;
            min-height: 40px;
            padding: 8px 14px;
            border-radius: 14px;
            background: #F8FAFC;
            border: 1px solid #EEF2F7;
            width: min(100%, 540px);
            line-height: 1.5;
            word-break: break-word;
        }
        .btr-profile-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 34px;
        }
        .btr-profile-actions .btr-btn {
            min-width: 132px;
            justify-content: center;
        }
        .btr-profile-password-mask {
            letter-spacing: 0.18em;
            font-weight: 600;
        }
        .btr-form-shell {
            max-width: 760px;
        }
        .btr-form-card {
            background: #fff;
            border-radius: 24px;
            box-shadow: var(--shadow-card);
            padding: 28px;
        }
        .btr-form-heading {
            margin: 0 0 24px;
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
        }
        .btr-form-grid {
            display: grid;
            gap: 18px;
        }
        .btr-form-error {
            margin-top: 8px;
            font-size: 12px;
            color: var(--danger-red);
        }
        @media (max-width: 900px) {
            .btr-profile-grid {
                grid-template-columns: 1fr;
                gap: 8px;
            }
            .btr-profile-sep {
                display: none;
            }
            .btr-profile-label {
                font-size: 13px;
                color: var(--text-muted);
            }
            .btr-profile-value {
                margin-bottom: 8px;
            }
            .btr-profile-pill {
                width: 100%;
            }
            .btr-profile-card,
            .btr-form-card {
                padding: 22px 18px;
            }
        }
    </style>
    @stack('head')
</head>

<body class="btr-pelanggan btr-profile-shell">
    @include('profile.layouts.header')

    <div class="btr-shell">
        @include('profile.layouts.sidebar')

        <div class="btr-main">
            <main class="btr-content">
                @if (session()->has('success'))
                    <div class="btr-alert btr-alert-success">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="btr-alert btr-alert-error">{{ $errors->first() }}</div>
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
