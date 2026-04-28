<?php

namespace App\Http\Controllers;

use App\Models\GaleriFoto;
use App\Models\Pengumuman;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class PublicDokumenController extends Controller
{
    public function index(Request $request)
    {
        $items = collect()
            ->merge($this->collectPengumumanDocuments())
            ->merge($this->collectBeritaDocuments())
            ->merge($this->collectGaleriDocuments())
            ->sortByDesc('published_at')
            ->values();

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 6;
        $paginated = new LengthAwarePaginator(
            $items->slice(($currentPage - 1) * $perPage, $perPage)->values(),
            $items->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('frontend.dokumen', [
            'dokumen' => $paginated,
            'dokumenCount' => $items->count(),
        ]);
    }

    protected function collectPengumumanDocuments(): Collection
    {
        return Pengumuman::published()
            ->whereNotNull('lampiran_path')
            ->latest()
            ->get()
            ->map(function (Pengumuman $item) {
                $url = asset('storage/' . $item->lampiran_path);

                return $this->makeDocumentItem([
                    'title' => $item->judul,
                    'summary' => Str::limit(strip_tags($item->isi), 140),
                    'source' => 'Pengumuman',
                    'url' => $url,
                    'filename' => basename($item->lampiran_path),
                    'published_at' => $item->created_at,
                    'page_url' => route('pengumuman.show', $item),
                ]);
            });
    }

    protected function collectGaleriDocuments(): Collection
    {
        return GaleriFoto::query()
            ->where('type', 'dokumen')
            ->latest()
            ->get()
            ->map(function (GaleriFoto $item) {
                $url = Str::startsWith($item->path_image, ['http://', 'https://'])
                    ? $item->path_image
                    : asset(ltrim($item->path_image, '/'));

                return $this->makeDocumentItem([
                    'title' => $item->title,
                    'summary' => 'Dokumen publik Balai Teknik Rawa.',
                    'source' => 'Galeri Dokumen',
                    'url' => $url,
                    'filename' => basename(parse_url($url, PHP_URL_PATH) ?: $item->path_image),
                    'published_at' => $item->created_at,
                    'page_url' => $url,
                ]);
            });
    }

    protected function collectBeritaDocuments(): Collection
    {
        $documents = collect();

        Post::latest()->get()->each(function (Post $post) use (&$documents) {
            if ($post->lampiran_path) {
                $documents->push($this->makeDocumentItem([
                    'title' => $post->title,
                    'summary' => Str::limit(strip_tags($post->excerpt ?: $post->body), 140),
                    'source' => 'Berita',
                    'url' => asset('storage/' . $post->lampiran_path),
                    'filename' => basename($post->lampiran_path),
                    'published_at' => $post->created_at,
                    'page_url' => url('/berita/' . $post->slug),
                ]));

                return;
            }

            preg_match_all('/<a[^>]+href=["\']([^"\']+\.(?:pdf|doc|docx|xls|xlsx|ppt|pptx))(?:\?[^"\']*)?["\']/i', $post->body ?? '', $matches);

            foreach (($matches[1] ?? []) as $href) {
                $url = Str::startsWith($href, ['http://', 'https://'])
                    ? $href
                    : url(ltrim($href, '/'));

                $documents->push($this->makeDocumentItem([
                    'title' => $post->title,
                    'summary' => Str::limit(strip_tags($post->excerpt ?: $post->body), 140),
                    'source' => 'Berita',
                    'url' => $url,
                    'filename' => basename(parse_url($url, PHP_URL_PATH) ?: $href),
                    'published_at' => $post->created_at,
                    'page_url' => url('/berita/' . $post->slug),
                ]));
            }
        });

        return $documents->unique('url')->values();
    }

    protected function makeDocumentItem(array $data): array
    {
        $path = parse_url($data['url'], PHP_URL_PATH) ?: $data['url'];
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        return [
            'title' => $data['title'],
            'summary' => $data['summary'],
            'source' => $data['source'],
            'url' => $data['url'],
            'filename' => $data['filename'],
            'extension' => $extension,
            'published_at' => $data['published_at'],
            'page_url' => $data['page_url'],
        ];
    }
}
