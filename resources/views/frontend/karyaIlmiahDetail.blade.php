@extends('frontend.layouts.mainNew')

@section('customCss')
<link rel="stylesheet" href="{{ url('css/responsive/pengujian.css')}}">
<link rel="stylesheet" href="{{ url('css/responsive/index.css')}}">
<link rel="stylesheet" href="{{ url('css/responsive/navbar.css')}}">
<!-- <link rel="stylesheet" href="{{ url('css/advis.css')}}"> -->
<link rel="stylesheet" href="{{ url('css/frontend/karyailmiah.css')}}">
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
                                    <h3 class="title-tugas">{{ $karyaIlmiah->title}}
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
                                    <div class="col-md-7">
                                        <div class="card">
                                            <h5 class="card-header">Abstrak</h5>
                                            <div class="card-body">
                                                <article class="card-text">
                                                    {!! $karyaIlmiah->abstract !!}
                                                </article>
                                                <!-- <p class="card-text">Advis Teknis Adalah Dan Pengembangan. Badan Penelitian Dan Pengembangan. Pada Tahun 2010 Terdapat Perubahan Nomenklatur Departemen Pekerjaan Umum Menjadi Kementerian Pekerjaan Umum Melalui Peraturan Menteri Pekerjaan Umum No. 21/PRT/M/2010.</p> -->
                                                <a href="@if(auth()->user()) {{ $karyaIlmiah->link_download }} @else /login @endif" class="btn btn-block mb-3 p-3"><i class="fa fa-file"></i>PDF</a>
                                                <!-- <a href="{{ $karyaIlmiah->link_download }}" class="btn btn-block mb-3 p-3"><i class="fa fa-file"></i>PDF</a> -->
                                            </div>
                                        </div>
                                        <!-- <div class="card">
                                            <h5 class="card-header">Dokumen Pendukung</h5>
                                            <div class="card-body">
                                                <div class="col-12 advis-table cards-unduhan mb-5" style="display: flexbox;justify-content: space-between;" >
                                                    <p class="card-text-dokumen">Format Surat Pendukung Permohonan Advis Teknis</p>
                                                    <a href="#" class="btn btn-block mb-3">Unduh</a>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="col-md-5">

                                        @if(isset($karyaIlmiah->path_image))
                                        <img src="{{  asset( $karyaIlmiah->path_image) }}" alt="" class="img-fluid">
                                        @else
                                        <img src="https://images.unsplash.com/photo-1470790376778-a9fbc86d70e2?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=404&q=80" alt="" class="img-fluid">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 51px;">
                    <div class="col d-flex justify-content-center" style="width: 1163px;height: 482px;">
                    <table id="customers">
                        <tbody>
                            <td >Penerbit</td>
                            <td >{{ $karyaIlmiah->penerbit}}</td>
                            <tr>
                                <td>ISSN Online</td>
                                <td>{{ $karyaIlmiah->issn_online}}</td>
                            </tr>
                            <tr>
                                <td>ISSN Cetak</td>
                                <td>{{ $karyaIlmiah->issn_cetak}}</td>
                            </tr>
                            <tr>
                                <td>Bahasa</td>
                                <td>{{ $karyaIlmiah->bahasa }}</td>
                            </tr>
                            <tr>
                                <td>Subyek</td>
                                <td>{{ $karyaIlmiah->subyek}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </main>
</br>
</br>

   @endsection
