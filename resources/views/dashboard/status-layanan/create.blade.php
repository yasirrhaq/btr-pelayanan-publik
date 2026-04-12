@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Status Layanan <small>Buat Status Baru</small></h1>

    <div class="btr-card">
        <form method="post" action="{{ url('dashboard/status-layanan') }}" enctype="multipart/form-data">
            @csrf

            <div class="btr-form-group">
                <label class="btr-label" for="email">Email User</label>
                <input type="text" class="btr-input" id="email" name="email" required autofocus value="{{ old('email') }}">
                @error('email') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="layanan_id">Jenis Layanan</label>
                <select name="layanan_id" id="layanan_id" class="btr-input">
                    @foreach ($jenisLayanan as $layanan)
                        <option value="{{ $layanan->id }}" {{ old('layanan_id') == $layanan->id ? 'selected' : '' }}>{{ $layanan->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="status_id">Status Layanan</label>
                <select name="status_id" id="status_id" class="btr-input">
                    @foreach ($statusLayanan as $status)
                        <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="detail">Detail Status</label>
                <input type="text" class="btr-input" id="detail" name="detail" required value="{{ old('detail') }}">
                @error('detail') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-actions">
                <a href="{{ url('dashboard/status-layanan') }}" class="btr-btn btr-btn-outline">Batal</a>
                <button type="submit" class="btr-btn">Simpan</button>
            </div>
        </form>
    </div>
@endsection
