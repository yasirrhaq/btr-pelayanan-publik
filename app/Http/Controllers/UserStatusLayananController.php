<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserStatusLayanan;
use Illuminate\Support\Facades\Auth;

class UserStatusLayananController extends Controller
{
    public function index()
    {
        $id=Auth::user()->id;
        $statusLayanan = UserStatusLayanan::with(['user:id,name,email', 'status:id,name'])->where('user_id', $id)->get();
        return view('profile.status-layanan.index', compact('statusLayanan'));
    }
}