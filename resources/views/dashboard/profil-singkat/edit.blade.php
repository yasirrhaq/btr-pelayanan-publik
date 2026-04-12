@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Profil Singkat <small>Edit Profil Singkat</small></h1>

    <div class="btr-card">
        <form method="post" action="{{ url('dashboard/profil-singkat/' . $urls->id) }}" enctype="multipart/form-data">
            @method('put')
            @csrf

            <div class="btr-form-group">
                <label class="btr-label" for="name">Judul</label>
                <input type="text" class="btr-input" id="name" name="name" required value="{{ old('name', 'Profil Singkat') }}" readonly>
                @error('name') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="deskripsi">Deskripsi</label>
                <input id="deskripsi" type="hidden" name="deskripsi" value="{{ old('deskripsi', $urls->deskripsi) }}" required>
                <trix-editor input="deskripsi"></trix-editor>
                @error('deskripsi') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-actions">
                <a href="{{ url('dashboard/profil-singkat') }}" class="btr-btn btr-btn-outline">Batal</a>
                <button type="submit" class="btr-btn">Update</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('trix-file-accept', e => e.preventDefault());
    </script>
@endsection
