<?php

namespace App\Http\Controllers;

use App\Models\FotoHome;
use App\Models\GaleriFoto;
use App\Models\JenisLayanan;
use App\Models\UserStatusLayanan;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\SitusTerkait;
use App\Models\UrlLayanan;

class HomeController extends Controller
{
    public function index()
    {
        // Build stats per jenis layanan
        $statsLayanan = [];
        $jenisAll = JenisLayanan::orderBy('id')->get();

        foreach ($jenisAll as $jenis) {
            $base = UserStatusLayanan::where('layanan_id', $jenis->id);
            $statsLayanan[] = [
                'name'    => $jenis->name,
                'all'     => (clone $base)->count(),
                'baru'    => (clone $base)->whereHas('status', fn($q) => $q->where('name', 'Baru'))->count(),
                'proses'  => (clone $base)->whereHas('status', fn($q) => $q->where('name', 'Proses'))->count(),
                'selesai' => (clone $base)->whereHas('status', fn($q) => $q->where('name', 'Selesai'))->count(),
            ];
        }

        // Ensure at least 3 entries (Advis Teknis, Laboratorium, Data & Informasi)
        while (count($statsLayanan) < 3) {
            $statsLayanan[] = ['name' => '', 'all' => 0, 'baru' => 0, 'proses' => 0, 'selesai' => 0];
        }

        return view('frontend.home', [
            'terkini'      => Post::latest()->get(),
            'foto_home'    => FotoHome::all(),
            'url'          => UrlLayanan::find(3),
            'url_yt'       => UrlLayanan::find(9),
            'galeri_foto'  => GaleriFoto::latest()->take(4)->get(),
            'situsTerkait' => SitusTerkait::all(),
            'statsLayanan' => $statsLayanan,
        ]);
    }
}
