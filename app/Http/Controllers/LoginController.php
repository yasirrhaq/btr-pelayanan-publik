<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected function redirectPathFor(User $user): string
    {
        if ($user->is_admin) {
            if ($user->hasRole('admin-editor')) {
                return url('/dashboard/posts');
            }

            if ($user->hasAnyRole(['admin-layanan-master', 'katim', 'admin-bidang', 'analis', 'penyelia', 'teknisi'])
                && !$user->hasAnyRole(['admin-master', 'admin-editor'])) {
                return route('admin.layanan.dashboard');
            }

            return '/dashboard';
        }

        return route('pelanggan.dashboard');
    }

    public function index()
    {
        return view('login.index', [
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $rules = [
            'email'    => 'required|email',
            'password' => 'required',
        ];

        if (!config('captcha.disable', false)) {
            $rules['captcha'] = 'required|captcha';
        }

        $validatedData = $request->validate($rules, [
            'captcha.required' => 'Kode captcha wajib diisi.',
            'captcha.captcha'  => 'Kode captcha salah. Silakan coba lagi.',
        ]);

        $credentials = [
            'email'    => $validatedData['email'],
            'password' => $validatedData['password'],
        ];

        if (!Auth::attempt($credentials)) {
            return back()->with('loginError', 'Login failed!');
        }

        if ((int) Auth::user()->is_active !== 1) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return back()->with('loginError', 'Akun Anda sedang tidak aktif.');
        }

        if (Auth::user()->is_verified == 1) {
            $request->session()->regenerate();
            return redirect()->intended($this->redirectPathFor(Auth::user()));
        } else if (Auth::user()->is_verified == 0) {
            return redirect()->intended('verify-email');
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return back()->with('loginError', 'Login failed!');
    }

    public function resend(Request $request){
        $user = User::where(['email' => Auth::user()->email])->first();
        $email = $user->email;
        $token = $user->verification_token;
        $name = $user->name;

        MailController::sendMail($name, $email, $token);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Email verifikasi sudah dikirim ulang! Silahkan cek email anda');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showVerify()
    {
        return view('login.verify', [
            'title' => 'Verify'
        ]);
    }
}
