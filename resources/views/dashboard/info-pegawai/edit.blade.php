@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Profil - SDM <small>Edit Pegawai</small></h1>

    <div class="btr-card">
        <form method="post" action="{{ url('dashboard/info-pegawai/' . $infoPegawai->id) }}" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="btr-form-group">
                <label class="btr-label" for="title">Nama Pegawai</label>
                <input type="text" class="btr-input" id="title" name="title" required autofocus value="{{ old('title', $infoPegawai->title) }}">
                @error('title') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="urutan">Urutan Tampil</label>
                <input type="number" min="1" class="btr-input" id="urutan" name="urutan" value="{{ old('urutan', $infoPegawai->urutan) }}" placeholder="Contoh: 1">
                @error('urutan') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="nip">NIP</label>
                <input type="text" class="btr-input" id="nip" name="nip" value="{{ old('nip', $infoPegawai->nip) }}">
                @error('nip') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="jenis_kepegawaian">Jenis Kepegawaian</label>
                <input type="text" class="btr-input" id="jenis_kepegawaian" name="jenis_kepegawaian" value="{{ old('jenis_kepegawaian', $infoPegawai->jenis_kepegawaian ?: 'PNS') }}">
                @error('jenis_kepegawaian') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="pangkat_golongan">Pangkat / Golongan</label>
                <input type="text" class="btr-input" id="pangkat_golongan" name="pangkat_golongan" value="{{ old('pangkat_golongan', $infoPegawai->pangkat_golongan) }}">
                @error('pangkat_golongan') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="jabatan">Jabatan</label>
                <input type="text" class="btr-input" id="jabatan" name="jabatan" value="{{ old('jabatan', $infoPegawai->jabatan) }}">
                @error('jabatan') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="instansi">Instansi</label>
                <input type="text" class="btr-input" id="instansi" name="instansi" value="{{ old('instansi', $infoPegawai->instansi ?: 'Balai Teknik Rawa') }}">
                @error('instansi') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="email">Email</label>
                <input type="email" class="btr-input" id="email" name="email" value="{{ old('email', $infoPegawai->email) }}">
                @error('email') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label">Foto <small style="color:var(--text-muted)">(Max 1MB)</small></label>
                <input type="hidden" name="oldImage" value="{{ $infoPegawai->path_image }}">
                <input type="hidden" id="remove_image" name="remove_image" value="0">
                @if ($infoPegawai->path_image)
                    <div id="pegawai-preview-wrap" style="display:block;position:relative;max-width:280px;margin-bottom:12px;">
                        <div id="pegawai-preview-card" style="display:flex;align-items:center;gap:14px;padding:14px 16px;border:1px solid var(--border-soft);border-radius:16px;background:#fff;">
                            <img src="{{ asset($infoPegawai->path_image) }}" class="img-preview" style="display:block;width:72px;height:72px;object-fit:cover;border-radius:12px;border:1px solid var(--border-soft);flex-shrink:0;">
                            <div style="min-width:0;flex:1;">
                                <div style="font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ basename($infoPegawai->path_image) }}</div>
                                <div style="font-size:12px;color:var(--text-muted);margin-top:4px;">Pratinjau foto pegawai</div>
                                <a href="{{ asset($infoPegawai->path_image) }}" target="_blank" style="font-size:12px;color:var(--info-blue);text-decoration:none;">Lihat file</a>
                            </div>
                        </div>
                        <button type="button" onclick="btrClearPegawaiImage()" style="position:absolute;top:8px;right:8px;width:28px;height:28px;border:none;border-radius:999px;background:rgba(15,23,42,.75);color:#fff;cursor:pointer;font-size:16px;line-height:1;">&times;</button>
                    </div>
                @else
                    <div id="pegawai-preview-wrap" style="display:none;position:relative;max-width:280px;margin-bottom:12px;">
                        <div id="pegawai-preview-card" style="display:flex;align-items:center;gap:14px;padding:14px 16px;border:1px solid var(--border-soft);border-radius:16px;background:#fff;"></div>
                        <button type="button" onclick="btrClearPegawaiImage()" style="position:absolute;top:8px;right:8px;width:28px;height:28px;border:none;border-radius:999px;background:rgba(15,23,42,.75);color:#fff;cursor:pointer;font-size:16px;line-height:1;">&times;</button>
                    </div>
                    <img class="img-preview" src="" alt="" style="display:none;width:72px;height:72px;object-fit:cover;border-radius:12px;border:1px solid var(--border-soft);flex-shrink:0;">
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
                <a href="{{ url('dashboard/info-pegawai') }}" class="btr-btn btr-btn-outline">Batal</a>
                <button type="submit" class="btr-btn">Update</button>
            </div>
        </form>
    </div>

    <script>
        function btrPreview(input, sel) {
            var img = document.querySelector(sel);
            var file = input.files && input.files[0];
            if (!file) return;

            document.getElementById('remove_image').value = '0';

            var r = new FileReader();
            r.onload = function (e) {
                img.src = e.target.result;
                img.style.display = 'block';
                document.getElementById('pegawai-preview-card').innerHTML =
                    '<img src="' + e.target.result + '" alt="Preview" class="img-preview" style="display:block;width:72px;height:72px;object-fit:cover;border-radius:12px;border:1px solid var(--border-soft);flex-shrink:0;">' +
                    '<div style="min-width:0;flex:1;">' +
                        '<div style="font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + file.name + '</div>' +
                        '<div style="font-size:12px;color:var(--text-muted);margin-top:4px;">Pratinjau foto pegawai</div>' +
                    '</div>';
                document.getElementById('pegawai-preview-wrap').style.display = 'block';
            };
            r.readAsDataURL(file);
        }

        function btrClearPegawaiImage() {
            document.getElementById('image').value = '';
            document.getElementById('remove_image').value = '1';
            document.getElementById('pegawai-preview-card').innerHTML = '';
            document.getElementById('pegawai-preview-wrap').style.display = 'none';
            var img = document.querySelector('.img-preview');
            if (img) {
                img.src = '';
                img.style.display = 'none';
            }
        }
    </script>
@endsection
