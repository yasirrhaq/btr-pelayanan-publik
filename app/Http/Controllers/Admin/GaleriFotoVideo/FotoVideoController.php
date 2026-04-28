<?php

namespace App\Http\Controllers\Admin\GaleriFotoVideo;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Functions\ImageUpload;
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

    protected function videoCategories(): array
    {
        return GaleriFoto::VIDEO_CATEGORIES;
    }

    protected function makeUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'galeri-video';
        $slug = $base;
        $counter = 2;

        while (
            GaleriFoto::where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    protected function extractYoutubeUrl(?string $url): ?string
    {
        if (!$url) {
            return null;
        }

        if (!preg_match('~(?:youtube\.com/watch\?v=|youtube\.com/embed/|youtu\.be/)([\w-]{11})~i', trim($url), $matches)) {
            return null;
        }

        return 'https://www.youtube.com/watch?v=' . $matches[1];
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
            return (new ImageUpload())->storeOptimizedPublicImage(
                $request->file($field),
                'uploads/' . $this->path_file_save,
                $request->title ?? 'galeri'
            );
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
        $search = trim((string) request('search'));

        $type = match ($activeTab) {
            'video' => GaleriFoto::TYPE_VIDEO,
            'dokumen' => GaleriFoto::TYPE_DOKUMEN,
            default => GaleriFoto::TYPE_IMAGE,
        };

        $fotoVideo = GaleriFoto::query()
            ->where('type', $type)
            ->when($search !== '', fn ($query) => $query->where('title', 'like', '%' . $search . '%'))
            ->latest()
            ->get();

        return view('dashboard.galeri-foto-video.index', compact('fotoVideo', 'title', 'activeTab', 'search'));
    }

    public function create()
    {
        $activeTab = request('tab', 'foto');
        $videoCategories = $this->videoCategories();

        return view('dashboard.galeri-foto-video.create', compact('activeTab', 'videoCategories'));
    }

    public function store(Request $request)
    {
        $type = $this->normalizeType($request->input('type'));

        $rules = [
            'title' => 'required|max:255',
            'type' => 'required|in:image,video,dokumen',
        ];

        if ($type === GaleriFoto::TYPE_VIDEO) {
            $rules['category'] = 'required|in:' . implode(',', $this->videoCategories());
            $rules['source_type'] = 'required|in:' . GaleriFoto::SOURCE_TYPE_UPLOAD . ',' . GaleriFoto::SOURCE_TYPE_YOUTUBE;
            $rules['path_image'] = 'required_if:source_type,upload|nullable|file|max:51200|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/webm';
            $rules['source_url'] = 'required_if:source_type,youtube|nullable|url';
        } else {
            $rules['path_image'] = match ($type) {
            'dokumen' => 'required|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx',
                default => 'required|image|file|max:12288',
            };
        }

        $validatedData = $request->validate($rules);
        $validatedData['type'] = $type;
        $validatedData['created_by'] = auth()->id();
        $validatedData['slug'] = $this->makeUniqueSlug($validatedData['title']);

        if ($type === GaleriFoto::TYPE_VIDEO) {
            if (($validatedData['source_type'] ?? null) === GaleriFoto::SOURCE_TYPE_YOUTUBE) {
                $validatedData['source_url'] = $this->extractYoutubeUrl($validatedData['source_url'] ?? null);
                if (!$validatedData['source_url']) {
                    return back()->withInput()->withErrors([
                        'source_url' => 'URL YouTube tidak valid.',
                    ]);
                }
                $validatedData['path_image'] = null;
            } else {
                $validatedData['path_image'] = $this->uploadByType($request, 'path_image', $type);
                $validatedData['source_url'] = null;
            }
        } else {
            $validatedData['path_image'] = $this->uploadByType($request, 'path_image', $type);
            $validatedData['category'] = null;
            $validatedData['source_type'] = null;
            $validatedData['source_url'] = null;
        }

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
        $videoCategories = $this->videoCategories();

        return view('dashboard.galeri-foto-video.edit', compact('galeri_foto', 'videoCategories'));
    }

    public function update(Request $request, int $id)
    {
        $galeri_foto = GaleriFoto::where('id', $id)->firstOrFail();
        $type = $this->normalizeType($request->input('type', $galeri_foto->type));

        $rules = [
            'title' => 'required|max:255',
            'type' => 'required|in:image,video,dokumen',
        ];

        if ($type === GaleriFoto::TYPE_VIDEO) {
            $nextSourceType = $request->input('source_type', $galeri_foto->source_type ?: GaleriFoto::SOURCE_TYPE_UPLOAD);
            $videoFileRule = $nextSourceType === GaleriFoto::SOURCE_TYPE_UPLOAD && !$galeri_foto->path_image ? 'required' : 'nullable';
            $rules['category'] = 'required|in:' . implode(',', $this->videoCategories());
            $rules['source_type'] = 'required|in:' . GaleriFoto::SOURCE_TYPE_UPLOAD . ',' . GaleriFoto::SOURCE_TYPE_YOUTUBE;
            $rules['path_image'] = $videoFileRule . '|file|max:51200|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/webm';
            $rules['source_url'] = 'required_if:source_type,youtube|nullable|url';
        } else {
            $rules['path_image'] = match ($type) {
            'dokumen' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx',
                default => 'nullable|image|file|max:12288',
            };
        }

        $validatedData = $request->validate($rules);

        $validatedData['type'] = $type;

        if (!$galeri_foto->slug) {
            $validatedData['slug'] = $this->makeUniqueSlug($validatedData['title'], $galeri_foto->id);
        }

        if ($type === GaleriFoto::TYPE_VIDEO) {
            if (($validatedData['source_type'] ?? null) === GaleriFoto::SOURCE_TYPE_YOUTUBE) {
                if ($galeri_foto->path_image) {
                    $this->deleteFile($galeri_foto->path_image);
                }

                $validatedData['path_image'] = null;
                $validatedData['source_url'] = $this->extractYoutubeUrl($validatedData['source_url'] ?? null);
                if (!$validatedData['source_url']) {
                    return back()->withInput()->withErrors([
                        'source_url' => 'URL YouTube tidak valid.',
                    ]);
                }
            } else {
                if ($request->hasFile('path_image')) {
                    $this->deleteFile($galeri_foto->path_image);
                    $validatedData['path_image'] = $this->uploadByType($request, 'path_image', $type);
                }

                $validatedData['source_url'] = null;
            }
        } else {
            if ($request->hasFile('path_image')) {
                $this->deleteFile($galeri_foto->path_image);
                $validatedData['path_image'] = $this->uploadByType($request, 'path_image', $type);
            }

            $validatedData['category'] = null;
            $validatedData['source_type'] = null;
            $validatedData['source_url'] = null;
        }

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
