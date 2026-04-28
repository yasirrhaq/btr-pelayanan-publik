<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use App\Models\LandingPageTipe;
use App\Support\PpidSections;
use Illuminate\Support\Collection;

class PublicPpidController extends Controller
{
    protected function sections(): Collection
    {
        $allTitles = collect(PpidSections::all())
            ->flatMap(fn ($meta, $key) => PpidSections::aliasesFor($key))
            ->unique()
            ->values()
            ->all();

        $typeModels = LandingPageTipe::whereIn('title', $allTitles)->get()->keyBy('title');

        $entries = LandingPage::whereIn('landing_page_tipe_id', $typeModels->pluck('id')->all())
            ->where('status', 1)
            ->get()
            ->keyBy('landing_page_tipe_id');

        return collect(PpidSections::all())->map(function ($meta, $key) use ($typeModels, $entries) {
            $type = collect(PpidSections::aliasesFor($key))
                ->map(fn ($title) => $typeModels->get($title))
                ->first();

            $entry = $type ? $entries->get($type->id) : null;

            return [
                'key' => $key,
                'title' => $entry->title ?? $meta['type_title'],
                'badge' => $meta['badge'],
                'eyebrow' => $meta['public_eyebrow'],
                'summary' => $meta['public_summary'],
                'accent' => $meta['public_accent'],
                'icon' => $meta['public_icon'],
                'href' => route('ppid.show', $key),
                'deskripsi' => $entry->deskripsi ?? null,
                'path' => $entry->path ?? null,
                'hasContent' => filled($entry?->deskripsi) || filled($entry?->path),
            ];
        });
    }

    public function index()
    {
        return view('frontend.ppid.index', [
            'sections' => $this->sections(),
        ]);
    }

    public function show(string $slug)
    {
        $sections = $this->sections();
        abort_unless($sections->has($slug), 404);

        return view('frontend.ppid.show', [
            'currentSection' => $sections->get($slug),
            'sections' => $sections,
        ]);
    }
}
