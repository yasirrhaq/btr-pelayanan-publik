<?php

namespace App\Http\Controllers;

use App\Models\KaryaIlmiah;
use Illuminate\Http\Request;

class PublicRenstraController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->get('search'));

        $renstra = KaryaIlmiah::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('title', 'like', '%' . $search . '%')
                        ->orWhere('penerbit', 'like', '%' . $search . '%')
                        ->orWhere('subyek', 'like', '%' . $search . '%');
                });
            })
            ->orderByDesc('tanggal_terbit')
            ->orderByDesc('id')
            ->paginate(9)
            ->withQueryString();

        return view('frontend.renstra.index', compact('renstra', 'search'));
    }

    public function show(KaryaIlmiah $renstra)
    {
        $terbaru = KaryaIlmiah::query()
            ->whereKeyNot($renstra->getKey())
            ->orderByDesc('tanggal_terbit')
            ->orderByDesc('id')
            ->limit(4)
            ->get();

        return view('frontend.renstra.show', compact('renstra', 'terbaru'));
    }
}
