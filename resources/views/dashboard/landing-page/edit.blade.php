@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">{{ $title }} <small>Edit {{ $title }}</small></h1>

    <div class="btr-card">
        <form method="post" action="{{ url('dashboard/landing-page/' . $landing_page->id . '?type=' . request()->type) }}" enctype="multipart/form-data">
            @method('put')
            @csrf

            <div class="btr-form-group">
                <label class="btr-label" for="title">Title</label>
                <input type="text" class="btr-input" id="title" name="title" required autofocus value="{{ old('title', $landing_page->title) }}">
                @error('title') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label">Gambar {{ $title }} <small style="color:var(--text-muted)">(Max 1MB)</small></label>
                <input type="hidden" name="oldImage" value="{{ $landing_page->path }}">
                @if ($landing_page->image)
                    <img src="{{ asset($landing_page->image) }}" class="img-preview" style="display:block;max-width:480px;border-radius:10px;margin-bottom:10px">
                @else
                    <img class="img-preview" src="" alt="" style="display:none;max-width:480px;border-radius:10px;margin-bottom:10px">
                @endif
                <div class="btr-file-row">
                    <label class="btr-file-pill">
                        <span class="btr-file-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16V8m0 0l-3 3m3-3l3 3"/></svg>
                        </span>
                        <input type="file" id="image" name="image" onchange="btrPreview(this,'.img-preview')">
                    </label>
                </div>
                @error('image') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="deskripsi">Deskripsi</label>
                <input id="deskripsi" type="hidden" name="deskripsi" value="{{ old('deskripsi', $landing_page->deskripsi) }}">
                <trix-editor input="deskripsi"></trix-editor>
                @error('deskripsi') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-actions">
                <a href="{{ url('dashboard/landing-page?type=' . request()->type) }}" class="btr-btn btr-btn-outline">Batal</a>
                <button type="submit" class="btr-btn">Update</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('trix-file-accept', e => e.preventDefault());
        function btrPreview(input, sel) {
            var img = document.querySelector(sel);
            var r = new FileReader();
            r.onload = function (e) { img.src = e.target.result; img.style.display = 'block'; };
            if (input.files[0]) r.readAsDataURL(input.files[0]);
        }
    </script>
@endsection
