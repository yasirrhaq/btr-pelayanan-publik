<?php

namespace App\Http\Controllers;

use App\Models\FotoHome;
use App\Models\GaleriFoto;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\SitusTerkait;
use App\Models\UrlLayanan;

class HomeController extends Controller
{
    public function index(){
        return view('frontend.home',[
            "terkini" => Post::latest()->get(),
            "foto_home" => FotoHome::all(),
            "url" => UrlLayanan::find(3),
            "url_yt" => UrlLayanan::find(9),
            "galeri_foto" => GaleriFoto::latest()->take(4)->get(),
            "situsTerkait" => SitusTerkait::all()
        ]);
    }
}
