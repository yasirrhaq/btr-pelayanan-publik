@extends('dashboard.layouts.main')

@section('container')
    <div class="container">
        <div class="row my-3">
            <div class="col-lg-8">
                <h1 class="mb-3">{{ $post->title }}</h1>

                {{-- <h5>By: {{ $post['author'] }}</h5> --}}

                <a href="{{url('')}}/dashboard/posts" class="btn btn-success"><span data-feather="arrow-left"></span> Back to daftar
                    berita</a>
                <a href="{{url('')}}/dashboard/posts/{{ $post->slug }}/edit" class="btn btn-warning"><span data-feather="edit"></span>
                    Edit</a>
                <form action="{{url('')}}/dashboard/posts/{{ $post->slug }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data?')"><span
                            data-feather="x-circle"></span>Delete</button>
                </form>

                @if ($post->image)
                    <div style="max-height:350px; overflow:hidden">
                        <img src="{{ asset($post->image) }}" alt="{{ $post->category->name }}"
                            class="img-fluid mt-3">
                    </div>
                @else
                    <img src="https://source.unsplash.com/1200x400?{{ $post->category->name }}"
                        alt="{{ $post->category->name }}" class="img-fluid mt-3">
                @endif
                {{-- <p>{{ $post->body }}</p> --}}
                {{-- ini kalo mau pakai ada tag htmlnya --}}

                <article class="my-3 fs-5">
                    {!! $post->body !!}
                </article>
            </div>
        </div>
    </div>
@endsection
