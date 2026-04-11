@extends('frontend.layouts.mainAuth')

@section('container')
    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-6 col-lg-6 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="d-flex justify-content-center">
                                    <img src="{{ asset('assets/logo.png') }}" />
                                </div>
                                <div class="d-flex justify-content-center">
                                        <div class="text-content-login">
                                            <p class="title-header-login"> {{ config("app.name") }} </p>
                                            <p class="title-header-login2">Direktorat Jenderal Sumber Daya Air </p>
                                            <h1 class="text-header-login">
                                            Kementerian Pekerjaan Umum dan Perumahan Rakyat
                                            </h1>
                                        </div>
                                    </div>
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Forgot Password!</h1>
                                </div>
                                @if (session()->has('success'))
                                    <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                                        {{ session('success') }}

                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                @if (session()->has('emailNotFound'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('emailNotFound') }}

                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                <form action="{{url('')}}/forgot-password" method="post" class="user">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" name="email"
                                            class="form-control form-control-user @error('email') is-invalid @enderror"
                                            id="email" aria-describedby="emailHelp" placeholder="Your Email"
                                            autofocus required value={{ old('email') }}>
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <button class="btn btn-primary btn-user btn-block" type="submit">Reset
                                        Password</button>
                                    <hr>
                                </form>
                                <div class="text-center">
                                    <a class="small" href="{{url('')}}/login">Have an account? Login Now!</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="{{url('')}}/register">Or , Create an Account!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
