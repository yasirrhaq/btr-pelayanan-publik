@extends('frontend.layouts.mainTailwind')

@section('customCss')
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="{{ url('css/frontend/fasilitas.css')}}">
@endsection
@section('container')
    
    <main>
        <div class="about-area">
            <div class="container">
                   <div class="row">
                        <div class="col-lg-12">
                            <div class="about-right mb-90">
                                <!-- <div class="about-img">
                                    <img src="{{ asset('img/post/about_heor.jpg') }}" alt="">
                                </div> -->
                                <div class="mb-30 pt-30 text-center">
                                    <h3 class="title-tugas">Video
                                    </h3>
                                    <div class="d-flex justify-content-center">
                                        <div class="divider-title-tugas"></div>
                                    </div>
                                </div>
                                <div class="about-prea">
                                </div>
                            </div>
                        </div>
                   </div>

                   <!-- <div class="container">
                        <div id="carouselExampleCaptions" class="carousel slide mt-5" data-bs-ride="false">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-shadow"></div>
                                <div class="carousel-item active">
                                <iframe style="width: 100%; height:500px;" src="https://www.youtube.com/embed/AjxL87NyLRs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                                <div class="carousel-item">
                                <iframe style="width: 100%; height:500px;" src="https://www.youtube.com/embed/AjxL87NyLRs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                                <div class="carousel-item">
                                <iframe style="width: 100%; height:500px;" src="https://www.youtube.com/embed/AjxL87NyLRs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div> -->
                    <div class="card-deck mt-2">
                        
                    </div>
                    <iframe allowfullscreen id="wallsio-iframe" src="https://my.walls.io/r3b3y?nobackground=1&amp;show_header=0" style="border:0;height:800px;width:100%" loading="lazy" title="PUPRSDA BALTEKRAWA"></iframe>

                    <div class="card-deck mt-5">
                        
                    </div>
            </div>
        </div>
    </main>
    
   @endsection

   @section('customJs')
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
   @endsection
