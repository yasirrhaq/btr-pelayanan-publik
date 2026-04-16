<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisLayanan;
use App\Models\Tim;
use App\Models\TimAnggota;
use App\Models\User;
use Illuminate\Http\Request;

class MasterTimController extends Controller
{
    public function index()
    {
        $tim = Tim::with(['jenisLayanan', 'anggota.user'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('dashboard.master-tim.index', compact('tim'));
    }

    public function create()
    {
        $jenisLayanan = JenisLayanan::all();
        $users = User::orderBy('name')->get();

        return view('dashboard.master-tim.create', compact('jenisLayanan', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'              => 'required|string|max:255',
            'jenis_layanan_id'  => 'required|exists:jenis_layanan,id',
            'is_active'         => 'boolean',
            'anggota'           => 'nullable|array',
            'anggota.*.user_id' => 'required|exists:users,id',
            'anggota.*.jabatan' => 'required|in:katim,anggota,analis,penyelia,teknisi',
        ]);

        $tim = Tim::create([
            'nama'             => $validated['nama'],
            'jenis_layanan_id' => $validated['jenis_layanan_id'],
            'is_active'        => $request->boolean('is_active', true),
        ]);

        if (!empty($validated['anggota'])) {
            foreach ($validated['anggota'] as $a) {
                TimAnggota::create([
                    'tim_id'  => $tim->id,
                    'user_id' => $a['user_id'],
                    'jabatan' => $a['jabatan'],
                ]);
            }
        }

        return redirect()->route('admin.master-tim.index')
            ->with('success', 'Tim berhasil dibuat.');
    }

    public function edit(Tim $tim)
    {
        $tim->load('anggota.user');
        $jenisLayanan = JenisLayanan::all();
        $users = User::orderBy('name')->get();

        return view('dashboard.master-tim.edit', compact('tim', 'jenisLayanan', 'users'));
    }

    public function update(Request $request, Tim $tim)
    {
        $validated = $request->validate([
            'nama'              => 'required|string|max:255',
            'jenis_layanan_id'  => 'required|exists:jenis_layanan,id',
            'is_active'         => 'boolean',
            'anggota'           => 'nullable|array',
            'anggota.*.user_id' => 'required|exists:users,id',
            'anggota.*.jabatan' => 'required|in:katim,anggota,analis,penyelia,teknisi',
        ]);

        $tim->update([
            'nama'             => $validated['nama'],
            'jenis_layanan_id' => $validated['jenis_layanan_id'],
            'is_active'        => $request->boolean('is_active', true),
        ]);

        $tim->anggota()->delete();
        if (!empty($validated['anggota'])) {
            foreach ($validated['anggota'] as $a) {
                TimAnggota::create([
                    'tim_id'  => $tim->id,
                    'user_id' => $a['user_id'],
                    'jabatan' => $a['jabatan'],
                ]);
            }
        }

        return redirect()->route('admin.master-tim.index')
            ->with('success', 'Tim berhasil diperbarui.');
    }

    public function destroy(Tim $tim)
    {
        $tim->anggota()->delete();
        $tim->delete();

        return redirect()->route('admin.master-tim.index')
            ->with('success', 'Tim berhasil dihapus.');
    }
}
