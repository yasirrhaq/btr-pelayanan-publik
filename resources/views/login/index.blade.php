@extends('frontend.layouts.mainAuth')

@section('page-title', 'Masuk')

@section('auth-content')
<div class="min-h-screen flex flex-col lg:flex-row">

    {{-- ===== LEFT: Brand Panel ===== --}}
    <div class="hidden lg:flex lg:w-5/12 xl:w-2/5 bg-btr relative flex-col items-center justify-center px-10 py-12 overflow-hidden">

        {{-- Background pattern + gradient overlay --}}
        <div class="absolute inset-0 bg-btr-pattern"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-btr-deep via-btr to-btr-dark opacity-90"></div>

        {{-- Decorative circles --}}
        <div class="absolute -top-24 -right-24 w-72 h-72 rounded-full bg-white/5"></div>
        <div class="absolute -bottom-16 -left-16 w-56 h-56 rounded-full bg-white/5"></div>
        <div class="absolute top-1/2 -right-8 w-32 h-32 rounded-full bg-btr-gold/10"></div>

        <div class="relative z-10 flex flex-col items-center text-center max-w-xs">
            {{-- Logo --}}
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 mb-6 ring-1 ring-white/20">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo BTR" class="w-20 h-20 object-contain">
            </div>

            {{-- Institution name --}}
            <h1 class="text-white font-bold text-xl tracking-wide mb-1">
                BALAI TEKNIK RAWA
            </h1>
            <div class="w-10 h-0.5 bg-btr-gold mx-auto my-3"></div>
            <p class="text-blue-200 text-xs leading-relaxed">
                Direktorat Bina Teknik Sumber Daya Air
            </p>
            <p class="text-blue-200 text-xs">
                Direktorat Jenderal Sumber Daya Air
            </p>
            <p class="text-blue-200 text-xs mb-8">
                Kementerian Pekerjaan Umum
            </p>

            {{-- Tagline card --}}
            <div class="bg-white/10 backdrop-blur-sm rounded-xl px-5 py-4 ring-1 ring-white/15 text-left w-full">
                <p class="text-btr-gold text-xs font-semibold mb-1 uppercase tracking-wider">Portal Layanan</p>
                <p class="text-white text-sm font-medium leading-snug">
                    Sistem Informasi Terpadu Balai Teknik Rawa
                </p>
            </div>
        </div>

        {{-- Footer --}}
        <p class="absolute bottom-5 text-blue-300/60 text-[10px] z-10">
            &copy; {{ date('Y') }} Balai Teknik Rawa — Kementerian Pekerjaan Umum
        </p>
    </div>

    {{-- ===== RIGHT: Form Panel ===== --}}
    <div class="flex-1 flex items-center justify-center px-5 py-10 sm:px-10">
        <div class="w-full max-w-md animate-fade-in">

            {{-- Mobile logo --}}
            <div class="flex items-center gap-3 mb-6 lg:hidden">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo BTR" class="w-10 h-10 object-contain">
                <div>
                    <p class="font-bold text-btr text-sm">BALAI TEKNIK RAWA</p>
                    <p class="text-gray-500 text-xs">Kementerian Pekerjaan Umum</p>
                </div>
            </div>

            {{-- Card with border --}}
            <div class="bg-white rounded-2xl border-2 border-gray-400 shadow-md p-7">

            {{-- Heading --}}
            <div class="mb-7">
                <h2 class="text-2xl font-bold text-gray-900">Selamat Datang</h2>
                <p class="text-gray-500 text-sm mt-1">Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            {{-- Alerts --}}
            @if (session('success'))
                <div class="flex items-start gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 mb-5 text-sm">
                    <i class="fas fa-check-circle mt-0.5 text-green-500 flex-shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if (session('loginError'))
                <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3 mb-5 text-sm">
                    <i class="fas fa-exclamation-circle mt-0.5 text-red-500 flex-shrink-0"></i>
                    <span>{{ session('loginError') }}</span>
                </div>
            @endif
            @if (session('authExpired'))
                <div class="flex items-start gap-3 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl px-4 py-3 mb-5 text-sm">
                    <i class="fas fa-clock-rotate-left mt-0.5 text-amber-500 flex-shrink-0"></i>
                    <span>{{ session('authExpired') }}</span>
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ url('/login') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 pointer-events-none">
                            <i class="fas fa-envelope text-xs"></i>
                        </span>
                        <input type="email" id="email" name="email"
                               value="{{ old('email') }}"
                               placeholder="contoh@email.com"
                               class="auth-input pl-10 @error('email') is-invalid @enderror"
                               autofocus required>
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                            <i class="fas fa-circle-exclamation"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-semibold text-gray-600 uppercase tracking-wide">
                            Kata Sandi
                        </label>
                        <a href="{{ url('/forgot-password') }}" class="text-xs text-btr hover:text-btr-gold transition-colors font-medium">
                            Lupa Sandi?
                        </a>
                    </div>
                    <div class="relative" x-data="{ show: false }">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 pointer-events-none">
                            <i class="fas fa-lock text-xs"></i>
                        </span>
                        <input :type="show ? 'text' : 'password'" id="password" name="password"
                               placeholder="••••••••"
                               class="auth-input pl-10 pr-10"
                               autocomplete="current-password"
                               required>
                        <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 cursor-pointer transition-colors">
                            <i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-xs"></i>
                        </button>
                    </div>
                </div>

                {{-- Captcha --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                        Verifikasi Keamanan
                    </label>
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

                {{-- Submit --}}
                <button type="submit"
                        class="w-full bg-btr hover:bg-btr-dark text-white font-semibold py-3 px-4 rounded-xl
                               transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer
                               focus:outline-none focus:ring-2 focus:ring-btr/40 active:scale-[0.99] mt-2">
                    <i class="fas fa-right-to-bracket text-sm"></i>
                    Masuk
                </button>
            </form>

            {{-- Divider --}}
            <div class="flex items-center gap-3 my-6">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-xs text-gray-400">atau</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            {{-- Register link --}}
            <p class="text-center text-sm text-gray-500">
                Belum punya akun?
                <a href="{{ url('/register') }}" class="font-semibold text-btr hover:text-btr-gold transition-colors">
                    Daftar Sekarang
                </a>
            </p>

            {{-- Home link --}}
            <p class="text-center mt-4">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-xs text-gray-400 hover:text-btr transition-colors">
                    <i class="fas fa-arrow-left text-[10px]"></i>
                    Kembali ke Beranda
                </a>
            </p>

            </div>{{-- end card --}}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection
