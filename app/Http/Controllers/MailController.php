<?php

namespace App\Http\Controllers;

use App\Mail\SignupEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public static function sendMail($name, $email, $verification_token){
        $data = [
            'name' =>$name,
            'verification_token' => $verification_token,
        ];
        Mail::to($email)->send(new SignupEmail($data));
    }
}
