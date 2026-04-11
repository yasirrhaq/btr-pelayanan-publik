@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Daftar Profil Singkat</h1>
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
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Profil Singkat</td>
                    <td>
                        @if (empty($url->deskripsi))
                            -
                        @else
                            {!! cutText($url->deskripsi) !!}
                        @endif
                    </td>
                    <td>
                        <a href="{{ url('') }}/dashboard/profil-singkat/{{ $url->id }}/edit"
                            class="badge bg-warning"><span data-feather="edit"></span></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
