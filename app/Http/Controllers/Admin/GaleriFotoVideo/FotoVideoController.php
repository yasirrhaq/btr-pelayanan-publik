<?php

namespace App\Http\Controllers\Admin\GaleriFotoVideo;

use App\Http\Controllers\Controller;
use App\Models\GaleriFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FotoVideoController extends Controller
{
    protected $redirect_path = '/dashboard/galeri/foto-video';
    protected $path_file_save = 'galeri';

    protected function normalizeType(?string $type): string
    {
        return match ($type) {
            'video' => 'video',
            'dokumen' => 'dokumen',
            default => 'image',
        };
    }

    protected function tabFromType(string $type): string
    {
        return $type === 'image' ? 'foto' : $type;
    }

    protected function deleteFile(?string $path): void
    {
        if (!$path) {
            return;
        }

        $absolute = public_path(ltrim(str_replace('\\', '/', $path), '/'));
        if (is_file($absolute)) {
            @unlink($absolute);
        }
    }

    protected function uploadByType(Request $request, string $field, string $type): ?string
    {
        if (!$request->hasFile($field)) {
            return null;
        }

        if ($type === 'image') {
            $slug = slugCustom($request->title ?? 'galeri');
            $file = $request->file() ?? [];
            $path = 'uploads/' . $this->path_file_save . '/';
            $config_file = [
                'patern_filename' => $slug,
                'is_convert' => true,
                'file' => $file,
                'path' => $path,
                'convert_extention' => 'jpeg',
            ];

            return (new \App\Http\Controllers\Functions\ImageUpload())->imageUpload('file', $config_file)[$field];
        }

        $uploaded = $request->file($field);
        $filename = Str::slug($request->title ?: 'galeri') . '-' . time() . '.' . $uploaded->getClientOriginalExtension();
        $targetDir = public_path('uploads/' . $this->path_file_save);

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $uploaded->move($targetDir, $filename);

        return 'uploads/' . $this->path_file_save . '/' . $filename;
    }

    public function index()
    {
        $activeTab = request('tab', 'foto');
        $title = ucfirst($activeTab);

        $fotoVideo = match ($activeTab) {
            'video' => GaleriFoto::where('type', 'video')->latest()->get(),
            'dokumen' => GaleriFoto::where('type', 'dokumen')->latest()->get(),
            default => GaleriFoto::where('type', 'image')->latest()->get(),
        };

        return view('dashboard.galeri-foto-video.index', compact('fotoVideo', 'title', 'activeTab'));
    }

    public function create()
    {
        $activeTab = request('tab', 'foto');
        return view('dashboard.galeri-foto-video.create', compact('activeTab'));
    }

    public function store(Request $request)
    {
        $type = $this->normalizeType($request->input('type'));

        $rules = [
            'title' => 'required|max:255',
            'type' => 'required|in:image,video,dokumen',
        ];

        $rules['path_image'] = match ($type) {
            'video' => 'required|file|max:51200|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/webm',
            'dokumen' => 'required|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx',
            default => 'required|image|file|max:1024',
        };

        $validatedData = $request->validate($rules);
        $validatedData['path_image'] = $this->uploadByType($request, 'path_image', $type);
        $validatedData['type'] = $type;
        $validatedData['created_by'] = auth()->id();

        GaleriFoto::create($validatedData);

        return redirect($this->redirect_path . '?tab=' . $this->tabFromType($type))->with('success', 'Berhasil menambahkan Data');
    }

    public function show($id)
    {
        $galeriFoto = GaleriFoto::find($id);
        return view('dashboard.galeri-foto-video.show', ['galeri_foto' => $galeriFoto]);
    }

    public function edit(int $id)
    {
        $galeri_foto = GaleriFoto::find($id);
        return view('dashboard.galeri-foto-video.edit', compact('galeri_foto'));
    }

    public function update(Request $request, int $id)
    {
        $galeri_foto = GaleriFoto::where('id', $id)->firstOrFail();
        $type = $this->normalizeType($request->input('type', $galeri_foto->type));

        $rules = [
            'title' => 'required|max:255',
            'type' => 'required|in:image,video,dokumen',
        ];

        $rules['path_image'] = match ($type) {
            'video' => 'nullable|file|max:51200|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/webm',
            'dokumen' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx',
            default => 'nullable|image|file|max:1024',
        };

        $validatedData = $request->validate($rules);

        if ($request->hasFile('path_image')) {
            $this->deleteFile($galeri_foto->path_image);
            $validatedData['path_image'] = $this->uploadByType($request, 'path_image', $type);
        }

        $validatedData['type'] = $type;
        $galeri_foto->update($validatedData);

        return redirect($this->redirect_path . '?tab=' . $this->tabFromType($type))->with('success', 'Data berhasil diupdate!');
    }

    public function destroy(int $id)
    {
        $galeri_foto = GaleriFoto::findOrFail($id);
        $tab = $this->tabFromType($this->normalizeType($galeri_foto->type));

        $this->deleteFile($galeri_foto->path_image);
        $galeri_foto->delete();

        return redirect($this->redirect_path . '?tab=' . $tab)->with('success', 'Data berhasil dihapus!');
    }
}
