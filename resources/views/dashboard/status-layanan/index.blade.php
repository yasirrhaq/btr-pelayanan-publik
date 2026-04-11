@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Daftar Status Layanan User</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="table-responsive col-lg-8">
        <a href="{{url('')}}/dashboard/status-layanan/create" class="btn btn-primary mb-3">Buat Status Layanan Baru</a>
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">User</th>
                    <th scope="col">Jenis Layanan</th>
                    <th scope="col">Status Layanan</th>
                    <th scope="col">Detail</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($statusLayanan as $status)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $status->user->name }}</td>
                        <td>{{ $status->jenis->name }}</td>
                        <td>{{ $status->status->name }}</td>
                        <td>{{ $status->detail }}</td>
                        <td>
                            <a href="{{url('')}}/dashboard/status-layanan/{{ $status->id }}/edit" class="badge bg-warning"><span
                                    data-feather="edit"></span></a>
                            <form action="{{url('')}}/dashboard/status-layanan/{{ $status->id }}" method="post" class="d-inline">
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
