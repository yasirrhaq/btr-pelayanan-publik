@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Publikasi - Berita <small>Edit Berita</small></h1>

    <div class="btr-card">
        <form method="post" action="{{ url('dashboard/posts/' . $post->slug) }}" enctype="multipart/form-data">
            @method('put')
            @csrf

            <div class="btr-form-group">
                <label class="btr-label" for="title">Judul</label>
                <input type="text" class="btr-input" id="title" name="title" required autofocus value="{{ old('title', $post->title) }}">
                @error('title') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="slug">Slug</label>
                <input type="text" class="btr-input" name="slug" id="slug" required value="{{ old('slug', $post->slug) }}">
                @error('slug') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="category_id">Kategori</label>
                <select name="category_id" class="btr-select">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="btr-form-group">
                <label class="btr-label">Gambar Berita <small style="color:var(--text-muted)">(Max 1MB)</small></label>
                <input type="hidden" name="oldImage" value="{{ $post->image }}">
                @if ($post->image)
                    <img src="{{ asset($post->image) }}" class="img-preview" style="display:block;max-width:280px;border-radius:10px;margin-bottom:10px">
                @else
                    <img class="img-preview" src="" alt="" style="display:none;max-width:280px;border-radius:10px;margin-bottom:10px">
                @endif
                <div class="btr-file-row">
                    <label class="btr-file-pill">
                        <span class="btr-file-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16V8m0 0l-3 3m3-3l3 3M17 8v8m0 0l3-3m-3 3l-3-3"/></svg>
                        </span>
                        <input type="file" id="image" name="image" onchange="btrPreview(this,'.img-preview')">
                    </label>
                </div>
                @error('image') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="body">Deskripsi</label>
                <input id="body" type="hidden" name="body" value="{{ old('body', $post->body) }}">
                <trix-editor input="body"></trix-editor>
                @error('body') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-actions">
                <a href="{{ url('dashboard/posts') }}" class="btr-btn btr-btn-outline">Batal</a>
                <button type="submit" class="btr-btn">Update</button>
            </div>
        </form>
    </div>

    <script>
        document.querySelector('#title').addEventListener('change', function () {
            fetch('/dashboard/posts/checkSlug?title=' + this.value)
                .then(r => r.json())
                .then(d => document.querySelector('#slug').value = d.slug);
        });
        document.addEventListener('trix-file-accept', e => e.preventDefault());
        function btrPreview(input, sel) {
            var img = document.querySelector(sel);
            var r = new FileReader();
            r.onload = function (e) { img.src = e.target.result; img.style.display = 'block'; };
            if (input.files[0]) r.readAsDataURL(input.files[0]);
        }
    </script>
@endsection
