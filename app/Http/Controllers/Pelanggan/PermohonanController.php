<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\DokumenPermohonan;
use App\Models\JenisLayanan;
use App\Models\KategoriInstansi;
use App\Models\Permohonan;
use App\Models\WorkflowLog;
use App\Services\NomorPermohonanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PermohonanController extends Controller
{
    public function index()
    {
        $permohonan = Permohonan::where('user_id', Auth::id())
            ->with('jenisLayanan')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('pelanggan.permohonan.index', compact('permohonan'));
    }

    public function create()
    {
        $jenisLayanan = JenisLayanan::all();
        $kategori = KategoriInstansi::all();
        $user = Auth::user();

        return view('pelanggan.permohonan.create', compact('jenisLayanan', 'kategori', 'user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_layanan_id' => 'required|exists:jenis_layanan,id',
            'perihal'          => 'required|string|max:255',
            'deskripsi'        => 'nullable|string|max:2000',
            'dokumen.*'        => 'nullable|file|max:2048|mimes:pdf,jpg,jpeg,png,doc,docx',
        ]);

        $permohonan = DB::transaction(function () use ($validated, $request) {
            $nomor = NomorPermohonanService::generate($validated['jenis_layanan_id']);

            $permohonan = Permohonan::create([
                'nomor_pl'          => $nomor,
                'user_id'           => Auth::id(),
                'jenis_layanan_id'  => $validated['jenis_layanan_id'],
                'perihal'           => $validated['perihal'],
                'deskripsi'         => $validated['deskripsi'] ?? null,
                'status'            => Permohonan::STATUS_BARU,
                'progress'          => 0,
            ]);

            WorkflowLog::create([
                'permohonan_id' => $permohonan->id,
                'dari_status'   => null,
                'ke_status'     => Permohonan::STATUS_BARU,
                'actor_id'      => Auth::id(),
                'catatan'       => 'Permohonan diajukan oleh pelanggan.',
            ]);

            if ($request->hasFile('dokumen')) {
                foreach ($request->file('dokumen') as $file) {
                    $path = $file->store('dokumen-permohonan/' . $permohonan->id, 'public');
                    DokumenPermohonan::create([
                        'permohonan_id' => $permohonan->id,
                        'tipe'          => 'lampiran',
                        'nama_file'     => $file->getClientOriginalName(),
                        'path'          => $path,
                        'mime_type'     => $file->getMimeType(),
                        'ukuran'        => $file->getSize(),
                        'uploaded_by'   => Auth::id(),
                    ]);
                }
            }

            return $permohonan;
        });

        return redirect()->route('pelanggan.permohonan.show', $permohonan)
            ->with('success', 'Permohonan berhasil diajukan dengan nomor: ' . $permohonan->nomor_pl);
    }

    public function show(Permohonan $permohonan)
    {
        if ($permohonan->user_id !== Auth::id()) {
            abort(403);
        }

        $permohonan->load([
            'jenisLayanan',
            'workflowLogs.actor',
            'dokumen',
            'pembayaran',
            'dokumenFinal',
            'surveiKepuasan',
        ]);

        return view('pelanggan.permohonan.show', compact('permohonan'));
    }
}
