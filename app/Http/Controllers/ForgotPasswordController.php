<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use PDO;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('forgot-password.index');
    }

    public function sendMail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users'
        ]);

        $reset_token = Str::random(64);
        $user = User::where(['email' => $request->email])->first();

        $user->reset_token = $reset_token;
        $user->save();

        if ($user->is_verified != 0) {
            Mail::send('email.ForgotPassword', ['reset_token' => $reset_token], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password');
            });
            return back()->with('success', 'We have e-mailed your password reset link!');
        }else{
            return back()->with('emailNotFound', "Your email isn't verified, can't reset password!");
        }

    }

    public function showResetForm($reset_token)
    {

        $user = User::where('reset_token', $reset_token)->first();
        if(empty($user)){
            abort('401', 'Anda Tidak Punya Akses');
        }
        return view('forgot-password.reset', ['reset_token' => $reset_token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|max:255|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]/',
            'password_confirmation' => 'required_with:password|same:password',
        ]);

        $updatePassword = DB::table('users')->where(['reset_token' => $request->reset_token])->first();
        if (!$updatePassword) {
            return back()->withInput()->with('invalidToken', 'Invalid token!');
        }

        User::where('reset_token', $request->reset_token)->update(['password' => Hash::make($request->password), 'reset_token' => null]);

        return redirect('/login')->with('success', 'You password has been reset successfully!');
    }
}
