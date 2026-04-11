@extends('frontend.layouts.mainAuth')

@section('container')
<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-8 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="d-flex justify-content-center">
                                <img src="{{ asset('assets/logo.png') }}"/>
                            </div>
                            <div class="d-flex justify-content-center">
                                        <div class="text-content-login">
                                            <p class="title-header-login"> {{config('app.name')}}  </p>
                                            <p class="title-header-login2">Direktorat Jenderal Sumber Daya Air </p>
                                            <h1 class="text-header-login">
                                            Kementerian Pekerjaan Umum dan Perumahan Rakyat
                                            </h1>
                                        </div>
                                    </div>
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Register Akun</h1>
                            </div>
                            <form action="{{url('')}}/register" method="POST" enctype="multipart/form-data" class="user">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="name" class="form-control form-control-user @error('name') is-invalid @enderror" id="exampleFirstName"
                                            placeholder="Name" required value="{{ old('name') }}">
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message . ' Must be only include alphabet (a-z, A-Z)' }}
                                                </div>
                                            @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="username" class="form-control form-control-user @error('username') is-invalid @enderror" id="exampleLastName"
                                            placeholder="Username" required value="{{ old('username') }}">
                                            @error('username')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="exampleInputEmail"
                                    placeholder="Your Email" required value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="password" class="form-control form-control-user @error('password') is-invalid @enderror"
                                            id="exampleInputPassword" placeholder="Password" required>
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message . ' Your password must be contain at least one number and letters.' }}
                                                </div>
                                            @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" name="password_confirmation" class="form-control form-control-user @error('password_confirmation') is-invalid @enderror"
                                            id="exampleRepeatPassword" placeholder="Repeat Password" required>
                                            @error('password_confirmation')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="foto_profile" class="form-label">Foto Profil</label>
                                    <input class="form-control @error('foto_profile') is-invalid @enderror" type="file"
                                        id="foto_profile" name="foto_profile">
                                    @error('foto_profile')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="text" name="alamat" class="form-control form-control-user @error('alamat') is-invalid @enderror" id="exampleInputEmail"
                                        placeholder="Alamat" required value="{{ old('alamat') }}">
                                        @error('alamat')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                </div>
                                <div class="form-group">
                                    <input type="text" name="no_id" class="form-control form-control-user @error('no_id') is-invalid @enderror" id="exampleInputEmail"
                                        placeholder="NIK/No Paspor/NIM" required value="{{ old('no_id') }}">
                                        @error('no_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                </div>
                                <div class="form-group">
                                    <input type="text" name="instansi" class="form-control form-control-user @error('instansi') is-invalid @enderror" id="exampleInputEmail"
                                        placeholder="Instansi" required value="{{ old('instansi') }}">
                                        @error('instansi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                </div>
                                <button class="btn btn-primary btn-user btn-block" type="submit">Register</button>
                                <hr>
                            </form>
                            <div class="text-center">
                                <a class="small" href="{{url('')}}/forgot-password">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="{{url('')}}/login">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
