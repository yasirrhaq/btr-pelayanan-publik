@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Kategori <small>Edit Kategori</small></h1>

    <div class="btr-card">
        <form method="post" action="{{ url('dashboard/categories/' . $category->slug) }}">
            @method('put')
            @csrf
            <div class="btr-form-group">
                <label class="btr-label" for="name">Nama Kategori</label>
                <input type="text" class="btr-input" id="name" name="name" required autofocus value="{{ old('name', $category->name) }}">
                @error('name') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="slug">Slug</label>
                <input type="text" class="btr-input" name="slug" id="slug" required value="{{ old('slug', $category->slug) }}">
                @error('slug') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-actions">
                <a href="{{ url('dashboard/categories') }}" class="btr-btn btr-btn-outline">Batal</a>
                <button type="submit" class="btr-btn">Update</button>
            </div>
        </form>
    </div>

    <script>
        document.querySelector('#name').addEventListener('change', function () {
            fetch('/dashboard/categories/checkSlug?name=' + this.value)
                .then(r => r.json())
                .then(d => document.querySelector('#slug').value = d.slug);
        });
    </script>
@endsection
