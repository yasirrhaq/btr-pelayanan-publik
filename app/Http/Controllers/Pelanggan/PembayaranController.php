<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function show(Permohonan $permohonan)
    {
        if ($permohonan->user_id !== Auth::id()) {
            abort(403);
        }

        $pembayaran = $permohonan->pembayaran;

        return view('pelanggan.pembayaran.show', compact('permohonan', 'pembayaran'));
    }

    public function uploadBukti(Request $request, Permohonan $permohonan)
    {
        if ($permohonan->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'bukti_bayar' => 'required|file|max:2048|mimes:jpg,jpeg,png,pdf',
        ]);

        $pembayaran = $permohonan->pembayaran;
        if (!$pembayaran) {
            abort(404, 'Data pembayaran tidak ditemukan.');
        }

        $path = $request->file('bukti_bayar')->store('bukti-bayar/' . $permohonan->id, 'public');

        $pembayaran->update([
            'bukti_bayar_path' => $path,
            'tanggal_bayar'    => now(),
            'status'           => Pembayaran::STATUS_MENUNGGU_VERIFIKASI,
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah.');
    }
}
