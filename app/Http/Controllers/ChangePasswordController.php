<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function index()
    {
        if (request()->is('pelanggan/*')) {
            return view('pelanggan.profil.password');
        }

        return view('profile.password.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => 'required|min:8|max:255|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]/',
            'new_confirm_password' => 'same:new_password',
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

        $redirectPath = request()->is('pelanggan/*')
            ? '/pelanggan/profil/password'
            : '/profile/password';

        return redirect($redirectPath)->with('success', 'Password berhasil diganti!');
    }
}
