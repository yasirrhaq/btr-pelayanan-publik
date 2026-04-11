@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Buat Status Layanan Baru</h1>
    </div>

    <div class="col-lg-8">
        <form method="post" action="{{url('')}}/dashboard/status-layanan" class="mb-5" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                    name="email" required autofocus value={{ old('email') }}>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="statusLayanan" class="form-label">Jenis Layanan</label>
                <select name="layanan_id" class="form-select">
                    @foreach ($jenisLayanan as $layanan)
                        @if (old('layanan_id') == $layanan->id)
                            <option value="{{ $layanan->id }}" selected> {{ $layanan->name }}</option>
                        @else
                            <option value="{{ $layanan->id }}"> {{ $layanan->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="statusLayanan" class="form-label">Status Layanan</label>
                <select name="status_id" class="form-select">
                    @foreach ($statusLayanan as $status)
                        @if (old('status_id') == $status->id)
                            <option value="{{ $status->id }}" selected> {{ $status->name }}</option>
                        @else
                            <option value="{{ $status->id }}"> {{ $status->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="detail" class="form-label @error('detail') is-invalid @enderror">Detail Status</label>
                <input type="text" name="detail" class="form-control" id="detail" required
                    value={{ old('detail') }}>
                @error('detail')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Buat Status Layanan</button>
        </form>
    </div>
@endsection
