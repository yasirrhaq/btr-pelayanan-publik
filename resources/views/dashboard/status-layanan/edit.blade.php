@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Status Layanan <small>Edit Status</small></h1>

    <div class="btr-card">
        <form method="post" action="{{ url('dashboard/status-layanan/' . $statusLayanan->id) }}" enctype="multipart/form-data">
            @method('put')
            @csrf

            <div class="btr-form-group">
                <label class="btr-label" for="email">Email User</label>
                <input type="text" class="btr-input" id="email" name="email" required autofocus value="{{ old('email', $statusLayanan->user->email) }}">
                @error('email') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="status_id">Status Layanan</label>
                <select name="status_id" id="status_id" class="btr-input">
                    @foreach ($status as $stat)
                        <option value="{{ $stat->id }}" {{ $stat->id == $statusLayanan->status_id ? 'selected' : '' }}>{{ $stat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="detail">Detail Status</label>
                <input type="text" class="btr-input" id="detail" name="detail" required value="{{ old('detail', $statusLayanan->detail) }}">
                @error('detail') <small style="color:var(--danger-red)">{{ $message }}</small> @enderror
            </div>

            <div class="btr-form-actions">
                <a href="{{ url('dashboard/status-layanan') }}" class="btr-btn btr-btn-outline">Batal</a>
                <button type="submit" class="btr-btn">Update</button>
            </div>
        </form>
    </div>
@endsection
