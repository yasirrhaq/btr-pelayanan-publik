@extends('pelanggan.layouts.main')

@section('container')
    @php $user = auth()->user(); @endphp

    <style>
        .btr-profile-edit-shell {
            max-width: 860px;
        }
        .btr-profile-edit-card {
            background: #fff;
            border-radius: 24px;
            box-shadow: var(--shadow-card);
            padding: 28px;
        }
        .btr-profile-edit-heading {
            margin: 0 0 22px;
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
        }
        .btr-profile-edit-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px 20px;
        }
        .btr-profile-edit-grid .full {
            grid-column: 1 / -1;
        }
        .btr-readonly-box {
            min-height: 44px;
            padding: 11px 16px;
            border: 1.5px solid var(--border-soft);
            border-radius: var(--radius-input);
            background: #F8FAFC;
            color: var(--text-muted);
            font-size: 13px;
            display: flex;
            align-items: center;
        }
        .btr-field-note {
            margin-top: 8px;
            font-size: 12px;
            color: var(--text-muted);
            line-height: 1.5;
        }
        .btr-form-error {
            margin-top: 8px;
            font-size: 12px;
            color: var(--danger-red);
        }
        .btr-photo-chip {
            display: flex;
            align-items: center;
            gap: 14px;
            border: 1.5px dashed var(--border-soft);
            border-radius: 16px;
            padding: 14px;
            background: #F8FAFC;
        }
        .btr-photo-chip-preview {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            overflow: hidden;
            background: #E5E7EB;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .btr-photo-chip-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        @media (max-width: 900px) {
            .btr-profile-edit-card {
                padding: 22px 18px;
            }
            .btr-profile-edit-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="btr-profile-edit-shell">
        <h1 class="btr-page-title">Edit Profil Pelanggan</h1>

        <div class="btr-profile-edit-card">
            <h2 class="btr-profile-edit-heading">Perbarui Informasi Akun</h2>

            <form method="POST" action="{{ route('pelanggan.profil.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="btr-profile-edit-grid">
                    <div>
                        <label class="btr-label" for="name">Nama Pelanggan</label>
                        <input id="name" name="name" type="text" class="btr-input" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="btr-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="btr-label" for="email">Email</label>
                        <input id="email" name="email" type="email" class="btr-input" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="btr-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="btr-label" for="kategori_instansi_id">Kategori Instansi</label>
                        <select id="kategori_instansi_id" name="kategori_instansi_id" class="btr-select">
                            <option value="">Pilih kategori instansi</option>
                            @foreach ($kategoriInstansi as $item)
                                <option value="{{ $item->id }}" {{ (string) old('kategori_instansi_id', $user->kategori_instansi_id) === (string) $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                            @endforeach
                        </select>
                        @error('kategori_instansi_id')
                            <div class="btr-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="btr-label" for="instansi">Nama Instansi</label>
                        <input id="instansi" name="instansi" type="text" class="btr-input" value="{{ old('instansi', $user->instansi) }}" required>
                        @error('instansi')
                            <div class="btr-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="btr-label" for="no_hp">No. Telp (wa)</label>
                        <input id="no_hp" name="no_hp" type="text" class="btr-input" value="{{ old('no_hp', $user->no_hp) }}">
                        @error('no_hp')
                            <div class="btr-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="btr-label">Username</label>
                        <div class="btr-readonly-box">{{ $user->username }}</div>
                        <div class="btr-field-note">Username dikunci agar identitas login tetap konsisten.</div>
                    </div>

                    <div class="full">
                        <label class="btr-label" for="alamat">Alamat</label>
                        <textarea id="alamat" name="alamat" class="btr-textarea" required>{{ old('alamat', $user->alamat) }}</textarea>
                        @error('alamat')
                            <div class="btr-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="full">
                        <label class="btr-label">NIK / No. Paspor / NIM</label>
                        <div class="btr-readonly-box">{{ $user->no_id }}</div>
                        <div class="btr-field-note">Nomor identitas tidak bisa diubah sendiri untuk menjaga validitas akun terdaftar.</div>
                    </div>

                    <div class="full">
                        <label class="btr-label" for="foto_profile">Foto Profil</label>
                        <div class="btr-photo-chip">
                            <div class="btr-photo-chip-preview">
                                @if (!empty($user->foto_profile))
                                    <img src="{{ imageExists($user->foto_profile) }}" alt="{{ $user->name }}">
                                @else
                                    <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                @endif
                            </div>
                            <div style="flex:1; min-width:0;">
                                <input id="foto_profile" name="foto_profile" type="file" class="btr-input" accept="image/*">
                                <div class="btr-field-note">Opsional. JPG/PNG/WebP, maksimal 1 MB.</div>
                            </div>
                        </div>
                        @error('foto_profile')
                            <div class="btr-form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="btr-form-actions">
                    <a href="{{ route('pelanggan.profil') }}" class="btr-btn btr-btn-outline">Batal</a>
                    <a href="{{ route('pelanggan.profil.password') }}" class="btr-btn btr-btn-outline">Ubah Password</a>
                    <button type="submit" class="btr-btn">Simpan Profil</button>
                </div>
            </form>
        </div>
    </div>
@endsection
