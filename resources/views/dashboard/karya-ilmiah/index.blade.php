@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Daftar Karya Ilmiah</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="table-responsive col-lg-12">
        <a href="{{url('')}}/dashboard/karya-ilmiah/create" class="btn btn-primary mb-3">Buat Karya Ilmiah Baru</a>
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Penerbit</th>
                    <th scope="col">Tanggal terbit</th>
                    <th scope="col">ISSN Online</th>
                    <th scope="col">ISSN Cetak</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($karyaIlmiah as $karya)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $karya->title }}</td>
                        <td>{{ $karya->penerbit }}</td>
                        <td>{{ $karya->tanggal_terbit }}</td>
                        <td>{{ $karya->issn_online }}</td>
                        <td>{{ $karya->issn_cetak }}</td>
                        <td>
                            <a href="{{url('')}}/dashboard/karya-ilmiah/{{ $karya->slug }}/edit" class="badge bg-warning"><span data-feather="edit"></span></a>
                            <form action="{{url('')}}/dashboard/karya-ilmiah/{{ $karya->slug }}" method="post" class="d-inline">
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
