<?php

namespace App\Http\Controllers;

use App\Models\GaleriFoto;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(){
        $galeri_foto = GaleriFoto::where('type', 'video')->latest()->paginate(9);

        return view('frontend.video', [
            "title" => "Video",
            'galeri_foto' => $galeri_foto
        ]);
    }
}
