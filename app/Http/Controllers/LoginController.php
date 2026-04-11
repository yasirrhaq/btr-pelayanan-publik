<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index', [
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials) && Auth::user()->is_verified == 1) {
            $request->session()->regenerate();
            return redirect()->intended('balai/teknikrawa/dashboard');
        } else if (Auth::attempt($credentials) && Auth::user()->is_verified == 0) {
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

        return redirect('/balai/teknikrawa/');
    }

    public function showVerify()
    {
        return view('login.verify', [
            'title' => 'Verify'
        ]);
    }
}
