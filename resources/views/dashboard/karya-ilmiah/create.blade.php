@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Karya Ilmiah <small>Buat Karya Ilmiah</small></h1>

    <div class="btr-card">
        <form method="post" action="{{ url('dashboard/karya-ilmiah') }}" enctype="multipart/form-data">
            @csrf

            <div class="btr-form-group">
                <label class="btr-label" for="title">Judul</label>
                <input type="text" class="btr-input" id="title" name="title" required autofocus value="{{ old('title') }}">
                @error('title') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="slug">Slug</label>
                <input type="text" class="btr-input" name="slug" id="slug" required value="{{ old('slug') }}">
                @error('slug') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="penerbit">Penerbit</label>
                <input type="text" class="btr-input" name="penerbit" id="penerbit" required value="{{ old('penerbit') }}">
                @error('penerbit') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="tanggal_terbit">Tanggal Terbit</label>
                <input type="text" class="btr-input" name="tanggal_terbit" id="tanggal_terbit" required value="{{ old('tanggal_terbit') }}">
                @error('tanggal_terbit') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="issn_online">ISSN Online</label>
                <input type="text" class="btr-input" name="issn_online" id="issn_online" required value="{{ old('issn_online') }}">
                @error('issn_online') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="issn_cetak">ISSN Cetak</label>
                <input type="text" class="btr-input" name="issn_cetak" id="issn_cetak" required value="{{ old('issn_cetak') }}">
                @error('issn_cetak') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="subyek">Subyek</label>
                <input type="text" class="btr-input" name="subyek" id="subyek" required value="{{ old('subyek') }}">
                @error('subyek') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="bahasa">Bahasa</label>
                <input type="text" class="btr-input" name="bahasa" id="bahasa" required value="{{ old('bahasa') }}">
                @error('bahasa') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="link_download">Link Download</label>
                <input type="text" class="btr-input" name="link_download" id="link_download" required value="{{ old('link_download') }}">
                @error('link_download') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label">Gambar <small style="color:var(--text-muted)">(Max 1MB)</small></label>
                <img class="img-preview" src="" alt="" style="display:none;max-width:280px;border-radius:10px;margin-bottom:10px">
                <div class="btr-file-row">
                    <label class="btr-file-pill">
                        <span class="btr-file-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16V8m0 0l-3 3m3-3l3 3"/></svg>
                        </span>
                        <input type="file" id="path_image" name="path_image" onchange="btrPreview(this,'.img-preview')" required>
                    </label>
                </div>
                @error('path_image') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="abstract">Abstract</label>
                <input id="abstract" type="hidden" name="abstract" value="{{ old('abstract') }}">
                <trix-editor input="abstract"></trix-editor>
                @error('abstract') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-actions">
                <a href="{{ url('dashboard/karya-ilmiah') }}" class="btr-btn btr-btn-outline">Batal</a>
                <button type="submit" class="btr-btn">Simpan</button>
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
