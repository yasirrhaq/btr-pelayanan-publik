@extends('frontend.layouts.mainNew')

@section('customCss')
    <link rel="stylesheet" href="{{ asset('css/logo-carousel-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive/index.css') }}">
@endsection

@section('container')
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100 container-carousel"
                    src="{{  asset(  $foto_home->find(1)->path_image ?? null) }}" alt="First slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5 class="title-carousel" style="color: #FFFFFF;">{{ $foto_home->find(1)->title ?? null }}</h5>
                    <p class="text-carousel" style="color: #FFFFFF;">{{ $foto_home->find(1)->deskripsi ?? null }}</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100 container-carousel"
                    src="{{  asset(  $foto_home->find(2)->path_image ?? null) }}" alt="Second slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5 class="title-carousel" style="color: #FFFFFF;">{{ $foto_home->find(2)->title ?? null}}</h5>
                    <p class="text-carousel" style="color: #FFFFFF;">{{ $foto_home->find(2)->deskripsi ?? null }}</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100 container-carousel"
                    src="{{  asset(  $foto_home->find(3)->path_image ?? null) }}" alt="Third slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5 class="title-carousel" style="color: #FFFFFF;">{{ $foto_home->find(3)->title ?? null }}</h5>
                    <p class="text-carousel" style="color: #FFFFFF;">{{ $foto_home->find(3)->deskripsi ?? null }}</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="about-right mb-45">
                <div class="mb-30 pt-15 text-center">
                    <h3 class="title-tugas">Pelayanan Kami</h3>
                    <div class="d-flex justify-content-center">
                        <div class="divider-title-tugas"></div>
                    </div>
                </div>
                <div class="container container-pelayanan-kami" data-aos="fade-up">
                    <div class="row">
                        <div class="col-12">
                            <div class="card-content-two">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-4 d-flex justify-content-center">
                                            <img src="{{ asset('assets/technical-support.png') }}"
                                                class="image-card-index" />
                                            <a href="{{ url('') }}/advis-teknis">
                                                <p class="text-icon-pelayanan">Advis Teknis</p>
                                            </a>
                                        </div>
                                        <div class="col-sm-4 d-flex justify-content-center">
                                            <img src="{{ asset('assets/icon/laboratory.png') }}"
                                                class="image-card-index" />
                                            <a href="{{ url('') }}/pengujian-laboratorium">
                                                <p class="text-icon-pelayanan">Pengujian Laboratorium</p>
                                            </a>
                                        </div>
                                        @if(!empty($url))
                                            <div class="col-sm-4 d-flex justify-content-center">
                                                <img src="{{ asset('assets/icon/permohonanIcon.png') }}"
                                                    class="image-card-index" />
                                                <a href="{{ $url->url }}" target="_blank">
                                                    <p class="text-icon-pelayanan">Permohonan Data</p>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="card-content-close">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="about-right mb-45">
                <div class="mb-30 pt-15 text-center">
                    <h3 class="title-tugas">Profil Singkat</h3>
                    <div class="d-flex justify-content-center">
                        <div class="divider-title-tugas"></div>
                    </div>
                </div>
                <div class="container" data-aos="fade-up">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="container">
                                    <div class="row paragraf-content-index">
                                        <div class="col-lg-6 col-md-6 d-flex justify-content-center p-5 mt-4">
                                            <iframe class="vidio-index" src="{{ $url_yt->url ?? null}}"
                                                title="YouTube video player" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                width="500"
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                        <div class="col-lg-6 col-md-6 d-flex justify-content-center p-5">
                                            <p class="paragraf-pelayanan mt-3">
                                                {!! str_replace(['<div>','</div>'],' ',$url_yt->deskripsi) !!}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="about-right mb-45">
                <div class="mb-30 pt-15 text-center">
                    <h3 class="title-tugas">Berita Terkini</h3>
                    <div class="d-flex justify-content-center">
                        <div class="divider-title-tugas"></div>
                    </div>
                </div>
                <div class="container" data-aos="fade-up">
                    <div class="row mt-5">
                        <div class="card-group">
                            @foreach ($terkini->take(3) as $post)
                                <div class="col-md-4 mb-5 d-flex justify-content-center">
                                    <div class="card card-home" style="width: 375px;">
                                        <img style="height: 261px;"
                                            src="@if ($post->image) {{  asset(  $post->image) }} @else https://source.unsplash.com/500x400?{{ $post->category->name }} @endif "
                                            class="card-img-top" />
                                        <div class="card-body">
                                            <h5 class="card-title title-card-home">{{ $post->title }}</h5>
                                            <p class="card-text card-text-home ">
                                                {{ substr($post->excerpt, 0, 100) }}
                                            </p>
                                        </div>
                                        <div class="card-footer justify-content-end">
                                            <a href="{{ url('berita', ['slug' => $post->slug]) }}" class="button-card-home">
                                                Selengkapnya
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="about-right mb-45">
                <div class="mb-30 pt-15 text-center">
                    <h3 class="title-tugas">Galeri</h3>
                    <div class="d-flex justify-content-center">
                        <div class="divider-title-tugas"></div>
                    </div>
                </div>
                <div class="container" data-aos="fade-up">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="container">
                                    <div class="row" style='margin-top:20px;'>
                                        <div class="col-md-6">
                                            <h5 class="title-list-foto" style="padding-left:55px; margin-bottom: 15px;">Foto</h5>
                                            <div class="test d-flex justify-content-center" style="margin-bottom: 23px;">
                                                <div>
                                                    @if(isset($galeri_foto[0]))
                                                    <img src="{{ asset( $galeri_foto[0]->path_image ?? null) }}"
                                                        style="width: 257px;height: 150px; margin-right: 24px; border-radius: 10px;"
                                                        alt="...">
                                                    @else
                                                    <img src="../img/logo pupr.png"
                                                        style="width: 257px;height: 150px; margin-right: 24px;"
                                                        alt="...">
                                                    @endif

                                                    @if(isset($galeri_foto[1]))
                                                    <img src="{{ asset( $galeri_foto[1]->path_image ?? null) }}"
                                                        style="width: 257px;height: 150px; border-radius: 10px;" alt="...">
                                                    @else
                                                    <img src="../img/logo pupr.png"
                                                        style="width: 257px;height: 150px;" alt="...">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="test d-flex justify-content-center" style="margin-bottom: 23px;">
                                                <div>
                                                    @if(isset($galeri_foto[2]))
                                                    <img src="{{ asset( $galeri_foto[2]->path_image ?? null) }}"
                                                        style="width: 257px;height: 150px; margin-right: 24px border-radius: 10px;;"
                                                        alt="...">
                                                    @else
                                                    <img src="../img/logo pupr.png"
                                                        style="width: 257px;height: 150px; margin-right: 24px;"
                                                        alt="...">
                                                    @endif
                                                    @if(isset($galeri_foto[3]))
                                                    <img src="{{ asset( $galeri_foto[3]->path_image ?? null) }}"
                                                        style="width: 257px;height: 150px border-radius: 10px;;" alt="...">
                                                    @else
                                                    <img src="../img/logo pupr.png"
                                                        style="width: 257px;height: 150px;" alt="...">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h5 class="title-list-foto" style="padding-left: 70px; margin-bottom: 15px;">Video</h5>
                                            <div class="vidio-content-index d-flex justify-content-center">
                                                <iframe width="500" class="youtube" height="257"
                                                    src="{{ $url_yt->url ?? null}}"
                                                    title="YouTube video player" frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen></iframe>
                                            </div>
                                            <div>
                                                <div class="d-flex justify-content-evenly"
                                                    style="margin-top: 13px;padding-left: 28px;padding-right: 28px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="about-right mb-45">
                <div class="mb-30 pt-30 text-center">
                    <h3 class="title-tugas">Situs Terkait</h3>
                    <div class="d-flex justify-content-center">
                        <div class="divider-title-tugas"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section>
        <div class="brand-carousel section-padding owl-carousel">
            @foreach($situsTerkait as $situs)
            <div class="single-logo">
                <div class="col-xl-12 p-1">
                    <a href="{{ $situs->url }}" target="_blank">
                        <div class="carousel-item-bottom">
                            <div class="card">
                                <div class="img-wrapper">
                                    <img src="{{ imageExists($situs->path_image) }}" class="d-block w-100"
                                        alt="...">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"></h5>
                                    <p class="card-text" style="text-align:center">
                                        {{ $situs->title }}
                                    </p>
                                    <a href="#" class=""></a>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </section>
