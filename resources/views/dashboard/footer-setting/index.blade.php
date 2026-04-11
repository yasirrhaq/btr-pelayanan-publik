@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Footer Settings</h1>
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
                    <th scope="col">Nama Kementerian</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Nomor Telephone</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($footer_setting as $items)
                    <tr>
                        <td>1</td>
                        <td>{{ $items->nama_kementerian }}</td>
                        <td>{{ $items->alamat }}</td>
                        <td>{{ $items->no_hp }}</td>
                        <td>{{ $items->email }}</td>
                        <td>
                            <a href="{{url('')}}/dashboard/footer-setting/{{ $items->id }}/edit" class="badge bg-warning"><span data-feather="edit"></span></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
