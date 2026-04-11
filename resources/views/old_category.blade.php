@extends('layouts.main')

@section('container')
    <h1>Kategori Berita : {{ $category }}</h1>

    @foreach ($posts as $post)
        <article class="mb-5">
            <h2>
                <a href="{{url('')}}/berita/{{ $post->slug }}">{{ $post->title }}</a>
            </h2>
            {{-- <h5>By. Yasir Haq in <a href="{{url('')}}/categories/{{ $post->category->slug }}"> {{ $post->category->name }}</a></h5> --}}
            {{-- <h5>By: {{ $post['author'] }}</h5> --}}
            <img src="{{ $post['image'] }}" alt="{{ $post['image'] }}" width="200">
            <p>{{ $post->excerpt }}</p>
        </article>
    @endforeach
@endsection
