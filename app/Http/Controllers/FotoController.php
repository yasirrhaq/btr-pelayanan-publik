<?php

namespace App\Http\Controllers;

use App\Models\GaleriFoto;
use App\Models\Pengumuman;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class FotoController extends Controller
{
    public function index()
    {
        $category = trim((string) request('category', ''));
        $search = trim((string) request('search', ''));
        $perPage = 8;

        $items = $this->collectGalleryItems()
            ->when($category !== '', function (Collection $collection) use ($category) {
                return $collection->where('category', $category)->values();
            })
            ->when($search !== '', function (Collection $collection) use ($search) {
                $needle = Str::lower($search);

                return $collection->filter(function (array $item) use ($needle) {
                    return Str::contains(Str::lower($item['title']), $needle)
                        || Str::contains(Str::lower($item['source_title']), $needle);
                })->values();
            })
            ->sortByDesc('published_at')
            ->values();

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $paginated = new LengthAwarePaginator(
            $items->slice(($currentPage - 1) * $perPage, $perPage)->values(),
            $items->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        return view('frontend.foto', [
            'title' => 'Foto',
            'galeri_foto' => $paginated,
            'selectedCategory' => $category,
            'search' => $search,
            'categories' => [
                '' => 'Semua Kategori',
                'galeri' => 'Galeri',
                'berita' => 'Berita',
                'pengumuman' => 'Pengumuman',
            ],
        ]);
    }

    protected function collectGalleryItems(): Collection
    {
        return $this->collectAdminGalleryPhotos()
            ->concat($this->collectBeritaPhotos())
            ->concat($this->collectPengumumanPhotos())
            ->unique(fn (array $item) => $item['source_key'] . '|' . $item['image_url'])
            ->values();
    }

    protected function collectAdminGalleryPhotos(): Collection
    {
        return GaleriFoto::query()
            ->where(function ($query) {
                $query->where('type', 'image')
                    ->orWhereNull('type');
            })
            ->latest()
            ->get()
            ->map(function (GaleriFoto $item) {
                return [
                    'title' => $item->title,
                    'source_title' => $item->title,
                    'image_url' => imageExists($item->path_image ?: 'assets/fotoDumy.jpeg'),
                    'category' => 'galeri',
                    'category_label' => 'Galeri',
                    'published_at' => $item->created_at,
                    'views' => null,
                    'detail_url' => null,
                    'source_key' => 'galeri:' . $item->id,
                ];
            });
    }

    protected function collectBeritaPhotos(): Collection
    {
        return Post::query()
            ->latest()
            ->get()
            ->flatMap(function (Post $post) {
                $items = collect();
                $detailUrl = url('/berita/' . $post->slug);

                if (!empty($post->image)) {
                    $items->push([
                        'title' => $post->title,
                        'source_title' => $post->title,
                        'image_url' => imageExists($post->image),
                        'category' => 'berita',
                        'category_label' => 'Berita',
                        'published_at' => $post->publish_at ?: $post->created_at,
                        'views' => null,
                        'detail_url' => $detailUrl,
                        'source_key' => 'berita-cover:' . $post->id,
                    ]);
                }

                return $items->concat(
                    $this->extractImagesFromHtml($post->body, 'berita', 'Berita', $post->title, $detailUrl, $post->publish_at ?: $post->created_at, 'berita-body:' . $post->id)
                );
            });
    }

    protected function collectPengumumanPhotos(): Collection
    {
        return Pengumuman::published()
            ->latest()
            ->get()
            ->flatMap(function (Pengumuman $pengumuman) {
                $items = collect();
                $detailUrl = route('pengumuman.show', $pengumuman);

                if (!empty($pengumuman->thumbnail_path)) {
                    $items->push([
                        'title' => $pengumuman->judul,
                        'source_title' => $pengumuman->judul,
                        'image_url' => $pengumuman->thumbnailUrl(),
                        'category' => 'pengumuman',
                        'category_label' => 'Pengumuman',
                        'published_at' => $pengumuman->created_at,
                        'views' => $pengumuman->views,
                        'detail_url' => $detailUrl,
                        'source_key' => 'pengumuman-thumb:' . $pengumuman->id,
                    ]);
                }

                return $items->concat(
                    $this->extractImagesFromHtml($pengumuman->isi, 'pengumuman', 'Pengumuman', $pengumuman->judul, $detailUrl, $pengumuman->created_at, 'pengumuman-body:' . $pengumuman->id, $pengumuman->views)
                );
            });
    }

    protected function extractImagesFromHtml(
        ?string $html,
        string $category,
        string $categoryLabel,
        string $sourceTitle,
        ?string $detailUrl,
        $publishedAt,
        string $sourceKey,
        ?int $views = null
    ): Collection {
        if (blank($html)) {
            return collect();
        }

        preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $matches);

        return collect($matches[1] ?? [])
            ->map(fn (string $src) => $this->normalizeImageUrl($src))
            ->filter()
            ->values()
            ->map(function (string $url, int $index) use ($category, $categoryLabel, $sourceTitle, $detailUrl, $publishedAt, $sourceKey, $views) {
                return [
                    'title' => $sourceTitle . (Str::contains($sourceTitle, 'Foto ') ? '' : ' - Foto ' . ($index + 1)),
                    'source_title' => $sourceTitle,
                    'image_url' => $url,
                    'category' => $category,
                    'category_label' => $categoryLabel,
                    'published_at' => $publishedAt,
                    'views' => $views,
                    'detail_url' => $detailUrl,
                    'source_key' => $sourceKey . ':' . $index,
                ];
            });
    }

    protected function normalizeImageUrl(?string $src): ?string
    {
        $src = trim((string) $src);

        if ($src === '' || Str::startsWith($src, 'data:')) {
            return null;
        }

        if (Str::startsWith($src, ['http://', 'https://'])) {
            return $this->isSupportedImagePath($src) ? $src : null;
        }

        if (Str::startsWith($src, '//')) {
            $url = 'https:' . $src;

            return $this->isSupportedImagePath($url) ? $url : null;
        }

        $path = ltrim($src, '/');

        if (!$this->isSupportedImagePath($path)) {
            return null;
        }

        return asset($path);
    }

    protected function isSupportedImagePath(string $path): bool
    {
        $extension = strtolower(pathinfo(parse_url($path, PHP_URL_PATH) ?: $path, PATHINFO_EXTENSION));

        return in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'], true);
    }
}
