@extends('frontend.layouts.mainAuth')

@section('container')

        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-6 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="d-flex justify-content-center">
                                        <img src="{{ asset('assets/logo.png') }}"/>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <div class="text-content-login">
                                            <p class="title-header-login"> {{ config('app.name') }} </p>
                                            <p class="title-header-login2">Direktorat Jenderal Sumber Daya Air </p>
                                            <h1 class="text-header-login">
                                            Kementerian Pekerjaan Umum
                                            </h1>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                    </div>
                                    @if (session()->has('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}

                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                @if (session()->has('loginError'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('loginError') }}

                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                    <form action="login" method="post" class="user mt-5">
                                    	@csrf
                                        <div class="form-group">
                                        <input type="email" name="email" class="form-control form-control-user @error('email') is-invalid @enderror"
                                                id="email" aria-describedby="emailHelp"
                                                placeholder="Your Email" autofocus required value={{ old('email') }}>
                                                @error('email')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="password" placeholder="Password" required>
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block" type="submit">Login</button>
                                        <hr>
                                    </form>
                                    <div class="text-center">
                                        <a class="small" href="{{url('')}}/forgot-password">Lupa Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="{{url('')}}/register">Belum Punya Akun ? Daftar!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

@endsection

