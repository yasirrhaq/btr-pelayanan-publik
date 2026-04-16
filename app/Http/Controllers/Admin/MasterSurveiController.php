<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SurveiPertanyaan;
use Illuminate\Http\Request;

class MasterSurveiController extends Controller
{
    public function index()
    {
        $pertanyaan = SurveiPertanyaan::orderBy('urutan')->get();

        return view('dashboard.master-survei.index', compact('pertanyaan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'unsur'      => 'required|string|max:255',
            'pertanyaan' => 'required|string|max:500',
            'urutan'     => 'required|integer|min:1',
        ]);

        SurveiPertanyaan::create([
            'unsur'      => $validated['unsur'],
            'pertanyaan' => $validated['pertanyaan'],
            'urutan'     => $validated['urutan'],
            'is_active'  => true,
        ]);

        return back()->with('success', 'Pertanyaan survei berhasil ditambahkan.');
    }

    public function update(Request $request, SurveiPertanyaan $pertanyaan)
    {
        $validated = $request->validate([
            'unsur'      => 'required|string|max:255',
            'pertanyaan' => 'required|string|max:500',
            'urutan'     => 'required|integer|min:1',
            'is_active'  => 'boolean',
        ]);

        $pertanyaan->update([
            'unsur'      => $validated['unsur'],
            'pertanyaan' => $validated['pertanyaan'],
            'urutan'     => $validated['urutan'],
            'is_active'  => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Pertanyaan survei berhasil diperbarui.');
    }

    public function destroy(SurveiPertanyaan $pertanyaan)
    {
        $pertanyaan->delete();

        return back()->with('success', 'Pertanyaan survei berhasil dihapus.');
    }
}
