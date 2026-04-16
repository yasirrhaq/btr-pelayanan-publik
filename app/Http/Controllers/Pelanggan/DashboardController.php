<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $permohonan = Permohonan::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        $counts = [
            'total'   => $permohonan->count(),
            'aktif'   => $permohonan->whereNotIn('status', ['selesai', 'ditolak'])->count(),
            'selesai' => $permohonan->where('status', 'selesai')->count(),
            'ditolak' => $permohonan->where('status', 'ditolak')->count(),
        ];

        $terbaru = $permohonan->take(5);

        $notifikasi = $user->notifikasi()->latest()->take(5)->get();

        return view('pelanggan.dashboard', compact('counts', 'terbaru', 'notifikasi'));
    }
}
