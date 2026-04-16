@extends('frontend.layouts.mainTailwind')

@section('customCss')
    <link rel="stylesheet" href="{{ url('css/frontend/fasilitas.css')}}">
@endsection
@section('container')

    <main>
        <div class="about-area">
            <div class="container">
                   <div class="row">
                        <div class="col-lg-12">
                            <div class="about-right mb-90">
                                <div class="mb-30 pt-30 text-center">
                                    <h3 class="title-tugas">Foto
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
                   @foreach ($galeri_foto->chunk(3) as $galeri)
                        <div class="card-deck mt-5">
                            @foreach ($galeri as $item)
                                <div class="card">
                                    <img class="card-img-top" src="{{  asset( $item->path_image) }}" alt="Card image cap" height="277px" style="object-fit: cover">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">
                                            {{ $item->title }}
                                        </h5>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                   @endforeach
                    <div
                    loading="lazy"
                    data-mc-src="dd70c1cc-546f-4d2b-8048-835164283f4a#null"></div>
                            
                    <script 
                    src="https://cdn2.woxo.tech/a.js#6392a356d70da24e38bf225e" 
                    async data-usrc>
                    </script>
                    <div class="card-deck mt-5">

                    </div>
            </div>
        </div>
        <div class="d-flex justify-content-center mb-2">
            {{ $galeri_foto->links() }}
        </div>
    </main>

   @endsection
