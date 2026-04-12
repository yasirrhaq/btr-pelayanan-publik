<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> {{ config('app.name') }} </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="manifest" href="site.webmanifest">
    <link rel="icon" href="{{ asset('assets/logo.png') }}" type="image/icon type">

    {{-- Tailwind (for new header/footer/kaura partials) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { 'btr': '#354776', 'btr-dark': '#2a3a61', 'btr-yellow': '#F5A623' },
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] }
                }
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        .nav-dropdown { display: none; }
        .nav-item:hover .nav-dropdown { display: block; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    <!-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}"> -->

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ticker-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

    <!-- css akmal -->
    <link rel="stylesheet" href="{{ asset('css/frontend/tugas.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/index.css') }}">

    <!-- new css -->
    <link rel="stylesheet" href="{{ asset('css/frontend/floating.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/copyright.css') }}">
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    {{-- <style>
        span.selection .select2-selection {
            display: none;
        }
    </style> --}}

    @yield('customCss')
</head>

<body>

    <!-- Preloader Start -->
    <!-- <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="{{ asset('assets/logoPupr.png') }}" alt="">
                </div>
            </div>
        </div>
    </div> -->

    @include('frontend.partials.headerTailwind')
    <main>
        @yield('container')
    </main>
    @include('frontend.partials.footerTailwind')
    @include('frontend.partials.floatingKaura')

    <!-- JS here -->

    <!-- All JS Custom Plugins Link Here here -->
    <script src="{{ url(asset('js/vendor/modernizr-3.5.0.min.js')) }}"></script>
    <!-- Jquery, Popper, Bootstrap -->
    <script src="{{ url(asset('js/vendor/jquery-1.12.4.min.js')) }}"></script>
    <script src="{{ url(asset('js/popper.min.js')) }}"></script>
    <script src="{{ url(asset('js/bootstrap.min.js')) }}"></script>
    <!-- Jquery Mobile Menu -->
    <script src="{{ url(asset('js/jquery.slicknav.min.js')) }}"></script>

    <!-- Jquery Slick , Owl-Carousel Plugins -->
    <script src="{{ url(asset('js/owl.carousel.min.js')) }}"></script>
    <script src="{{ url(asset('js/slick.min.js')) }}"></script>
    <!-- Date Picker -->
    <script src="{{ url(asset('js/gijgo.min.js')) }}"></script>
    <!-- One Page, Animated-HeadLin -->
    <script src="{{ url(asset('js/wow.min.js')) }}"></script>
    <script src="{{ url(asset('js/animated.headline.js')) }}"></script>
    <script src="{{ url(asset('js/jquery.magnific-popup.js')) }}"></script>

    <!-- Breaking New Pluging -->
    <script src="{{ url(asset('js/jquery.ticker.js')) }}"></script>
    <script src="{{ url(asset('js/site.js')) }}"></script>

    <!-- Scrollup, nice-select, sticky -->
    <script src="{{ url(asset('js/jquery.scrollUp.min.js')) }}"></script>
    <script src="{{ url(asset('js/jquery.nice-select.min.js')) }}"></script>
    <script src="{{ url(asset('js/jquery.sticky.js')) }}"></script>

    <!-- contact js -->
    <script src="{{ url(asset('js/contact.js')) }}"></script>
    <script src="{{ url(asset('js/jquery.form.js')) }}"></script>
    <script src="{{ url(asset('js/jquery.validate.min.js')) }}"></script>
    <script src="{{ url(asset('js/mail-script.js')) }}"></script>
    <script src="{{ url(asset('js/jquery.ajaxchimp.min.js')) }}"></script>

    <!-- Jquery Plugins, main Jquery -->
    <script src="{{ url(asset('js/plugins.js')) }}"></script>
    <script src="{{ url(asset('js/main.js')) }}"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    @yield('customJs')
    <script>
        $(document).ready(function() {
            AOS.refresh();

        });


        AOS.init({
            duration: 1000
        });
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
    <script>
        function openForm() {
            document.getElementById("myForm").style.display = "block";
        }

        function closeForm() {
            document.getElementById("myForm").style.display = "none";
        }

        var BASE_URL = `{{ url('') }}`
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    </script>
    @stack('js')
</body>

</html>
