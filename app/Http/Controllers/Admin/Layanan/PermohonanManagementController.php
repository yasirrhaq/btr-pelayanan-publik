<?php

namespace App\Http\Controllers\Admin\Layanan;

use App\Http\Controllers\Controller;
use App\Models\DokumenFinal;
use App\Models\JenisLayanan;
use App\Models\Pembayaran;
use App\Models\Permohonan;
use App\Models\Tim;
use App\Models\User;
use App\Models\SurveiKepuasan;
use App\Models\SurveiPertanyaan;
use App\Services\SlaService;
use App\Services\WorkflowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermohonanManagementController extends Controller
{
    protected WorkflowService $workflow;

    public function __construct(WorkflowService $workflow)
    {
        $this->workflow = $workflow;
    }

    public function index(Request $request)
    {
        $query = Permohonan::with(['user', 'jenisLayanan', 'tim'])
            ->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('jenis_layanan_id')) {
            $query->where('jenis_layanan_id', $request->jenis_layanan_id);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nomor_pl', 'like', "%{$request->search}%")
                  ->orWhere('perihal', 'like', "%{$request->search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$request->search}%"));
            });
        }

        $permohonan = $query->paginate(15);
        $jenisLayanan = JenisLayanan::all();
        $statusList = Permohonan::STATUS_LABELS;

        return view('dashboard.layanan.index', compact('permohonan', 'jenisLayanan', 'statusList'));
    }

    public function show(Permohonan $permohonan)
    {
        $permohonan->load([
            'user', 'jenisLayanan', 'tim.anggota.user',
            'workflowLogs.actor', 'dokumen', 'pembayaran',
            'dokumenFinal', 'surveiKepuasan.jawaban.pertanyaan',
        ]);

        $timList = Tim::where('jenis_layanan_id', $permohonan->jenis_layanan_id)
            ->where('is_active', true)
            ->with('anggota.user')
            ->get();

        $allowedTransitions = Permohonan::allowedTransitions()[$permohonan->status] ?? [];

        return view('dashboard.layanan.show', compact('permohonan', 'timList', 'allowedTransitions'));
    }

    public function updateStatus(Request $request, Permohonan $permohonan)
    {
        $request->validate([
            'status'  => 'required|string',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $this->workflow->transition($permohonan, $request->status, $request->catatan);

        return back()->with('success', 'Status permohonan berhasil diperbarui.');
    }

    public function assignTim(Request $request, Permohonan $permohonan)
    {
        $request->validate([
            'tim_id'           => 'required|exists:tim,id',
            'sla_hari_kerja'   => 'required|integer|min:1|max:365',
        ]);

        if (!$permohonan->canTransitionTo(Permohonan::STATUS_PENUGASAN)) {
            return back()->with('error', 'Status permohonan saat ini belum dapat ditugaskan ke tim.');
        }

        $deadline = SlaService::hitungDeadline(now(), $request->sla_hari_kerja);

        $tim = Tim::findOrFail($request->tim_id);
        $katim = $tim->anggota()->where('jabatan', 'katim')->first();

        $permohonan->update([
            'tim_id'         => $request->tim_id,
            'katim_id'       => $katim?->user_id,
            'sla_hari_kerja' => $request->sla_hari_kerja,
            'deadline'       => $deadline,
        ]);

        $this->workflow->transition(
            $permohonan,
            Permohonan::STATUS_PENUGASAN,
            "Tim ditugaskan: {$tim->nama}. Deadline: {$deadline->format('d/m/Y')}."
        );

        return back()->with('success', 'Tim berhasil ditugaskan.');
    }

    public function setBilling(Request $request, Permohonan $permohonan)
    {
        $request->validate([
            'kode_billing' => 'required|string|max:50',
            'nominal'      => 'required|numeric|min:0',
        ]);

        if (!$permohonan->canTransitionTo(Permohonan::STATUS_PEMBAYARAN)) {
            return back()->with('error', 'Billing belum dapat diterbitkan pada status permohonan saat ini.');
        }

        Pembayaran::updateOrCreate(
            ['permohonan_id' => $permohonan->id],
            [
                'kode_billing' => $request->kode_billing,
                'nominal'      => $request->nominal,
                'status'       => Pembayaran::STATUS_BELUM_BAYAR,
            ]
        );

        $permohonan->update(['is_berbayar' => true]);

        $this->workflow->transition(
            $permohonan,
            Permohonan::STATUS_PEMBAYARAN,
            "Billing diterbitkan: {$request->kode_billing}, Rp " . number_format($request->nominal, 0, ',', '.')
        );

        return back()->with('success', 'Billing berhasil diterbitkan.');
    }

    public function verifyPayment(Request $request, Permohonan $permohonan)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
        ]);

        $pembayaran = $permohonan->pembayaran;
        if (!$pembayaran) {
            return back()->with('error', 'Data pembayaran tidak ditemukan.');
        }

        if ($request->action === 'approve') {
            if (!$permohonan->canTransitionTo(Permohonan::STATUS_PELAKSANAAN)) {
                return back()->with('error', 'Permohonan belum dapat dipindahkan ke tahap pelaksanaan.');
            }

            $pembayaran->update([
                'status'      => Pembayaran::STATUS_SUDAH_BAYAR,
                'verified_by' => Auth::id(),
                'verified_at' => now(),
            ]);

            $this->workflow->transition($permohonan, Permohonan::STATUS_PELAKSANAAN, 'Pembayaran diverifikasi.');
        } else {
            $pembayaran->update([
                'status'      => Pembayaran::STATUS_DITOLAK,
                'verified_by' => Auth::id(),
                'verified_at' => now(),
                'catatan'     => $request->input('catatan_tolak', 'Bukti pembayaran tidak valid.'),
            ]);
        }

        return back()->with('success', 'Verifikasi pembayaran berhasil.');
    }

    public function uploadDokumenFinal(Request $request, Permohonan $permohonan)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'file'         => 'required|file|max:10240|mimes:pdf,doc,docx,xlsx,xls',
        ]);

        $path = $request->file('file')->store('dokumen-final/' . $permohonan->id, 'public');

        DokumenFinal::create([
            'permohonan_id'  => $permohonan->id,
            'nama_dokumen'   => $request->nama_dokumen,
            'path'           => $path,
            'is_downloadable' => false,
            'uploaded_by'    => Auth::id(),
        ]);

        return back()->with('success', 'Dokumen hasil berhasil diunggah.');
    }

    public function dataPelanggan(Request $request)
    {
        $query = User::whereHas('permohonan')
            ->withCount('permohonan')
            ->with('kategoriInstansi');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $pelanggan = $query->orderByDesc('created_at')->paginate(15);

        return view('dashboard.layanan.data-pelanggan', compact('pelanggan'));
    }

    public function surveiAnalytics()
    {
        $pertanyaan = SurveiPertanyaan::where('is_active', true)->orderBy('urutan')->get();

        $surveiData = SurveiKepuasan::with('jawaban.pertanyaan')
            ->selectRaw('AVG(
                (SELECT AVG(sj.nilai) FROM survei_jawaban sj WHERE sj.survei_kepuasan_id = survei_kepuasan.id)
            ) as avg_total')
            ->first();

        $totalSurvei = SurveiKepuasan::count();

        $avgPerUnsur = [];
        foreach ($pertanyaan as $p) {
            $avgPerUnsur[$p->id] = [
                'pertanyaan' => $p->pertanyaan,
                'avg'        => $p->jawaban()->avg('nilai') ?? 0,
            ];
        }

        $recentSurvei = SurveiKepuasan::with(['permohonan.jenisLayanan', 'user', 'jawaban'])
            ->orderByDesc('created_at')
            ->take(20)
            ->get();

        return view('dashboard.layanan.survei-analytics', compact('pertanyaan', 'totalSurvei', 'avgPerUnsur', 'recentSurvei'));
    }

    public function dashboard()
    {
        $jenisLayanan = JenisLayanan::withCount([
            'permohonan',
            'permohonan as antri_count'   => fn($q) => $q->whereIn('status', ['baru', 'verifikasi']),
            'permohonan as proses_count'  => fn($q) => $q->whereNotIn('status', ['baru', 'verifikasi', 'selesai', 'ditolak']),
            'permohonan as selesai_count' => fn($q) => $q->where('status', 'selesai'),
        ])->get();

        $recentPermohonan = Permohonan::with(['user', 'jenisLayanan'])
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        return view('dashboard.layanan.dashboard', compact('jenisLayanan', 'recentPermohonan'));
    }
}
