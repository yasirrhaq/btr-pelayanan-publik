<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Http\Request;

class SejarahController extends Controller
{
    public function index(){
        $landing_page = LandingPage::whereIn('landing_page_tipe_id', [3])->get();
        return view('frontend.sejarah', compact(
            'landing_page'
        ));
    }
}
