@extends('frontend.layouts.mainNew')

@section('customCss')
    <link rel="stylesheet" href="{{ url('css/frontend/fasilitas.css') }}">
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
                                <h3 class="title-tugas">Fasilitas Kami
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
                @foreach ($fasilitasBalai->chunk(3) as $fasilitas)
                    <div class="card-deck mt-5">
                        @foreach ($fasilitas as $item)
                            <div class="card">
                                <img class="card-img-top" src="{{  asset(  $item->path_image) }}"
                                    alt="Card image cap" height="277px" style="object-fit: cover">
                                <div class="card-body">
                                    <h5 class="card-title text-center">
                                        {{ $item->title }}
                                    </h5>
                                    <!-- <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p> -->
                                    <!-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> -->
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
        <div class="d-flex justify-content-center mb-2 mt-2">
            {{ $fasilitasBalai->links() }}
        </div>
    </main>
@endsection
