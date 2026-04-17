@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Profil - SDM <small>Tambah Pegawai</small></h1>

    <div class="btr-card">
        <form method="post" action="{{ url('dashboard/info-pegawai') }}" enctype="multipart/form-data">
            @csrf
            <div class="btr-form-group">
                <label class="btr-label" for="title">Nama Pegawai</label>
                <input type="text" class="btr-input" id="title" name="title" required autofocus value="{{ old('title') }}">
                @error('title') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="urutan">Urutan Tampil</label>
                <input type="number" min="1" class="btr-input" id="urutan" name="urutan" value="{{ old('urutan') }}" placeholder="Contoh: 1">
                @error('urutan') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="nip">NIP</label>
                <input type="text" class="btr-input" id="nip" name="nip" value="{{ old('nip') }}">
                @error('nip') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="jenis_kepegawaian">Jenis Kepegawaian</label>
                <input type="text" class="btr-input" id="jenis_kepegawaian" name="jenis_kepegawaian" value="{{ old('jenis_kepegawaian', 'PNS') }}">
                @error('jenis_kepegawaian') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="pangkat_golongan">Pangkat / Golongan</label>
                <input type="text" class="btr-input" id="pangkat_golongan" name="pangkat_golongan" value="{{ old('pangkat_golongan') }}">
                @error('pangkat_golongan') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="jabatan">Jabatan</label>
                <input type="text" class="btr-input" id="jabatan" name="jabatan" value="{{ old('jabatan') }}">
                @error('jabatan') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="instansi">Instansi</label>
                <input type="text" class="btr-input" id="instansi" name="instansi" value="{{ old('instansi', 'Balai Teknik Rawa') }}">
                @error('instansi') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="email">Email</label>
                <input type="email" class="btr-input" id="email" name="email" value="{{ old('email') }}">
                @error('email') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label">Foto <small style="color:var(--text-muted)">(Max 1MB)</small></label>
                <img class="img-preview" src="" alt="" style="display:none;max-width:220px;border-radius:10px;margin-bottom:10px">
                <div class="btr-file-row">
                    <label class="btr-file-pill">
                        <span class="btr-file-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16V8m0 0l-3 3m3-3l3 3"/></svg>
                        </span>
                        <input type="file" id="path_image" name="path_image" onchange="btrPreview(this,'.img-preview')">
                    </label>
                </div>
                @error('path_image') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-actions">
                <a href="{{ url('dashboard/info-pegawai') }}" class="btr-btn btr-btn-outline">Batal</a>
                <button type="submit" class="btr-btn">Simpan</button>
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
