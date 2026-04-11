<?php

namespace App\Http\Controllers;

use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;

class StrukturOrganisasiController extends Controller
{
    public function index(){
        return view('frontend.struktur', [
            "title" => "Struktur Organisasi",
            "strukturOrganisasi" => StrukturOrganisasi::Paginate(1)
        ]);
    }
}
