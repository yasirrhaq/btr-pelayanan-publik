<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\SignupEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    protected $path_file_save = 'foto-profile';
    public function index()
    {
        return view('register.index', [
            'title' => 'Register',
            'active' => 'register'
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name'                  => 'required|max:255|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
            'username'              => ['required', 'min:3', 'max:255', 'unique:users'],
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|min:8|max:255|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]/',
            'password_confirmation' => 'required_with:password|same:password',
            'foto_profile'          => 'image|file|max:1024',
            'no_id'                 => 'required|max:255|unique:users',
            'alamat'                => 'required|max:255',
            'instansi'              => 'required|max:255',
        ];

        if (!config('captcha.disable', false)) {
            $rules['captcha'] = 'required|captcha';
        }

        $validatedData = $request->validate($rules, [
            'captcha.required' => 'Kode captcha wajib diisi.',
            'captcha.captcha'  => 'Kode captcha salah. Silakan coba lagi.',
        ]);
        unset($validatedData['captcha']);
        
        if ($request->file('foto_profile')) {

            $slug      = slugCustom($request->nama);
            $file      = $request->file() ?? [];
            $path      = 'uploads/'.$this->path_file_save.'/';
            $config_file = [
                'patern_filename'   => $slug,
                'is_convert'        => true,
                'file'              => $file,
                'path'              => $path,
                'convert_extention' => 'jpeg'
            ];

            $validatedData['foto_profile'] = (new \App\Http\Controllers\Functions\ImageUpload())->imageUpload('file', $config_file)['foto_profile'];
        }

        $token = Str::random(64);
        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['verification_token'] = $token;

        User::create($validatedData);
        
        MailController::sendMail($request->name, $request->email, $token);
        return redirect('/login')->with('success', 'Registrasi berhasil! Silahkan cek email untuk verifikasi akun!');
    }

    public function verifyAccount(Request $request)
    {
        $verification_token = $request->get('verification_token');
        $user = User::where(['verification_token' => $verification_token])->first();

        $message = 'Sorry your email cannot be identified.';

        if ($user != null) {
            $user->is_verified = 1;
            $user->email_verified_at = Carbon::now();
            $user->save();
            $message = "Email berhasil diverifikasi. Silahkan login";
        } else {
            return redirect('/login');
        }

        return redirect('/login')->with('success', $message);
    }
}
