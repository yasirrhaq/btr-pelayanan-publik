@extends('layouts.main')

@section('container')
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <h1 class="mb-3">{{ $post->title }}</h1>

                <p>By. Yasir Haq in <a href="{{url('')}}/berita?category={{ $post->category->slug }}" class="text-decoration-none">
                        {{ $post->category->name }}</a></p>
                @if ($post->image)
                    <img src="{{ asset($post->image) }}" alt="{{ $post->category->name }}" class="img-fluid">
                @else
                    <img src="https://source.unsplash.com/1200x400?{{ $post->category->name }}" class="card-img-top"
                        alt="{{ $post->category->name }}" class="img-fluid">
                @endif



                <article class="my-3 fs-5">
                    {!! $post->body !!}
                </article>

                <a href="{{url('')}}/berita" class="text-decoration-none">Back to berita</a>
            </div>
        </div>
    </div>
@endsection
