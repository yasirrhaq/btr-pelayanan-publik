@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Setting</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success col-lg-6" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('deleteError'))
        <div class="alert alert-danger col-lg-6" role="alert">
            {{ session('deleteError') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <!-- <div class="table-responsive col-lg-6"> -->
    <form method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-2">
                    <label for="name">Debug</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" name="debug" type="checkbox" id="flexSwitchCheckDefault"
                            @if (config('app.debug')) checked @endif value="true">
                        <label class="form-check-label" for="flexSwitchCheckDefault">On</label>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="name">APPS Name</label>
                    <input type="text" class="form-control" name="name" value="{{ config('app.name') }}">
                    <small class="badge bg-info">{{ date('Y-m-d H:i:s') }}</small>
                </div>
                <div class="form-group mb-2">
                    <img class="img-preview img-fluid mb-3 col-sm-5" src="{{ imageExists(config('app.logo')) }}" alt="">
                    <br>
                    <label for="logo" class="form-label">Logo (Max File Size: 1MB)</label>
                    <input class="form-control @error('logo') is-invalid @enderror" type="file" id="logo"
                        name="logo" onchange="previewlogo()">
                </div>
                <div class="form-group mb-2">
                    <img class="img-preview-logo-text img-fluid mb-3 col-sm-5" src="{{ imageExists(config('app.logoText')) }}" alt="">
                    <br>
                    <label for="logoText" class="form-label">LogoText (Max File Size: 1MB)</label>
                    <input class="form-control @error('logoText') is-invalid @enderror" type="file" id="logoText"
                        name="logoText" onchange="previewlogoText()">
                </div>
                <div class="form-group mb-2">
                    <label for="name">Timezone</label>
                    <input type="text" class="form-control" name="timezone" value="{{ config('app.timezone') }}">
                    <small class="badge bg-info">{{ date('Y-m-d H:i:s') }}</small>
                </div>
                <div class="form-group mb-2">
                    <label for="name">Format Date</label>
                    <input type="text" class="form-control" name="custom_format_date"
                        value="{{ config('app.custom_format_date') }}">
                    <small
                        class="badge bg-info">{{ \Carbon\Carbon::parse(now())->format(config('app.custom_format_date')) }}</small>
                </div>
                <div class="form-group mb-2">
                    <label for="name">Format Date Time</label>
                    <input type="text" class="form-control" name="custom_format_time"
                        value="{{ config('app.custom_format_time') }}">
                    <small
                        class="badge bg-info">{{ \Carbon\Carbon::parse(now())->format(config('app.custom_format_time')) }}</small>
                </div>
                <div class="form-group mb-2">
                    <label for="name">mail_host</label>
                    <input type="text" class="form-control" name="mail_host" value="{{ config('app.mail_host') }}">
                </div>
                <div class="form-group mb-2">
                    <label for="name">mail_port</label>
                    <input type="text" class="form-control" name="mail_port" value="{{ config('app.mail_port') }}">
                </div>
                <div class="form-group mb-2">
                    <label for="name">mail_username</label>
                    <input type="text" class="form-control" name="mail_username"
                        value="{{ config('app.mail_username') }}">
                </div>
                <div class="form-group mb-2">
                    <label for="name">mail_password</label>
                    <input type="text" class="form-control" name="mail_password"
                        value="{{ config('app.mail_password') }}">
                </div>
                <div class="form-group mb-2">
                    <label for="name">mail_encryption</label>
                    <input type="text" class="form-control" name="mail_encryption"
                        value="{{ config('app.mail_encryption') }}">
                </div>
                <div class="form-group mb-2">
                    <label for="name">mail_from_address</label>
                    <input type="text" class="form-control" name="mail_from_address"
                        value="{{ config('app.mail_from_address') }}">
                </div>
                <div class="form-group mb-2">
                    <label for="name">mail_from_name</label>
                    <input type="text" class="form-control" name="mail_from_name"
                        value="{{ config('app.mail_from_name') }}">
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <button type="submit" class="btn btn-primary"> Simpan </button>
            </div>
        </div>
    </form>
    <!-- </div> -->
@endsection
@push('js')
    <script type="text/javascript">
        function previewlogo() {
            const logo = document.querySelector('#logo');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(logo.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
        function previewlogoText() {
            const logoText = document.querySelector('#logoText');
            const imgPreview = document.querySelector('.img-preview-logo-text');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(logoText.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
@endpush
