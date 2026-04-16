<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\DokumenFinal;
use App\Models\Permohonan;
use App\Models\SurveiJawaban;
use App\Models\SurveiKepuasan;
use App\Models\SurveiPertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SurveiController extends Controller
{
    public function create(Permohonan $permohonan)
    {
        if ($permohonan->user_id !== Auth::id()) {
            abort(403);
        }

        if ($permohonan->sudahSurvei()) {
            return redirect()->route('pelanggan.permohonan.show', $permohonan)
                ->with('info', 'Anda sudah mengisi survei untuk permohonan ini.');
        }

        $pertanyaan = SurveiPertanyaan::where('is_active', true)->orderBy('urutan')->get();

        return view('pelanggan.survei.create', compact('permohonan', 'pertanyaan'));
    }

    public function store(Request $request, Permohonan $permohonan)
    {
        if ($permohonan->user_id !== Auth::id()) {
            abort(403);
        }

        if ($permohonan->sudahSurvei()) {
            return back()->with('info', 'Survei sudah diisi.');
        }

        $pertanyaan = SurveiPertanyaan::where('is_active', true)->pluck('id');

        $rules = [];
        foreach ($pertanyaan as $id) {
            $rules["jawaban.{$id}"] = 'required|integer|min:1|max:4';
        }
        $rules['saran'] = 'nullable|string|max:2000';

        $validated = $request->validate($rules);

        DB::transaction(function () use ($permohonan, $validated, $pertanyaan) {
            $survei = SurveiKepuasan::create([
                'permohonan_id' => $permohonan->id,
                'user_id'       => Auth::id(),
                'saran'         => $validated['saran'] ?? null,
            ]);

            foreach ($pertanyaan as $pId) {
                SurveiJawaban::create([
                    'survei_kepuasan_id'   => $survei->id,
                    'survei_pertanyaan_id' => $pId,
                    'nilai'                => $validated['jawaban'][$pId],
                ]);
            }

            // Unlock document downloads
            DokumenFinal::where('permohonan_id', $permohonan->id)
                ->update(['is_downloadable' => true]);
        });

        return redirect()->route('pelanggan.permohonan.show', $permohonan)
            ->with('success', 'Terima kasih telah mengisi survei kepuasan. Dokumen hasil sudah dapat diunduh.');
    }
}
