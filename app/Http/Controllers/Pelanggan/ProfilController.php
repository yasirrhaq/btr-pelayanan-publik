<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\KategoriInstansi;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    protected string $pathFileSave = 'foto-profile';

    public function index()
    {
        return view('pelanggan.profil.index');
    }

    public function edit()
    {
        return view('pelanggan.profil.edit', [
            'kategoriInstansi' => KategoriInstansi::orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|max:255|regex:/^([a-zA-Z]+)(\\s[a-zA-Z]+)*$/',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'foto_profile' => 'nullable|image|file|max:1024',
            'alamat' => 'required|max:255',
            'instansi' => 'required|max:255',
            'no_hp' => 'nullable|max:255',
            'kategori_instansi_id' => 'nullable|exists:kategori_instansi,id',
        ]);

        if ($request->file('foto_profile')) {
            $slug = slugCustom($request->name);
            $file = $request->file() ?? [];
            $path = 'uploads/' . $this->pathFileSave . '/';
            $configFile = [
                'patern_filename' => $slug,
                'is_convert' => true,
                'file' => $file,
                'path' => $path,
                'convert_extention' => 'jpeg',
            ];

            $validated['foto_profile'] = (new \App\Http\Controllers\Functions\ImageUpload())->imageUpload('file', $configFile)['foto_profile'];
        }

        $user->update($validated);

        return redirect()->route('pelanggan.profil')->with('success', 'Profil pelanggan berhasil diperbarui.');
    }
}
