<?php

namespace App\Http\Controllers;

use App\Models\UrlLayanan;
use Illuminate\Http\Request;

class UrlLayananController extends Controller
{
    public function indexAdvis()
    {
        return view('frontend.advis-teknis', [
            "title" => "Advis Teknis",
            'url' => UrlLayanan::where('id', '1')->first()
        ]);
    }
    public function indexPengujianLab()
    {
        return view('frontend.pengujian-laboratorium', [
            "title" => "Pengujian Laboratorium",
            'url' => UrlLayanan::where('id', '2')->first()
        ]);
    }
}
