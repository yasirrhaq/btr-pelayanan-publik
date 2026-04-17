<?php

namespace App\Http\Controllers;

use App\Models\FotoHome;
use App\Models\GaleriFoto;
use App\Models\JenisLayanan;
use App\Models\Pengumuman;
use App\Models\Permohonan;
use App\Models\Post;
use App\Models\SitusTerkait;
use App\Models\UrlLayanan;

class HomeController extends Controller
{
    public function index()
    {
        $tentangKami = UrlLayanan::where('name', 'Tentang Kami')->first() ?? UrlLayanan::find(9);

        // Build stats from real workflow permohonan data
        $statsLayanan = [];
        $jenisAll = JenisLayanan::orderBy('id')->take(3)->get();

        foreach ($jenisAll as $jenis) {
            $base = Permohonan::where('jenis_layanan_id', $jenis->id);
            $statsLayanan[] = [
                'name'    => $jenis->name,
                'all'     => (clone $base)->count(),
                'baru'    => (clone $base)->whereIn('status', [
                    Permohonan::STATUS_BARU,
                    Permohonan::STATUS_VERIFIKASI,
                    Permohonan::STATUS_PENUGASAN,
                ])->count(),
                'proses'  => (clone $base)->whereIn('status', [
                    Permohonan::STATUS_PEMBAYARAN,
                    Permohonan::STATUS_PELAKSANAAN,
                    Permohonan::STATUS_ANALISIS,
                    Permohonan::STATUS_EVALUASI,
                    Permohonan::STATUS_FINALISASI,
                ])->count(),
                'selesai' => (clone $base)->where('status', Permohonan::STATUS_SELESAI)->count(),
            ];
        }

        // Ensure at least 3 entries (Advis Teknis, Laboratorium, Data & Informasi)
        while (count($statsLayanan) < 3) {
            $statsLayanan[] = ['name' => '', 'all' => 0, 'baru' => 0, 'proses' => 0, 'selesai' => 0];
        }

        return view('frontend.home', [
            'pengumuman'   => Pengumuman::where('is_active', true)->latest()->take(6)->get(),
            'terkini'      => Post::latest()->get(),
            'foto_home'    => FotoHome::all(),
            'url'          => UrlLayanan::find(3),
            'url_yt'       => $tentangKami,
            'tentangKami'  => $tentangKami,
            'galeri_foto'  => GaleriFoto::latest()->take(4)->get(),
            'situsTerkait' => SitusTerkait::all(),
            'statsLayanan' => $statsLayanan,
        ]);
    }
}
