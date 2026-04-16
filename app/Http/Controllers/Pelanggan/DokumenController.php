<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\DokumenFinal;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function index()
    {
        $permohonanIds = Permohonan::where('user_id', Auth::id())->pluck('id');

        $dokumen = DokumenFinal::whereIn('permohonan_id', $permohonanIds)
            ->with('permohonan')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('pelanggan.dokumen.index', compact('dokumen'));
    }

    public function download(DokumenFinal $dokumenFinal)
    {
        $permohonan = $dokumenFinal->permohonan;

        if ($permohonan->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$dokumenFinal->is_downloadable) {
            return back()->with('error', 'Silakan isi survei kepuasan terlebih dahulu sebelum mengunduh dokumen.');
        }

        if (!Storage::disk('public')->exists($dokumenFinal->path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($dokumenFinal->path, $dokumenFinal->nama_dokumen);
    }
}
