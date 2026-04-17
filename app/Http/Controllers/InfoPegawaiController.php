<?php

namespace App\Http\Controllers;

use App\Models\InfoPegawai;
use Illuminate\Http\Request;

class InfoPegawaiController extends Controller
{
    public function index()
    {
        return view('frontend.info-pegawai', [
            "title" => "Informasi Pegawai",
            "infoPegawai" => InfoPegawai::query()
                ->orderBy('urutan')
                ->orderBy('title')
                ->paginate(12)
        ]);
    }
}
