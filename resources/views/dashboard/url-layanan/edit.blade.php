@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">URL Layanan <small>Edit URL Layanan</small></h1>

    <div class="btr-card">
        <form method="post" action="{{ url('dashboard/url-layanan/' . $urls->id) }}" enctype="multipart/form-data">
            @method('put')
            @csrf

            <div class="btr-form-group">
                <label class="btr-label" for="name">Nama Layanan</label>
                <input type="text" class="btr-input" id="name" name="name" required value="{{ old('name', $urls->name) }}" readonly>
                @error('name') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="url">URL Layanan</label>
                <input type="text" class="btr-input" id="url" name="url" required value="{{ old('url', $urls->url) }}">
                @error('url') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-actions">
                <a href="{{ url('dashboard/url-layanan') }}" class="btr-btn btr-btn-outline">Batal</a>
                <button type="submit" class="btr-btn">Update</button>
            </div>
        </form>
    </div>
@endsection
