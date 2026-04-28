<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PublicPengumumanController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $query = Pengumuman::published()->latest();

        if ($search !== '') {
            $query->where('judul', 'like', '%' . $search . '%');
        }

        return view('frontend.pengumuman.index', [
            'title' => 'Pengumuman',
            'search' => $search,
            'pengumuman' => $query->paginate(3)->withQueryString(),
        ]);
    }

    public function show(Pengumuman $pengumuman)
    {
        abort_unless($pengumuman->is_active, 404);

        $pengumuman->increment('views');
        $pengumuman->refresh();

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
