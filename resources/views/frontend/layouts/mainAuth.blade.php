<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title', 'Autentikasi') — {{ config('app.name', 'Balai Teknik Rawa') }}</title>
    <link rel="icon" href="{{ asset('assets/logo.png') }}" type="image/png">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        btr:        '#354776',
                        'btr-dark': '#2a3a61',
                        'btr-deep': '#1e2d4f',
                        'btr-gold': '#F5A623',
                        'btr-gold-dark': '#d4891a',
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    backgroundImage: {
                        'btr-pattern': "url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\")",
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0', transform: 'translateY(12px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.4s ease-out both',
                    },
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        [x-cloak] { display: none !important; }

        /* auth-input — written in plain CSS because Tailwind CDN does not process @apply */
        .auth-input {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            border: 2px solid #9ca3af;   /* gray-400 — always visible */
            background-color: #ffffff;
            color: #1f2937;
            font-size: 0.875rem;
            line-height: 1.25rem;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .auth-input::placeholder {
            color: #6b7280;              /* gray-500 */
        }
        .auth-input:focus {
            border-color: #354776;       /* BTR navy */
            box-shadow: 0 0 0 3px rgba(53, 71, 118, 0.18);
        }
        .auth-input.is-invalid {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15);
        }

        /* Captcha image consistent sizing */
        .captcha-img img {
            border-radius: 0.5rem;
            height: 46px;
            width: auto;
        }

        /* Scrollbar thin for register page */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #354776; border-radius: 4px; }
    </style>

    @yield('head')
</head>
<body class="min-h-screen bg-gray-50 font-sans antialiased text-gray-800">

    @yield('auth-content')

    @yield('scripts')
</body>
</html>
