@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Tautan <small>Edit Tautan</small></h1>

    <div class="btr-card">
        <form method="post" action="{{ url('dashboard/situs-terkait/' . $situsTerkait->id) }}" enctype="multipart/form-data">
            @method('put')
            @csrf

            <div class="btr-form-group">
                <label class="btr-label" for="title">Nama Tautan</label>
                <input type="text" class="btr-input" id="title" name="title" required autofocus value="{{ old('title', $situsTerkait->title) }}">
                @error('title') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="url">URL Situs</label>
                <input type="text" class="btr-input" id="url" name="url" required value="{{ old('url', $situsTerkait->url) }}">
                @error('url') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label">Logo</label>
                <input type="hidden" name="oldImage" value="{{ $situsTerkait->path_image }}">
                @if ($situsTerkait->path_image)
                    <img src="{{ asset($situsTerkait->path_image) }}" class="img-preview" style="display:block;max-width:160px;border-radius:10px;margin-bottom:10px">
                @else
                    <img class="img-preview" src="" alt="" style="display:none;max-width:160px;border-radius:10px;margin-bottom:10px">
                @endif
                <div class="btr-file-row">
                    <label class="btr-file-pill">
                        <span class="btr-file-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16V8m0 0l-3 3m3-3l3 3"/></svg>
                        </span>
                        <input type="file" id="image" name="path_image" onchange="btrPreview(this,'.img-preview')">
                    </label>
                </div>
            </div>

            <div class="btr-form-actions">
                <a href="{{ url('dashboard/situs-terkait') }}" class="btr-btn btr-btn-outline">Batal</a>
                <button type="submit" class="btr-btn">Update</button>
            </div>
        </form>
    </div>

    <script>
        function btrPreview(input, sel) {
            var img = document.querySelector(sel);
            var r = new FileReader();
            r.onload = function (e) { img.src = e.target.result; img.style.display = 'block'; };
            if (input.files[0]) r.readAsDataURL(input.files[0]);
        }
    </script>
@endsection
