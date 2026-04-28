<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Functions\ImageUpload;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::orderByDesc('created_at')->paginate(15);

        return view('dashboard.pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('dashboard.pengumuman.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'       => 'required|string|max:255',
            'isi'         => 'required|string',
            'is_active'   => 'boolean',
            'thumbnail'   => 'nullable|image|max:12288|mimes:jpg,jpeg,png,webp',
            'lampiran'    => 'nullable|file|max:5120|mimes:pdf,doc,docx,jpg,jpeg,png',
        ]);

        $data = [
            'judul'      => $validated['judul'],
            'isi'        => $validated['isi'],
            'is_active'  => $request->boolean('is_active', true),
            'created_by' => Auth::id(),
        ];

        if ($request->hasFile('lampiran')) {
            $data['lampiran_path'] = $request->file('lampiran')->store('pengumuman', 'public');
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail_path'] = (new ImageUpload())->storeOptimizedStorageImage(
                $request->file('thumbnail'),
                'pengumuman/thumbnails',
                $validated['judul']
            );
        }

        Pengumuman::create($data);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('dashboard.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'isi'       => 'required|string',
            'is_active' => 'boolean',
            'thumbnail' => 'nullable|image|max:12288|mimes:jpg,jpeg,png,webp',
            'lampiran'  => 'nullable|file|max:5120|mimes:pdf,doc,docx,jpg,jpeg,png',
            'remove_thumbnail' => 'nullable|boolean',
            'remove_lampiran' => 'nullable|boolean',
        ]);

        $data = [
            'judul'     => $validated['judul'],
            'isi'       => $validated['isi'],
            'is_active' => $request->boolean('is_active', true),
        ];

        if ($request->boolean('remove_thumbnail')) {
            if ($pengumuman->usesUploadedThumbnail()) {
                Storage::disk('public')->delete($pengumuman->thumbnail_path);
            }

            $data['thumbnail_path'] = null;
        }

        if ($request->hasFile('thumbnail')) {
            if ($pengumuman->usesUploadedThumbnail()) {
                Storage::disk('public')->delete($pengumuman->thumbnail_path);
            }

            $data['thumbnail_path'] = (new ImageUpload())->storeOptimizedStorageImage(
                $request->file('thumbnail'),
                'pengumuman/thumbnails',
                $validated['judul']
            );
        }

        if ($request->boolean('remove_lampiran') && $pengumuman->lampiran_path) {
            Storage::disk('public')->delete($pengumuman->lampiran_path);
            $data['lampiran_path'] = null;
        }

        if ($request->hasFile('lampiran')) {
            if ($pengumuman->lampiran_path) {
                Storage::disk('public')->delete($pengumuman->lampiran_path);
            }
            $data['lampiran_path'] = $request->file('lampiran')->store('pengumuman', 'public');
        }

        $pengumuman->update($data);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        if ($pengumuman->usesUploadedThumbnail()) {
            Storage::disk('public')->delete($pengumuman->thumbnail_path);
        }

        if ($pengumuman->lampiran_path) {
            Storage::disk('public')->delete($pengumuman->lampiran_path);
        }

        $pengumuman->delete();

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function uploadAttachment(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:12288|mimes:jpg,jpeg,png,gif,webp',
        ]);

        $path = (new ImageUpload())->storeOptimizedPublicImage(
            $request->file('file'),
            'uploads/pengumuman/editor',
            'pengumuman-editor'
        );

        return response()->json([
            'url' => asset($path),
            'message' => 'Upload berhasil',
        ]);
    }
}
