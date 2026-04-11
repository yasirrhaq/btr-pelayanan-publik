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
                                    <h3 class="title-tugas">Struktur Organisasi</h3>
                                    <div class="d-flex justify-content-center">
                                        <div class="divider-title-tugas"></div>
                                    </div>
                                </div>
                                <div class="about-prea">
                                    <p class="about-pera1 mb-25 text-justify">
                                    Struktur organisasi Balai Teknik Rawa berdasarkan Peraturan Menteri PUPR Nomor 16 Tahun 2020 tentang Organisasi dan Tata Kerja Unit Pelaksana Teknis Kementerian Pekerjaan Umum dan Perumahan Rakyat, adalah sebagai berikut:
                                    </p>
                                </div>
                            </div>
                        </div>
                   </div>
                   <div class="row">
                        <div class="col-lg-12">
                            <div class="about-right mb-90">
                                <div class="about-img mt-10">
                                    @foreach($strukturOrganisasi as $item)
                                    <img src="{{  asset(  $item->path_image) }}" alt="">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                   </div>
            </div>
        </div>
        <div class="d-flex justify-content-center mb-4">
            {{ $strukturOrganisasi->links() }}
        </div>
    </main>
   @endsection
