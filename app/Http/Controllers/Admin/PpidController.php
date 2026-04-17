<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use App\Models\LandingPageTipe;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PpidController extends Controller
{
    private const TYPES = [
        'kebijakan-ppid' => 'Kebijakan PPID',
        'info-berkala' => 'Info Berkala',
        'info-serta-merta' => 'Info Serta Merta',
        'info-setiap-saat' => 'Info Setiap Saat',
    ];

    protected function ensureTypes()
    {
        $types = collect();

        foreach (self::TYPES as $key => $title) {
            $type = LandingPageTipe::firstOrCreate(['title' => $title]);
            $types->put($key, $type);
        }

        return $types;
    }

    protected function uploadFile(Request $request, string $field): ?string
    {
        if (!$request->hasFile($field)) {
            return null;
        }

        $file = $request->file($field);
        $filename = 'ppid-' . time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
        $dir = public_path('uploads/ppid');

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $file->move($dir, $filename);

        return 'uploads/ppid/' . $filename;
    }

    public function uploadAttachment(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:5120|mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx',
        ]);

        $file = $request->file('file');
        $filename = 'ppid-editor-' . time() . '-' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $dir = public_path('uploads/ppid/editor');

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $file->move($dir, $filename);

        $url = asset('uploads/ppid/editor/' . $filename);

        return response()->json([
            'uploaded' => 1,
            'fileName' => $filename,
            'url' => $url,
            'href' => $url,
        ]);
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

    public function index()
    {
        $types = $this->ensureTypes();
        $entries = LandingPage::whereIn('landing_page_tipe_id', $types->pluck('id')->all())->get()->keyBy('landing_page_tipe_id');

        return view('dashboard.ppid.index', [
            'types' => $types,
            'entries' => $entries,
            'activeTab' => request('tab', 'kebijakan-ppid'),
        ]);
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'ppid_type' => 'required|in:' . implode(',', array_keys(self::TYPES)),
            'title' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'dokumen' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,webp',
            'remove_dokumen' => 'nullable|boolean',
        ]);

        $types = $this->ensureTypes();
        $type = $types[$validated['ppid_type']];

        $entry = LandingPage::firstOrNew(['landing_page_tipe_id' => $type->id]);
        $entry->title = $validated['title'];
        $entry->deskripsi = $validated['deskripsi'];
        $entry->status = 1;

        if ($request->boolean('remove_dokumen')) {
            $this->deleteFile($entry->path);
            $entry->path = null;
        }

        if ($request->hasFile('dokumen')) {
            $this->deleteFile($entry->path);
            $entry->path = $this->uploadFile($request, 'dokumen');
        }

        $entry->save();

        return redirect()->route('admin.ppid.index', ['tab' => $validated['ppid_type']])->with('success', 'PPID berhasil disimpan.');
    }
}
