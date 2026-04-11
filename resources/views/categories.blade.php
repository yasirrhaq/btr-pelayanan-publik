@extends('layouts/main')

@section('container')
    <h1 class="mb-5">Kategori Berita</h1>

    <div class="container">
        <div class="row">
            @foreach ($categories as $category)
                <div class="col-md-4">
                    <a href="{{url('')}}/berita?category={{ $category->slug }}" class="text-decoration-none text-white">
                        <div class="card bg-dark text-white">
                            <img src="https://source.unsplash.com/500x500?{{ $category->name }}" class="card-img-top"
                                alt="{{ $category->name }}">
                            <div class="card-img-overlay d-flex align-items-center p-0 fs-3">
                                <h5 class="card-title text-center flex-fill p-4" style="background-color: rgba(0,0,0,0.7)">
                                    {{ $category->name }}</h5>

                            </div>
                    </a>
                </div>
        </div>
        @endforeach
    </div>
    </div>
@endsection
