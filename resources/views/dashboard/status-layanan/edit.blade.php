@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Status Layanan</h1>
    </div>

    <div class="col-lg-8">
        <form method="post" action="{{url('')}}/dashboard/status-layanan/{{ $statusLayanan->id }}" class="mb-5"
            enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                    required autofocus value="{{ old('email', $statusLayanan->user->email) }}">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="statusLayanan" class="form-label">Status Layanan</label>
                <select name="status_id" class="form-select">
                    @foreach ($status as $stat)
                        @php
                            $selected = '';
                            if($stat->id == $statusLayanan->status_id)
                                $selected = 'selected';
                        @endphp
                        <option value="{{ $stat->id }}" {{ $selected }}> {{ $stat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="detail" class="form-label @error('detail') is-invalid @enderror">Detail Status</label>
                <input type="text" name="detail" class="form-control" id="detail" required
                    value="{{ old('detail', $statusLayanan->detail) }}">
                @error('detail')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update Status Layanan</button>
        </form>
    </div>
@endsection
