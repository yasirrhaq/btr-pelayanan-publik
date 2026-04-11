@extends('profile.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Change Password</h1>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="col-lg-8">
        <form method="POST" action="{{ route('change.password') }}">
            @csrf
            <div class="form-group row mb-3">

                <label for="password" class="col-md-4 col-form-label text-md-right">Current Password</label>
                <div class="col-md-6">
                    <input id="password" type="password"
                        class="form-control @error('current_password') is-invalid @enderror" name="current_password"
                        autocomplete="current-password" required>
                    @error('current_password')
                        <div class="invalid-feedback">
                            {{ "Current password didn't match!" }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>

                <div class="col-md-6">
                    <input id="new_password" type="password"
                        class="form-control @error('new_password') is-invalid @enderror" name="new_password"
                        autocomplete="current-password" required>
                    @error('new_password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-right">New Confirm Password</label>

                <div class="col-md-6">
                    <input id="new_confirm_password" type="password"
                        class="form-control @error('current_password') is-invalid @enderror" name="new_confirm_password" required>

                    @error('new_confirm_password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        Update Password
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
