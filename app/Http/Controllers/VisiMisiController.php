<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LandingPage;

class VisiMisiController extends Controller
{
    public function index(){
        $landing_page = LandingPage::whereIn('landing_page_tipe_id', [1,2])->get();
        return view('frontend.visimisi', compact(
            'landing_page'
        ));
    }
}
