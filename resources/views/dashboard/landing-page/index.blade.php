@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{ $title }}</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="table-responsive col-lg-8">
        <a href="{{ url('') }}/dashboard/landing-page/create?type={{ request()->type }}"
            class="btn btn-primary mb-3">Buat Baru</a>
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Type</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Status</th>
                    <th scope="col">Gambar</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->attr_tipe }}</td>
                        <td>{!! cutText($item->deskripsi) !!}</td>
                        <td>{{ $item->status }}</td>
                        <td>
                            @if (empty($item->path))
                                -
                            @else
                                <img src="{{ imageExists($item->path) }}" style="max-width:175px;heigt:auto;">
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('') }}/dashboard/landing-page/{{ $item->id }}/edit?type={{ request()->type }}"
                                class="badge bg-warning"><span data-feather="edit"></span></a>
                            <form
                                action="{{ url('') }}/dashboard/landing-page/{{ $item->id }}?type={{ request()->type }}"
                                method="post" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="badge bg-danger border-0"
                                    onclick="return confirm('Yakin ingin menghapus data?')"><span
                                        data-feather="x-circle"></span></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
