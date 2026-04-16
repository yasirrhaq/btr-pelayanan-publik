@extends('frontend.layouts.mainAuth')

@section('page-title', 'Daftar Akun')

@section('auth-content')
<div class="min-h-screen bg-gray-50 flex flex-col">

    {{-- ===== TOP HEADER STRIP ===== --}}
    <div class="bg-btr">
        <div class="max-w-3xl mx-auto px-5 py-4 flex items-center gap-4">
            <div class="bg-white/10 rounded-xl p-2.5 flex-shrink-0">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo BTR" class="w-9 h-9 object-contain">
            </div>
            <div>
                <p class="text-white font-bold text-sm tracking-wide">BALAI TEKNIK RAWA</p>
                <p class="text-blue-200 text-[11px]">Direktorat Jenderal Sumber Daya Air — Kementerian Pekerjaan Umum</p>
            </div>
            <div class="ml-auto hidden sm:block">
                <a href="{{ url('/login') }}"
                   class="flex items-center gap-1.5 text-xs font-medium text-blue-200 hover:text-white transition-colors">
                    <i class="fas fa-arrow-left text-[10px]"></i>
                    Sudah punya akun?
                </a>
            </div>
        </div>
    </div>

    {{-- Gold accent bar --}}
    <div class="h-1 bg-gradient-to-r from-btr-gold via-yellow-300 to-btr-gold"></div>

    {{-- ===== FORM CARD ===== --}}
    <div class="flex-1 py-8 px-4 sm:px-6">
        <div class="max-w-3xl mx-auto animate-fade-in">

            {{-- Page heading --}}
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Buat Akun Baru</h2>
                <p class="text-gray-500 text-sm mt-1">
                    Lengkapi formulir di bawah untuk mendaftar sebagai pengguna layanan BTR
                </p>
            </div>

            {{-- Validation summary --}}
            @if (session('authExpired'))
                <div class="flex items-start gap-3 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl px-4 py-3 mb-6 text-sm">
                    <i class="fas fa-clock-rotate-left mt-0.5 text-amber-500 flex-shrink-0"></i>
                    <span>{{ session('authExpired') }}</span>
                </div>
            @endif
            @if ($errors->any())
                <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3 mb-6 text-sm">
                    <i class="fas fa-triangle-exclamation mt-0.5 text-red-500 flex-shrink-0"></i>
                    <div>
                        <p class="font-semibold mb-1">Terdapat beberapa kesalahan:</p>
                        <ul class="list-disc list-inside space-y-0.5 text-xs">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ url('/register') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                {{-- ---- Section 1: Identitas Akun ---- --}}
                <div class="bg-white rounded-2xl border-2 border-gray-400 shadow-md overflow-hidden">
                    <div class="bg-btr/5 border-b-2 border-gray-400 px-5 py-3 flex items-center gap-2">
                        <div class="w-6 h-6 rounded-lg bg-btr flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user text-white text-[10px]"></i>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-700">Identitas Akun</h3>
                    </div>
                    <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">

                        {{-- Name --}}
                        <div>
                            <label for="name" class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                                Nama Lengkap <span class="text-red-400">*</span>
                            </label>
                            <input type="text" id="name" name="name"
                                   value="{{ old('name') }}"
                                   placeholder="Nama sesuai identitas"
                                   class="auth-input @error('name') is-invalid @enderror"
                                   required>
                            @error('name')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <i class="fas fa-circle-exclamation"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Username --}}
                        <div>
                            <label for="username" class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                                Username <span class="text-red-400">*</span>
                            </label>
                            <input type="text" id="username" name="username"
                                   value="{{ old('username') }}"
                                   placeholder="Nama pengguna unik"
                                   class="auth-input @error('username') is-invalid @enderror"
                                   required>
                            @error('username')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <i class="fas fa-circle-exclamation"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="sm:col-span-2">
                            <label for="email" class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                                Alamat Email <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 pointer-events-none">
                                    <i class="fas fa-envelope text-xs"></i>
                                </span>
                                <input type="email" id="email" name="email"
                                       value="{{ old('email') }}"
                                       placeholder="contoh@email.com"
                                       class="auth-input pl-10 @error('email') is-invalid @enderror"
                                       required>
                            </div>
                            @error('email')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <i class="fas fa-circle-exclamation"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="password" class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                                Kata Sandi <span class="text-red-400">*</span>
                            </label>
                            <div class="relative" x-data="{ show: false }">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 pointer-events-none">
                                    <i class="fas fa-lock text-xs"></i>
                                </span>
                                <input :type="show ? 'text' : 'password'"
                                       id="password" name="password"
                                       placeholder="Min. 8 karakter"
                                       class="auth-input pl-10 pr-10 @error('password') is-invalid @enderror"
                                       autocomplete="new-password"
                                       required>
                                <button type="button" @click="show = !show"
                                        class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 cursor-pointer transition-colors">
                                    <i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-xs"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <i class="fas fa-circle-exclamation"></i> {{ $message }} Harus mengandung huruf dan angka.
                                </p>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div>
                            <label for="password_confirmation" class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                                Konfirmasi Sandi <span class="text-red-400">*</span>
                            </label>
                            <div class="relative" x-data="{ show: false }">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 pointer-events-none">
                                    <i class="fas fa-lock text-xs"></i>
                                </span>
                                <input :type="show ? 'text' : 'password'"
                                       id="password_confirmation" name="password_confirmation"
                                       placeholder="Ulangi kata sandi"
                                       class="auth-input pl-10 pr-10 @error('password_confirmation') is-invalid @enderror"
                                       autocomplete="new-password"
                                       required>
                                <button type="button" @click="show = !show"
                                        class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 cursor-pointer transition-colors">
                                    <i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-xs"></i>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <i class="fas fa-circle-exclamation"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- ---- Section 2: Data Diri ---- --}}
                <div class="bg-white rounded-2xl border-2 border-gray-400 shadow-md overflow-hidden">
                    <div class="bg-btr/5 border-b-2 border-gray-400 px-5 py-3 flex items-center gap-2">
                        <div class="w-6 h-6 rounded-lg bg-btr flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-id-card text-white text-[10px]"></i>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-700">Data Diri</h3>
                    </div>
                    <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">

                        {{-- No ID --}}
                        <div>
                            <label for="no_id" class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                                NIK / No. Paspor / NIM <span class="text-red-400">*</span>
                            </label>
                            <input type="text" id="no_id" name="no_id"
                                   value="{{ old('no_id') }}"
                                   placeholder="Nomor identitas"
                                   class="auth-input @error('no_id') is-invalid @enderror"
                                   required>
                            @error('no_id')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <i class="fas fa-circle-exclamation"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Instansi --}}
                        <div>
                            <label for="instansi" class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                                Instansi / Lembaga <span class="text-red-400">*</span>
                            </label>
                            <input type="text" id="instansi" name="instansi"
                                   value="{{ old('instansi') }}"
                                   placeholder="Nama instansi atau lembaga"
                                   class="auth-input @error('instansi') is-invalid @enderror"
                                   required>
                            @error('instansi')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <i class="fas fa-circle-exclamation"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Alamat --}}
                        <div class="sm:col-span-2">
                            <label for="alamat" class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                                Alamat <span class="text-red-400">*</span>
                            </label>
                            <input type="text" id="alamat" name="alamat"
                                   value="{{ old('alamat') }}"
                                   placeholder="Alamat lengkap"
                                   class="auth-input @error('alamat') is-invalid @enderror"
                                   required>
                            @error('alamat')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <i class="fas fa-circle-exclamation"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Foto Profile --}}
                        <div class="sm:col-span-2" x-data="{ preview: null }">
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                                Foto Profil <span class="text-gray-400 font-normal normal-case">(opsional, maks. 1 MB)</span>
                            </label>
                            <label for="foto_profile"
                                   class="flex items-center gap-3 cursor-pointer border-2 border-dashed border-gray-200 rounded-xl px-4 py-3 hover:border-btr hover:bg-btr/5 transition-all duration-200 group">
                                <template x-if="!preview">
                                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0 group-hover:bg-btr/10 transition-colors">
                                        <i class="fas fa-image text-gray-400 group-hover:text-btr text-sm transition-colors"></i>
                                    </div>
                                </template>
                                <template x-if="preview">
                                    <img :src="preview" class="w-10 h-10 rounded-lg object-cover flex-shrink-0">
                                </template>
                                <div>
                                    <p class="text-xs font-medium text-gray-600 group-hover:text-btr transition-colors">
                                        Klik untuk memilih foto
                                    </p>
                                    <p class="text-[11px] text-gray-400">JPG, PNG — Maks. 1 MB</p>
                                </div>
                            </label>
                            <input type="file" id="foto_profile" name="foto_profile"
                                   accept="image/*"
                                   class="hidden @error('foto_profile') is-invalid @enderror"
                                   @change="const f = $event.target.files[0]; if(f) { const r = new FileReader(); r.onload = e => preview = e.target.result; r.readAsDataURL(f); }">
                            @error('foto_profile')
                                <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                                    <i class="fas fa-circle-exclamation"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- ---- Section 3: Verifikasi Keamanan ---- --}}
                <div class="bg-white rounded-2xl border-2 border-gray-400 shadow-md overflow-hidden">
                    <div class="bg-btr/5 border-b-2 border-gray-400 px-5 py-3 flex items-center gap-2">
                        <div class="w-6 h-6 rounded-lg bg-btr flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-shield-halved text-white text-[10px]"></i>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-700">Verifikasi Keamanan</h3>
                    </div>
                    <div class="p-5">
                        <div class="bg-gray-50 rounded-xl border-2 border-gray-400 p-3 space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="captcha-img flex-shrink-0">
                                    {!! captcha_img('flat') !!}
                                </div>
                                <button type="button"
                                        onclick="this.closest('div').querySelector('img').src='/captcha/flat?'+Math.random()"
                                        class="flex items-center gap-1.5 text-xs text-btr hover:text-btr-gold font-medium transition-colors cursor-pointer px-2 py-1 rounded-lg hover:bg-btr/5">
                                    <i class="fas fa-arrows-rotate text-[10px]"></i>
                                    <span>Refresh</span>
                                </button>
                            </div>
                            <input type="text" name="captcha"
                                   placeholder="Ketik kode di atas"
                                   class="auth-input @error('captcha') is-invalid @enderror"
                                   autocomplete="off" required>
                            @error('captcha')
                                <p class="text-xs text-red-600 flex items-center gap-1">
                                    <i class="fas fa-circle-exclamation"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- ---- Submit + note ---- --}}
                <div class="space-y-3">
                    <button type="submit"
                            class="w-full bg-btr hover:bg-btr-dark text-white font-semibold py-3.5 px-4 rounded-xl
                                   transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer
                                   focus:outline-none focus:ring-2 focus:ring-btr/40 active:scale-[0.99]">
                        <i class="fas fa-user-plus text-sm"></i>
                        Daftar Sekarang
                    </button>

                    <p class="text-center text-xs text-gray-400">
                        Dengan mendaftar, Anda menyetujui ketentuan penggunaan layanan BTR.<br>
                        Link verifikasi akan dikirim ke email Anda setelah pendaftaran.
                    </p>

                    <p class="text-center text-sm text-gray-500">
                        Sudah punya akun?
                        <a href="{{ url('/login') }}" class="font-semibold text-btr hover:text-btr-gold transition-colors">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    {{-- Footer --}}
    <div class="text-center py-4 text-[11px] text-gray-400 border-t border-gray-200 bg-white">
        &copy; {{ date('Y') }} Balai Teknik Rawa — Kementerian Pekerjaan Umum
    </div>
</div>
@endsection

@section('scripts')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection
