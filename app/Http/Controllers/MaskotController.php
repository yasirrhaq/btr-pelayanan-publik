<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use App\Models\LandingPageTipe;

class MaskotController extends Controller
{
    public function index()
    {
        $type = LandingPageTipe::where('title', 'Maskot Balai Teknik Rawa')->first();

        $landing_page = collect();

        if ($type) {
            $landing_page = LandingPage::where('landing_page_tipe_id', $type->id)
                ->where('status', 1)
                ->get();
        }

        return view('frontend.maskot', [
            'landing_page' => $landing_page,
        ]);
    }
}
