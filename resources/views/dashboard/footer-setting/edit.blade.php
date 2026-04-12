@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Footer <small>Edit Footer</small></h1>

    <div class="btr-card">
        <form method="post" action="{{ url('dashboard/footer-setting/' . $footer_setting->id) }}" enctype="multipart/form-data">
            @method('put')
            @csrf

            <div class="btr-form-group">
                <label class="btr-label" for="nama_kementerian">Nama Kementerian</label>
                <input type="text" class="btr-input" id="nama_kementerian" name="nama_kementerian" required autofocus value="{{ old('nama_kementerian', $footer_setting->nama_kementerian) }}">
                @error('nama_kementerian') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="alamat">Alamat</label>
                <input type="text" class="btr-input" id="alamat" name="alamat" required value="{{ old('alamat', $footer_setting->alamat) }}">
                @error('alamat') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="no_hp">Nomor Telepon</label>
                <input type="text" class="btr-input" id="no_hp" name="no_hp" required value="{{ old('no_hp', $footer_setting->no_hp) }}">
                @error('no_hp') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="email">Email</label>
                <input type="text" class="btr-input" id="email" name="email" required value="{{ old('email', $footer_setting->email) }}">
                @error('email') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-actions">
                <a href="{{ url('dashboard/footer-setting') }}" class="btr-btn btr-btn-outline">Batal</a>
                <button type="submit" class="btr-btn">Update</button>
            </div>
        </form>
    </div>
@endsection
