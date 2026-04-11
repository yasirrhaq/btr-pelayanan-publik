@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Daftar Foto Home</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="table-responsive col-lg-8">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Path</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fotoHome as $items)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $items->title }}</td>
                        <td>{{ $items->deskripsi }}</td>
                        <td>{{ $items->path_image }}</td>
                        <td>
                            <a href="{{url('')}}/dashboard/foto-home/{{ $items->id }}/edit" class="badge bg-warning"><span data-feather="edit"></span></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
