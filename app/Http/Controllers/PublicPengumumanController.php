<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;

class PublicPengumumanController extends Controller
{
    public function index()
    {
        return view('frontend.pengumuman.index', [
            'title' => 'Pengumuman',
            'pengumuman' => Pengumuman::where('is_active', true)->latest()->paginate(12),
        ]);
    }

    public function show(Pengumuman $pengumuman)
    {
        abort_unless($pengumuman->is_active, 404);

        return view('frontend.pengumuman.show', [
            'title' => $pengumuman->judul,
            'pengumuman' => $pengumuman,
            'terbaru' => Pengumuman::where('is_active', true)
                ->whereKeyNot($pengumuman->id)
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }
}
