<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KaryaIlmiah;

class KaryaIlmiahController extends Controller
{
    public function index(){

        $karyaIlmiah = KaryaIlmiah::where(function($q){
            $q->where('title', 'LIKE', '%' . request('search') . '%')
            ->orWhere('penerbit', 'LIKE', '%' . request('search') . '%');
        })
        ->latest()
        ->paginate(5);

        return view('frontend.karyailmiah',
            [
                'karyaIlmiah' => $karyaIlmiah
            ]
        );
    }

    public function detail(KaryaIlmiah $karyaIlmiah){
        return view('frontend.karyaIlmiahDetail', [
            'karyaIlmiah' => $karyaIlmiah
        ]);
    }
}
