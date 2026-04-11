@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Daftar Struktur Organisasi</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="table-responsive col-lg-8">
        <a href="{{url('')}}/dashboard/struktur-organisasi/create" class="btn btn-primary mb-3">Buat Struktur Organisasi Baru</a>
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Path</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($strukturOrganisasi as $items)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $items->title }}</td>
                        <td>{{ $items->path_image }}</td>
                        <td>
                            <a href="{{url('')}}/dashboard/struktur-organisasi/{{ $items->id }}" class="badge bg-info"><span
                                    data-feather="eye"></span></a>
                            <a href="{{url('')}}/dashboard/struktur-organisasi/{{ $items->id }}/edit" class="badge bg-warning"><span data-feather="edit"></span></a>
                            <form action="{{url('')}}/dashboard/struktur-organisasi/{{ $items->id }}" method="post" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="badge bg-danger border-0" onclick="return confirm('Yakin ingin menghapus data?')"><span data-feather="x-circle"></span></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection