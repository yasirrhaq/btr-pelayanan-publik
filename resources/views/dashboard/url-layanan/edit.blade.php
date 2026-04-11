@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Url Layanan</h1>
    </div>

    <div class="col-lg-8">
        <form method="post" action="{{url('')}}/dashboard/url-layanan/{{ $urls->id }}" class="mb-5"
            enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label @error('name') is-invalid @enderror">Nama Layanan</label>
                <input type="text" name="name" class="form-control" id="name" required
                    value="{{ old('name', $urls->name) }}" readonly>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="url" class="form-label @error('url') is-invalid @enderror">url</label>
                <input type="text" name="url" class="form-control" id="url" required
                    value="{{ old('url', $urls->url) }}">
                @error('url')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update Url Layanan</button>
        </form>
    </div>
@endsection
