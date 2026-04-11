@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Profil Singkat</h1>
    </div>

    <div class="col-lg-8">
        <form method="post" action="{{url('')}}/dashboard/profil-singkat/{{ $urls->id }}" class="mb-5"
            enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label @error('name') is-invalid @enderror">Nama Layanan</label>
                <input type="text" name="name" class="form-control" id="name" required
                    value="{{ old('name', 'Profil Singkat') }}" readonly>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">deskripsi</label>
                @error('deskripsi')
                    <p class="text-danger"> {{ $message }}</p>
                @enderror
                <input id="deskripsi" type="hidden" name="deskripsi" value="{{ old('url', $urls->deskripsi) }}" required>
                <trix-editor input="deskripsi"></trix-editor>
            </div>
            <button type="submit" class="btn btn-primary">Update Deskripsi Profil Singkat</button>
        </form>
    </div>
@endsection
