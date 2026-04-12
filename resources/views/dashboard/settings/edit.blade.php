@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Pengaturan <small>Edit</small></h1>

    <div class="btr-card">
        <form method="post" action="{{ url('dashboard/categories/' . $category->slug) }}" enctype="multipart/form-data">
            @method('put')
            @csrf

            <div class="btr-form-group">
                <label class="btr-label" for="name">Nama</label>
                <input type="text" class="btr-input" id="name" name="name" required autofocus value="{{ old('name', $category->name) }}">
                @error('name') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="slug">Slug</label>
                <input type="text" class="btr-input" id="slug" name="slug" required value="{{ old('slug', $category->slug) }}">
                @error('slug') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-actions">
                <a href="{{ url('dashboard/settings') }}" class="btr-btn btr-btn-outline">Batal</a>
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
