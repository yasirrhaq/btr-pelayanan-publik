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

    <!-- floating live chat -->
    <!-- <button class="open-button rounded-pill" onclick="openForm()">Chat</button>

<div class="chat-popup" id="myForm">
  <form action="/action_page.php" class="form-container">
    <h1>Chat</h1>

    <label for="msg"><b>Message</b></label>
    <textarea placeholder="Type message.." name="msg" required></textarea>

    <button type="submit" class="btn" style="background-color:#354776;">Send</button>
    <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
  </form>
</div> -->
    <header>
        @include('frontend.partials.nav', ['urls' => \App\Models\UrlLayanan::all()])
    </header>
    <main>
        @yield('container')
    </main>
    <a href="{{ \App\Models\UrlLayanan::find(8)->url ?? '#' }}" class="float" target="_blank">
        <!-- <i class="fa fa-plus my-float"></i> -->
        <img src="{{ asset('assets/livechat.png') }}" width="50%" height="100" alt="">
        <p class="card-home text-white p-1">Tanya Kami 24 Jam</p>
    </a>
    @include('frontend.partials.footerNew', ['sosmed' => \App\Models\UrlLayanan::all(), 'footer_setting' => \App\Models\FooterSetting::all()->first()])

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
        const time = document.querySelector(".time");
        const d = new Date(Date.now());
        let month = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober",
            "November", "Desember"
        ];
        let tanggal = d.getDate();
        let bulan = d.getMonth();
        let jam = d.getHours() < 10 ? '0' + d.getHours() : d.getHours();
        let menit = d.getMinutes() < 10 ? "0" + d.getMinutes() : d.getMinutes();
        let detik = d.getSeconds() < 10 ? "0" + d.getSeconds() : d.getSeconds();
        time.textContent = `${tanggal} ${month[bulan]} ${d.getFullYear()} | ${jam}:${menit}:${detik} WITA`
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