@endsection

@section('customJs')
    <script>
        $(document).ready(function() {
            var multipleCardCarousel = document.querySelector(
                "#carouselExampleControls"
            );
            if (window.matchMedia("(min-width: 768px)").matches) {
                var carousel = new bootstrap.Carousel(multipleCardCarousel, {
                    interval: false,
                });
                var carouselWidth = $(".carousel-inner")[0].scrollWidth;
                var cardWidth = $(".carousel-item-bottom").width();
                console.log(cardWidth)
                var scrollPosition = 0;
                $("#carouselExampleControls .carousel-control-next").on("click", function() {
                    if (scrollPosition < carouselWidth - cardWidth * 4) {
                        scrollPosition += cardWidth;
                        $("#carouselExampleControls .carousel-inner").animate({
                                scrollLeft: scrollPosition
                            },
                            600
                        );
                    }
                });
                $("#carouselExampleControls .carousel-control-prev").on("click", function() {
                    if (scrollPosition > 0) {
                        scrollPosition -= cardWidth;
                        $("#carouselExampleControls .carousel-inner").animate({
                                scrollLeft: scrollPosition
                            },
                            600
                        );
                    }
                });
            } else {
                $(multipleCardCarousel).addClass("slide");
            }
        });
    </script>
    <script>
        $('.brand-carousel').owlCarousel({
            loop: true,
            margin: 10,
            autoplay: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }
        })
    </script>
@endsection
