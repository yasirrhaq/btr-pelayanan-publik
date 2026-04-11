@extends('frontend.layouts.mainNew')

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
                                    <h3 class="title-tugas">Informasi Pegawai <br/>
                                        {{ config('app.name') }}
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
                   <div class="row">
                        <div class="col-lg-12">
                            <div class="about-right mb-90">
                                <div class="about-img mt-10">
                                    @foreach($infoPegawai as $info)
                                    <img src="{{  asset( $info->path_image) }}" alt="">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                   </div>
            </div>
        </div>
        <div class="d-flex justify-content-center mb-4">
            {{ $infoPegawai->links() }}
        </div>
    </main>
   @endsection
