<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function index(){
        $landing_page = LandingPage::whereIn('landing_page_tipe_id', [4,5])->get();
        return view('frontend.tugas', compact(
            'landing_page'
        ));
    }
}
