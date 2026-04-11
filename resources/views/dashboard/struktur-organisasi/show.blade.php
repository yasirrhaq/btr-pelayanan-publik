@extends('dashboard.layouts.main')

@section('container')
    <div class="container">
        <div class="row my-3">
            <div class="col-lg-8">
                <h1 class="mb-3">{{ $strukturOrganisasi->title }}</h1>

                <a href="{{url('')}}/dashboard/struktur-organisasi" class="btn btn-success"><span data-feather="arrow-left"></span> Back to daftar
                    Fasilitas Balai</a>
                <a href="{{url('')}}/dashboard/struktur-organisasi/{{ $strukturOrganisasi->id }}/edit" class="btn btn-warning"><span data-feather="edit"></span>
                    Edit</a>
                <form action="{{url('')}}/dashboard/struktur-organisasi/{{ $strukturOrganisasi->id }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data?')"><span
                            data-feather="x-circle"></span>Delete</button>
                </form>

                @if ($strukturOrganisasi->path_image)
                    <div style="max-height:2000px; overflow:hidden">
                        <img src="{{  asset(  $strukturOrganisasi->path_image) }}" alt="{{ $strukturOrganisasi->title }}"
                            class="img-fluid mt-3">
                    </div>
                @else
                    <img src="https://source.unsplash.com/1200x400?{{ $strukturOrganisasi->title }}"
                        alt="{{ $strukturOrganisasi->title }}" class="img-fluid mt-3">
                @endif

            </div>
        </div>
    </div>
@endsection
