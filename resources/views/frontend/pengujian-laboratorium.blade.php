@extends('frontend.layouts.mainNew')

@section('customCss')
<link rel="stylesheet" href="{{ url('css/responsive/pengujian.css')}}">
<link rel="stylesheet" href="{{ url('css/responsive/index.css')}}">
<link rel="stylesheet" href="{{ url('css/responsive/navbar.css')}}">
<link rel="stylesheet" href="{{ url('css/advis.css')}}">
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
                                    <h3 class="title-tugas">{{ $url->name }}
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
                   <div class="whole-wrap">
                        <div class="container box_1170">
                            <div class="section-top-border">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="card">
                                            <h5 class="card-header">Tentang {{ $url->name }}</h5>
                                            <div class="card-body">
                                                <p class="card-text text-justify">{!! str_replace(['<div>','</div>'],' ', $url->deskripsi) !!}</p>
                                                <a href="@if(auth()->user()) {{ $url->url }} @else /login @endif" class="btn btn-block mb-3">Daftar</a>
                                            </div>
                                        </div>
                                        <!-- <div class="card">
                                            <h5 class="card-header">Dokumen Pendukung</h5>
                                            <div class="card-body">
                                                <div class="col-12 advis-table cards-unduhan mb-5" style="display: flexbox;justify-content: space-between;" >
                                                    <p class="card-text-dokumen">Format Surat Permohonan Pengujian Laboratorium</p>
                                                    <a href="#" class="btn btn-block mb-3">Unduh</a>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="col-md-7">
                                        <img src="{{ imageExists($url->path_image) }}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </main>
   @endsection