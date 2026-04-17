<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use App\Models\LandingPageTipe;
use App\Models\UrlLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProfilSingkatController extends Controller
{
    private const TAB_META = [
        'tentang-kami' => ['label' => 'Tentang Kami', 'scope' => 'url'],
        'sejarah' => ['label' => 'Sejarah', 'scope' => 'landing'],
        'visi-misi' => ['label' => 'Visi & Misi', 'scope' => 'landing-list'],
        'tugas-fungsi' => ['label' => 'Tugas & Fungsi', 'scope' => 'landing-list'],
        'maskot' => ['label' => 'Maskot', 'scope' => 'url'],
    ];

    private const LANDING_TITLES = [
        'visi' => 'Visi',
        'misi' => 'Misi',
        'sejarah' => 'Sejarah',
        'tugas' => 'Tugas',
        'fungsi' => 'Fungsi',
    ];

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

    protected function uploadImage($file, string $prefix, string $directory): string
    {
        $folder = public_path($directory);

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $filename = slugCustom($prefix) . '-' . time() . '-' . Str::random(6) . '.' . $file->getClientOriginalExtension();
        $file->move($folder, $filename);

        return trim($directory, '/') . '/' . $filename;
    }

    protected function ensureUrlEntry(string $tab): UrlLayanan
    {
        if ($tab === 'tentang-kami') {
            $entry = UrlLayanan::where('name', 'Tentang Kami')->first();

            if (!$entry) {
                $entry = UrlLayanan::find(9);
            }

            if (!$entry) {
                $entry = new UrlLayanan();
            }

            if ($entry->name !== 'Tentang Kami') {
                $entry->name = 'Tentang Kami';
            }

            if ($entry->url === null) {
                $entry->url = '';
            }

            $entry->save();

            return $entry->fresh();
        }

        return UrlLayanan::firstOrCreate(
            ['name' => 'Maskot'],
            ['url' => '']
        );
    }

    protected function ensureLandingEntry(string $key): LandingPage
    {
        $title = self::LANDING_TITLES[$key];
        $type = LandingPageTipe::firstOrCreate(['title' => $title]);

        return LandingPage::firstOrCreate(
            ['landing_page_tipe_id' => $type->id],
            [
                'title' => $title,
                'deskripsi' => '',
                'status' => 1,
            ]
        );
    }

    protected function buildPayload(): array
    {
        return [
            'tabs' => self::TAB_META,
            'urlEntries' => [
                'tentang-kami' => $this->ensureUrlEntry('tentang-kami'),
                'maskot' => $this->ensureUrlEntry('maskot'),
            ],
            'landingEntries' => [
                'sejarah' => $this->ensureLandingEntry('sejarah'),
                'visi' => $this->ensureLandingEntry('visi'),
                'misi' => $this->ensureLandingEntry('misi'),
                'tugas' => $this->ensureLandingEntry('tugas'),
                'fungsi' => $this->ensureLandingEntry('fungsi'),
            ],
        ];
    }

    protected function publicPreviewUrl($entry, string $tab): ?string
    {
        return match ($tab) {
            'tentang-kami' => url('/'),
            'sejarah' => url('/sejarah'),
            'visi-misi' => url('/visi-misi'),
            'tugas-fungsi' => url('/tugas'),
            default => null,
        };
    }

    public function index(Request $request)
    {
        return view('dashboard.profil-singkat.index', array_merge(
            $this->buildPayload(),
            ['activeTab' => $request->query('tab', 'tentang-kami')]
        ));
    }

    public function edit(Request $request, $id)
    {
        $scope = $request->query('scope', 'landing');
        $activeTab = $request->query('tab', 'visi-misi');

        $entry = $scope === 'url'
            ? UrlLayanan::findOrFail($id)
            : LandingPage::findOrFail($id);

        return view('dashboard.profil-singkat.edit', [
            'entry' => $entry,
            'scope' => $scope,
            'activeTab' => $activeTab,
            'previewUrl' => $this->publicPreviewUrl($entry, $activeTab),
        ]);
    }

    public function update(Request $request, $id)
    {
        $scope = $request->input('scope', 'landing');
        $tab = $request->input('tab', 'tentang-kami');

        $rules = [
            'deskripsi' => 'required|string',
            'remove_image' => 'nullable|boolean',
        ];

        if ($scope === 'url') {
            $rules['path_image'] = 'nullable|image|file|max:2048';
            $entry = UrlLayanan::findOrFail($id);
            $imageField = 'path_image';
            $uploadPrefix = $tab;
            $uploadDir = 'uploads/profil';
        } else {
            $rules['path_image'] = 'nullable|image|file|max:2048';
            $entry = LandingPage::findOrFail($id);
            $imageField = 'path';
            $uploadPrefix = $entry->title ?: $tab;
            $uploadDir = 'uploads/landing-page';
        }

        $validated = $request->validate($rules);

        if ($request->boolean('remove_image')) {
            $this->deleteFile($entry->{$imageField});
            $entry->{$imageField} = null;
        }

        if ($request->hasFile('path_image')) {
            $this->deleteFile($entry->{$imageField});
            $entry->{$imageField} = $this->uploadImage($request->file('path_image'), $uploadPrefix, $uploadDir);
        }

        $entry->deskripsi = $validated['deskripsi'];

        if ($entry instanceof LandingPage) {
            $entry->status = 1;
        }

        $entry->save();

        return redirect('/dashboard/profil-singkat?tab=' . $tab)->with('success', 'Data berhasil diupdate!');
    }

    public function uploadAttachment(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:5120|mimes:jpg,jpeg,png,gif,webp',
        ]);

        $file = $request->file('file');
        $filename = 'profil-editor-' . time() . '-' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $dir = public_path('uploads/profil/editor');

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $file->move($dir, $filename);

        return response()->json([
            'url' => asset('uploads/profil/editor/' . $filename),
            'message' => 'Upload berhasil',
        ]);
    }
}
