@extends('dashboard.layouts.main')

@section('container')
    <div class="container">
        <div class="row my-3">
            <div class="col-lg-8">
                <h1 class="mb-3">{{ $galeri_foto->title }}</h1>

                <a href="{{url('')}}/dashboard/galeri/foto-video" class="btn btn-success"><span data-feather="arrow-left"></span> Back to daftar
                    galeri</a>
                <a href="{{url('')}}/dashboard/galeri/foto-video/{{ $galeri_foto->id }}/edit" class="btn btn-warning"><span data-feather="edit"></span>
                    Edit</a>
                <form action="{{url('')}}/dashboard/galeri/foto-video/{{ $galeri_foto->id }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data?')"><span
                            data-feather="x-circle"></span>Delete</button>
                </form>

                @if ($galeri_foto->path_image)
                    <div style="max-height:350px; overflow:hidden">
                        <img src="{{ asset($galeri_foto->path_image) }}" alt="{{ $galeri_foto->title }}"
                            class="img-fluid mt-3">
                    </div>
                @else
                    <img src="https://source.unsplash.com/1200x400?{{ $galeri_foto->title }}"
                        alt="{{ $galeri_foto->title }}" class="img-fluid mt-3">
                @endif

            </div>
        </div>
    </div>
@endsection
