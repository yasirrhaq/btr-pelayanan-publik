@extends('profile.layouts.main')

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
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Pemohon</th>
                    <th scope="col">Nama Layanan</th>
                    <th scope="col">Status Layanan</th>
                    <th scope="col">Detail</th>
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
