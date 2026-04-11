<?php

namespace App\Http\Controllers;

use App\Models\GaleriFoto;
use Illuminate\Http\Request;

class FotoController extends Controller
{
    //

    public function index(){
        $galeri_foto = GaleriFoto::latest()->paginate(9);
        return view('frontend.foto', [
            "title" => "Foto",
            'galeri_foto' => $galeri_foto,
        ]);
    }
}
