@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Buat Karya Ilmiah Baru</h1>
    </div>

    <div class="col-lg-8">
        <form method="post" action="{{ url('') }}/dashboard/karya-ilmiah" class="mb-5" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                    name="title" required autofocus value="{{ old('title') }}">
                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="slug" class="form-label @error('slug') is-invalid @enderror">Slug</label>
                <input type="text" name="slug" class="form-control" id="slug" required
                    value="{{ old('slug') }}">
                @error('slug')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="penerbit" class="form-label @error('penerbit') is-invalid @enderror">Penerbit</label>
                <input type="text" name="penerbit" class="form-control" id="penerbit" required
                    value="{{ old('penerbit') }}">
                @error('penerbit')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="tanggal_terbit" class="form-label @error('tanggal_terbit') is-invalid @enderror">Tanggal
                    Terbit</label>
                <input type="text" name="tanggal_terbit" class="form-control" id="tanggal_terbit" required
                    value="{{ old('tanggal_terbit') }}">
                @error('tanggal_terbit')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="issn_online" class="form-label @error('issn_online') is-invalid @enderror">ISSN Online</label>
                <input type="text" name="issn_online" class="form-control" id="issn_online" required
                    value="{{ old('issn_online') }}">
                @error('issn_online')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="issn_cetak" class="form-label @error('issn_cetak') is-invalid @enderror">ISSN Cetak</label>
                <input type="text" name="issn_cetak" class="form-control" id="issn_cetak" required
                    value="{{ old('issn_cetak') }}">
                @error('issn_cetak')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="subyek" class="form-label @error('subyek') is-invalid @enderror">Subyek</label>
                <input type="text" name="subyek" class="form-control" id="subyek" required
                    value="{{ old('subyek') }}">
                @error('subyek')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="bahasa" class="form-label @error('bahasa') is-invalid @enderror">Bahasa</label>
                <input type="text" name="bahasa" class="form-control" id="bahasa" required value="{{ old('bahasa') }}">
                @error('bahasa')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="link_download" class="form-label @error('link_download') is-invalid @enderror">Link
                    Download</label>
                <input type="text" name="link_download" class="form-control" id="link_download" required
                    value="{{ old('link_download')}}">
                @error('link_download')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="path_image" class="form-label">Gambar (Max File Size: 1MB)</label>
                <img class="img-preview img-fluid mb-3 col-sm-5" src="" alt="">
                <input class="form-control @error('path_image') is-invalid @enderror" type="file" id="path_image"
                    name="path_image" onchange="previewImage()" required>
                @error('path_image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="abstract" class="form-label">Abstract</label>
                @error('abstract')
                    <p class="text-danger"> {{ $message }}</p>
                @enderror
                <input id="abstract" type="hidden" name="abstract" value="{{ old('abstract') }}">
                <trix-editor input="abstract"></trix-editor>
            </div>

            <button type="submit" class="btn btn-primary">Buat Karya Ilmiah</button>
        </form>
    </div>

    <script>
        const title = document.querySelector('#title');
        const slug = document.querySelector('#slug');

        title.addEventListener('change', function() {
            fetch('/dashboard/posts/checkSlug?title=' + title.value).then(response => response.json()).then(data =>
                slug.value = data.slug)
        });

        document.addEventListener('trix-file-accept', function(e) {
            e.preventDefault();
        })

        function previewImage() {
            const image = document.querySelector('#path_image');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
@endsection
