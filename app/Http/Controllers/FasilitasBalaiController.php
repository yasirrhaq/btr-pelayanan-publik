<?php

namespace App\Http\Controllers;

use App\Models\FasilitasBalai;
use Illuminate\Http\Request;

class FasilitasBalaiController extends Controller
{
    public function index()
    {
        return view('frontend.fasilitas-balai', [
            "title" => "Fasilitas Balai",
            "fasilitasBalai" => FasilitasBalai::latest()->paginate(9)
        ]);
    }
}
