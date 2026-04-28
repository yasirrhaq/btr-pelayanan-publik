<?php

namespace App\Http\Controllers;

use App\Models\GaleriFoto;
use Illuminate\Pagination\LengthAwarePaginator;

class VideoController extends Controller
{
    public function index()
    {
        $search = trim((string) request('search'));
        $category = trim((string) request('category'));
        $page = max(1, (int) request('page', 1));
        $perPage = 8;

        $allowedCategories = GaleriFoto::VIDEO_CATEGORIES;

        if (!in_array($category, $allowedCategories, true)) {
            $category = '';
        }

        $videos = GaleriFoto::query()
            ->where('type', GaleriFoto::TYPE_VIDEO)
            ->when($category !== '', fn ($query) => $query->where('category', $category))
            ->when($search !== '', fn ($query) => $query->where('title', 'like', '%' . $search . '%'))
            ->latest()
            ->get();

        $galeriVideo = new LengthAwarePaginator(
            $videos->forPage($page, $perPage)->values(),
            $videos->count(),
            $perPage,
            $page,
            [
                'path' => url('/video'),
                'query' => array_filter([
                    'search' => $search !== '' ? $search : null,
                    'category' => $category !== '' ? $category : null,
                ]),
            ]
        );

        return view('frontend.video', [
            'title' => 'Video',
            'galeriVideo' => $galeriVideo,
            'search' => $search,
            'category' => $category,
            'videoCategories' => $allowedCategories,
            'totalVideos' => $videos->count(),
        ]);
    }

    public function embed(string $slug)
    {
        $video = GaleriFoto::query()
            ->where('type', GaleriFoto::TYPE_VIDEO)
            ->where('slug', $slug)
            ->firstOrFail();

        return view('frontend.video-embed', [
            'video' => $video,
            'title' => $video->title,
        ]);
    }
}
